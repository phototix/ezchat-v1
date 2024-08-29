<?php
// Include database connection
include 'controller/conn.php';

// Get the raw POST data
$input = file_get_contents('php://input');

// Decode the JSON payload
$payload = json_decode($input, true);

// Check if the payload is not empty
if (!empty($payload)) {
    // Extract the necessary data from the payload
    // Assuming the payload contains these fields, adjust as necessary based on your payload structure
    $message_id = $payload['message']['id'] ?? null;
    $message_text = $payload['message']['text'] ?? null;
    $from_number = $payload['message']['from'] ?? null;
    $timestamp = $payload['message']['timestamp'] ?? null;
    $event_type = $payload['event'] ?? null;

    // Prepare the SQL statement to insert the data
    $sql = "INSERT INTO whatsapp_messages (message_id, message_text, from_number, timestamp, event_type) 
            VALUES (:message_id, :message_text, :from_number, :timestamp, :event_type)";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':message_id', $message_id);
    $stmt->bindParam(':message_text', $message_text);
    $stmt->bindParam(':from_number', $from_number);
    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->bindParam(':event_type', $event_type);

    // Execute the statement
    if ($stmt->execute()) {
        // Send a 200 OK response
        http_response_code(200);
        echo json_encode(['status' => 'success']);
    } else {
        // Send a 500 Internal Server Error response
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} else {
    // Send a 400 Bad Request response
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid payload']);
}
?>
