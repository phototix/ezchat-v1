<?php
// Include database connection
include 'controller/conn.php';

// Capture raw POST data
$rawData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($rawData, true);

// Validate and extract necessary fields
$event = $data['event'] ?? '';
$session = $data['session'] ?? '';
$userId = $data['metadata']['user.id'] ?? '';
$userEmail = $data['metadata']['user.email'] ?? '';
$meId = $data['me']['id'] ?? '';
$mePushName = $data['me']['pushName'] ?? '';
$environmentTier = $data['environment']['tier'] ?? '';
$environmentVersion = $data['environment']['version'] ?? '';
$engine = $data['engine'] ?? '';

// Prepare SQL query to insert data into webhook_logs table
$sql = "INSERT INTO webhook_logs (payload)
        VALUES ('$rawData')";

try {
    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    
    // Return success response
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    // Return error response
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
