<?php
// Include your database connection
include '../../controller/conn.php';

// Set the output file
$outputFile = 'tables_backup.sql';

// Function to escape values
function escapeValue($value, $pdo) {
    return $pdo->quote($value);
}

// Open file for writing
$fileHandle = fopen($outputFile, 'w');

// Check if the file opened successfully
if ($fileHandle === false) {
    die("Failed to open file for writing.");
}

// Retrieve all table names
try {
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        // Write CREATE TABLE statement
        $createTableStmt = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
        fwrite($fileHandle, "\n-- Table structure for `$table`\n");
        fwrite($fileHandle, "DROP TABLE IF EXISTS `$table`;\n");
        fwrite($fileHandle, $createTableStmt['Create Table'] . ";\n\n");

        // Write INSERT INTO statements
        $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        if (count($rows) > 0) {
            $columns = array_keys($rows[0]);
            foreach ($rows as $row) {
                $values = array_map(function($value) use ($pdo) {
                    return escapeValue($value, $pdo);
                }, array_values($row));
                $sql = sprintf(
                    "INSERT INTO `%s` (%s) VALUES (%s);\n",
                    $table,
                    implode(', ', array_map(function($col) { return "`$col`"; }, $columns)),
                    implode(', ', $values)
                );
                fwrite($fileHandle, $sql);
            }
        }
        fwrite($fileHandle, "\n");
    }
    
    fclose($fileHandle);
    echo "Database tables exported successfully to $outputFile.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
