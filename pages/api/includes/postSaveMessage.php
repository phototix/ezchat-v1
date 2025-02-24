<?php
// Assuming you have already established a PDO connection in $pdo
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    // If no data is received or the data is invalid
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "error" => "Invalid JSON data received"]);
    exit;
}

// Insert into webhook_payloads table
$session = $data['session'];
$payload = $data['payload'];
$msg_data = $payload['_data'];
$notifyName = $msg_data['notifyName'];

$stmt = $pdo->prepare("INSERT INTO webhook_payloads (id, event_id, timestamp, from_user, to_user, body, hasMedia, ack, ackName, session, notifyName) VALUES (:id, :event_id, :timestamp, :from_user, :to_user, :body, :hasMedia, :ack, :ackName, :session, :notifyName)");
$stmt->bindParam(':id', $payload['id']);
$stmt->bindParam(':event_id', $data['id']);
$stmt->bindParam(':timestamp', $payload['timestamp']);
$stmt->bindParam(':session', $session);
$stmt->bindParam(':from_user', $payload['from']);
$stmt->bindParam(':notifyName', $notifyName);
$stmt->bindParam(':to_user', $payload['to']);
$stmt->bindParam(':body', $payload['body']);
$stmt->bindParam(':hasMedia', $payload['hasMedia']);
$stmt->bindParam(':ack', $payload['ack']);
$stmt->bindParam(':ackName', $payload['ackName']);
$stmt->execute();

http_response_code(200); // OK
echo json_encode(["status" => "success", "message" => "Data successfully processed. ID:".$data['id']]);

// Close the PDO connection (optional, as it will be closed when the script ends)
$pdo = null;
?>