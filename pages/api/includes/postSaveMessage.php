<?php
// Assuming you have already established a PDO connection in $pdo
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    // If no data is received or the data is invalid
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "error" => "Invalid JSON data received"]);
    exit;
}

// Insert into webhook_events table
$stmt = $pdo->prepare("INSERT INTO webhook_events (id, event, session, engine, environment_version, environment_engine, environment_tier, environment_browser) VALUES (:id, :event, :session, :engine, :environment_version, :environment_engine, :environment_tier, :environment_browser)");
$stmt->bindParam(':id', $data['id']);
$stmt->bindParam(':event', $data['event']);
$stmt->bindParam(':session', $data['session']);
$stmt->bindParam(':engine', $data['engine']);
$stmt->bindParam(':environment_version', $data['environment']['version']);
$stmt->bindParam(':environment_engine', $data['environment']['engine']);
$stmt->bindParam(':environment_tier', $data['environment']['tier']);
$stmt->bindParam(':environment_browser', $data['environment']['browser']);
$stmt->execute();

http_response_code(200); // OK
echo json_encode(["status" => "success", "message" => "Data successfully processed".$data['id']]);

// // Insert into webhook_users table
// $stmt = $pdo->prepare("INSERT INTO webhook_users (id, pushName) VALUES (:id, :pushName)");
// $stmt->bindParam(':id', $data['me']['id']);
// $stmt->bindParam(':pushName', $data['me']['pushName']);
// $stmt->execute();

// // Insert into webhook_payloads table
// $payload = $data['payload'];
// $stmt = $pdo->prepare("INSERT INTO webhook_payloads (id, event_id, timestamp, from_user, to_user, body, hasMedia, ack, ackName) VALUES (:id, :event_id, :timestamp, :from_user, :to_user, :body, :hasMedia, :ack, :ackName)");
// $stmt->bindParam(':id', $payload['id']);
// $stmt->bindParam(':event_id', $data['id']);
// $stmt->bindParam(':timestamp', $payload['timestamp']);
// $stmt->bindParam(':from_user', $payload['from']);
// $stmt->bindParam(':to_user', $payload['to']);
// $stmt->bindParam(':body', $payload['body']);
// $stmt->bindParam(':hasMedia', $payload['hasMedia']);
// $stmt->bindParam(':ack', $payload['ack']);
// $stmt->bindParam(':ackName', $payload['ackName']);
// $stmt->execute();

// // Insert into webhook_message_data table
// $msg_data = $payload['_data'];
// $stmt = $pdo->prepare("INSERT INTO webhook_message_data (id, payload_id, viewed, message_body, message_type, timestamp, notifyName, from_user, to_user, ack, invis, isNewMsg, star, kicNotified, recvFresh, isFromTemplate, labels) VALUES (:id, :payload_id, :viewed, :message_body, :message_type, :timestamp, :notifyName, :from_user, :to_user, :ack, :invis, :isNewMsg, :star, :kicNotified, :recvFresh, :isFromTemplate, :labels)");
// $stmt->bindParam(':id', $msg_data['id']);
// $stmt->bindParam(':payload_id', $payload['id']);
// $stmt->bindParam(':viewed', $msg_data['viewed']);
// $stmt->bindParam(':message_body', $msg_data['body']);
// $stmt->bindParam(':message_type', $msg_data['type']);
// $stmt->bindParam(':timestamp', $msg_data['t']);
// $stmt->bindParam(':notifyName', $msg_data['notifyName']);
// $stmt->bindParam(':from_user', $msg_data['from']);
// $stmt->bindParam(':to_user', $msg_data['to']);
// $stmt->bindParam(':ack', $msg_data['ack']);
// $stmt->bindParam(':invis', $msg_data['invis']);
// $stmt->bindParam(':isNewMsg', $msg_data['isNewMsg']);
// $stmt->bindParam(':star', $msg_data['star']);
// $stmt->bindParam(':kicNotified', $msg_data['kicNotified']);
// $stmt->bindParam(':recvFresh', $msg_data['recvFresh']);
// $stmt->bindParam(':isFromTemplate', $msg_data['isFromTemplate']);
// $stmt->bindParam(':labels', implode(",", $msg_data['labels'])); // Converting array to comma-separated string
// $stmt->execute();

// // Insert webhook_message_secrets table
// $stmt = $pdo->prepare("INSERT INTO webhook_message_secrets (message_data_id, secret) VALUES (:message_data_id, :secret)");
// $stmt->bindParam(':message_data_id', $msg_data['id']);
// $stmt->bindParam(':secret', json_encode($msg_data['messageSecret'])); // Encoding the secret field as JSON
// $stmt->execute();

// // Close the PDO connection (optional, as it will be closed when the script ends)
// $pdo = null;
?>