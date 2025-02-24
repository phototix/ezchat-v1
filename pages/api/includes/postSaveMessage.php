<?php
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    // If no data is received or the data is invalid
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "error" => "Invalid JSON data received"]);
    exit;
}

echo "test";

// Insert into webhook_events table
$stmt = $mysqli->prepare("INSERT INTO webhook_events (id, event, session, engine, environment_version, environment_engine, environment_tier, environment_browser) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $data['id'], $data['event'], $data['session'], $data['engine'], $data['environment']['version'], $data['environment']['engine'], $data['environment']['tier'], $data['environment']['browser']);
$stmt->execute();
$stmt->close();

// Insert into webhook_users table
$stmt = $mysqli->prepare("INSERT INTO webhook_users (id, pushName) VALUES (?, ?)");
$stmt->bind_param("ss", $data['me']['id'], $data['me']['pushName']);
$stmt->execute();
$stmt->close();

// Insert into webhook_payloads table
$payload = $data['payload'];
$stmt = $mysqli->prepare("INSERT INTO webhook_payloads (id, event_id, timestamp, from_user, to_user, body, hasMedia, ack, ackName) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssiii", $payload['id'], $data['id'], $payload['timestamp'], $payload['from'], $payload['to'], $payload['body'], $payload['hasMedia'], $payload['ack'], $payload['ackName']);
$stmt->execute();
$stmt->close();

// Insert into webhook_message_data table
$msg_data = $payload['_data'];
$stmt = $mysqli->prepare("INSERT INTO webhook_message_data (id, payload_id, viewed, message_body, message_type, timestamp, notifyName, from_user, to_user, ack, invis, isNewMsg, star, kicNotified, recvFresh, isFromTemplate, labels) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssiiiiiiii", $msg_data['id'], $payload['id'], $msg_data['viewed'], $msg_data['body'], $msg_data['type'], $msg_data['t'], $msg_data['notifyName'], $msg_data['from'], $msg_data['to'], $msg_data['ack'], $msg_data['invis'], $msg_data['isNewMsg'], $msg_data['star'], $msg_data['kicNotified'], $msg_data['recvFresh'], $msg_data['isFromTemplate'], implode(",", $msg_data['labels']));
$stmt->execute();
$stmt->close();

// Insert webhook_message_secrets table
$stmt = $mysqli->prepare("INSERT INTO webhook_message_secrets (message_data_id, secret) VALUES (?, ?)");
$stmt->bind_param("sb", $msg_data['id'], json_encode($msg_data['messageSecret']));
$stmt->execute();
$stmt->close();

$mysqli->close();

http_response_code(200); // OK
echo json_encode(["status" => "success", "message" => "Data successfully processed"]);
?>
