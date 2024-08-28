<?php
// Include your database connection
include '../../controller/conn.php';

// Path to the SQL file
$sqlFile = 'tables_backup.sql';

// Read the SQL file content
$sqlContent = file_get_contents($sqlFile);

// Check if the file was read successfully
if ($sqlContent === false) {
    die("Failed to read SQL file.");
}

// Split SQL file content into individual queries
$queries = array_filter(array_map('trim', explode(';', $sqlContent)));

// Execute each query
foreach ($queries as $query) {
    if (!empty($query)) {
        try {
            $pdo->exec($query);
        } catch (PDOException $e) {
            echo "Error executing query: " . htmlspecialchars($query) . "<br>";
            echo "Exception message: " . $e->getMessage() . "<br>";
        }
    }
}

echo "Database tables imported successfully.";
?>