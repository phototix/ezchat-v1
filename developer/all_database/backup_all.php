<?php
// Database connection details
$conn_mysql_host = "db.gateway.01.webbypage.com";
$conn_mysql_username = "root";
$conn_mysql_password = "#Abccy1982#";

// Track current database (used to resume after page refresh)
$current_db = isset($_GET['current_db']) ? $_GET['current_db'] : null;

// Connect to MySQL server
$conn = new mysqli($conn_mysql_host, $conn_mysql_username, $conn_mysql_password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to MySQL server<br>";

// Get all databases
$databases = $conn->query("SHOW DATABASES");

$skip_database = array("information_schema", "mysql", "sys", "");

if(in_array($current_db, $skip_database)){
    exit();
}

if ($databases->num_rows > 0) {
    $next_db = null; // To track the next database to backup
    
    // Loop through each database
    while ($db = $databases->fetch_assoc()) {
        $database_name = $db['Database'];
        
        // Check if this is the database we need to process after refresh
        if ($current_db && $database_name !== $current_db) {
            continue; // Skip until we find the correct database to resume from
        }
        
        // Reset current_db after processing the first (or only) match
        $current_db = null;

        echo "Processing database: " . $database_name . "<br>";

        // Check if backup file already exists
        $backup_file = __DIR__ . '/' . $database_name . '_backup.sql';
        if (file_exists($backup_file)) {
            echo "Backup for $database_name already exists. Skipping...<br>";
            continue; // Skip to the next database
        }

        // Select the database
        $conn->select_db($database_name);

        // Initialize SQL dump string
        $sql_dump = "-- Database: $database_name<br><br>";

        // Get all tables in the selected database
        $tables = $conn->query("SHOW TABLES");
        if ($tables->num_rows > 0) {
            while ($table = $tables->fetch_row()) {
                $table_name = $table[0];

                // Get table structure (CREATE TABLE statement)
                $table_structure = $conn->query("SHOW CREATE TABLE `$table_name`")->fetch_assoc();
                $sql_dump .= "-- Table structure for table `$table_name`<br>";
                $sql_dump .= str_replace("\n", "<br>", $table_structure['Create Table']) . ";<br><br>";

                // Get table data
                $sql_dump .= "-- Dumping data for table `$table_name`<br>";
                $result = $conn->query("SELECT * FROM `$table_name`");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $values = array_map(function($value) use ($conn) {
                            return "'" . $conn->real_escape_string($value) . "'";
                        }, array_values($row));

                        $sql_dump .= "INSERT INTO `$table_name` VALUES (" . implode(", ", $values) . ");<br>";
                    }
                }
                $sql_dump .= "<br>";
            }

            // Save SQL dump to file
            if (file_put_contents($backup_file, $sql_dump)) {
                echo "Backup of database $database_name created successfully in $backup_file<br>";
            } else {
                echo "Error creating backup of database $database_name<br>";
            }
        } else {
            file_put_contents($backup_file, "");
            echo "No tables found in database $database_name<br>";
            echo "Create of database $database_name with empty table successfully in $backup_file<br>";
        }

        // Set the next database for page refresh
        $next_db = $database_name;
        
        // Refresh the page after each successful database backup
        echo "<br><strong>Refreshing page for the next database backup...</strong><br>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '?current_db=" . urlencode($next_db) . "';
                }, 1000); // 1-second delay before refresh
              </script>";
        exit(); // Stop execution to allow page refresh
    }
} else {
    echo "No databases found<br>";
}

// Close the connection
$conn->close();
?>
