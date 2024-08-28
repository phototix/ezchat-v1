<?php
// Include your database connection
include '../../controller/conn.php';

// Path to the SQL file containing the desired schema
$sqlFile = 'tables_backup.sql';

// Create database if it does not exist
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS db_ezchat");
    $pdo->exec("USE db_ezchat");
    echo "Database 'db_ezchat' created or already exists.<br>";
} catch (PDOException $e) {
    die("Failed to create or select database: " . $e->getMessage());
}

// Read the SQL file content
$sqlContent = file_get_contents($sqlFile);

// Check if the file was read successfully
if ($sqlContent === false) {
    die("Failed to read SQL file.");
}

// Split SQL file content into individual queries
$queries = array_filter(array_map('trim', explode(';', $sqlContent)));

// Get the current table schema from the database
function getTableSchema($pdo, $tableName) {
    $stmt = $pdo->query("DESCRIBE $tableName");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Compare schema and update if necessary
function updateSchema($pdo, $tableName, $sqlQuery) {
    try {
        $pdo->exec($sqlQuery);
        echo "Table '$tableName' updated successfully.<br>";
    } catch (PDOException $e) {
        echo "Error updating table '$tableName': " . $e->getMessage() . "<br>";
    }
}

// Extract table creation queries from SQL content
foreach ($queries as $query) {
    if (preg_match('/^CREATE TABLE `(\w+)`/', $query, $matches)) {
        $tableName = $matches[1];
        $currentSchema = getTableSchema($pdo, $tableName);

        // Check if the schema needs updating
        $expectedSchema = [];
        $createTableQuery = $query . ';';

        // Extract the expected columns from the create table query
        if (preg_match_all('/`(\w+)` (\w+)(\(\d+\))?/', $createTableQuery, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $expectedSchema[$match[1]] = $match[2] . ($match[3] ?? '');
            }
        }

        // Check if the current schema matches the expected schema
        $currentSchemaMap = [];
        foreach ($currentSchema as $column) {
            $currentSchemaMap[$column['Field']] = $column['Type'];
        }

        // Determine columns that need to be updated or added
        foreach ($expectedSchema as $column => $type) {
            if (!isset($currentSchemaMap[$column]) || $currentSchemaMap[$column] !== $type) {
                // Update column or add it
                $updateQuery = "ALTER TABLE `$tableName` ADD COLUMN `$column` $type;";
                updateSchema($pdo, $tableName, $updateQuery);
            }
        }
    }
}

echo "Schema update process completed.";
?>
