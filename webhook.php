<?php
// Include database connection
include 'controller/conn.php';

header('Content-Type: application/json; charset=utf-8');

// Capture raw POST data
$rawData = file_get_contents('php://input');
$rawData = mb_convert_encoding($rawData, 'UTF-8', 'auto');
// Decode JSON data
$data = json_decode($rawData, true);

// Validate and extract necessary fields
$event = $data['event'] ?? '';
$session = $data['session'] ?? '';
$meId = $data['me']['id'] ?? '';
$mePushName = $data['me']['pushName'] ?? '';
$payloadId = $data['payload']['id'] ?? '';
$timestamp = $data['payload']['timestamp'] ?? '';
$sender = $data['payload']['from'] ?? '';
$senderNotifyName = $data['payload']['_data']['notifyName'] ?? '';
$recipient = $data['payload']['to'] ?? '';
$messageBody = $data['payload']['body'] ?? '';
$hasMedia = $data['payload']['hasMedia'] ?? 0;
$ack = $data['payload']['ack'] ?? 0;
$ackName = $data['payload']['ackName'] ?? '';
$environmentVersion = $data['environment']['version'] ?? '';
$engine = $data['engine'] ?? '';
$tier = $data['environment']['tier'] ?? '';

// Prepare data for store to table
$contact = $sender;
$parts = explode('@', $contact);
$phoneNumber = $parts[0]; // This will be "6596844131"

$is_who = 1; // 0 is EzChat, 1 is Customer.
if($meId==$sender){ $is_who = 0; }

// Check if the record with the same payload_id already exists
$checkQuery = "SELECT COUNT(*) FROM webhook_messages WHERE payload_id = :payload_id";
$stmtCheck = $pdo->prepare($checkQuery);
$stmtCheck->bindParam(':payload_id', $payloadId);
$stmtCheck->execute();
$recordExists = $stmtCheck->fetchColumn();

if ($recordExists > 0) {
    // If record exists, return a success response without inserting
    http_response_code(200);
    echo json_encode(["status" => "duplicate"]);
    exit();
}

$phoneNumberSession = $phoneNumber;
if($is_who==0){ 
    // Prepare data for store to table
    $contact = $recipient;
    $parts = explode('@', $contact);
    $phoneNumberRecipient = $parts[0]; // This will be "6596844131"
    $phoneNumberSession = $phoneNumberRecipient;
}

// Fetch customer records
$stmt = $pdo->prepare("SELECT token FROM customers WHERE full_phone=:full_phone AND user_token=:user_token");
$stmt->execute([':full_phone' => $phoneNumberSession, ':user_token' => $session]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
$recordCount = count($customer);
$customerToken = $customer["token"];
$is_new=1;
if($recordCount>0){ $is_new=0; }

// Fetch user records
$stmt = $pdo->prepare("SELECT id FROM users WHERE token=:token");
$stmt->execute([':token' => $session]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = $user["id"];

if($is_new==1){
    // Prepare SQL query to insert data into webhook_messages table
    $sql = "INSERT INTO webhook_messages (token, date, time, name, country, phone, full_phone, user_id, user_token)
            VALUES (:token, :date, :time, :name, :country, :phone, :full_phone, :user_id, :user_token)";
    // Prepare SQL statement to insert the new agent
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':token' => md5(uniqid()),
        ':date' => date("Y-m-d"),
        ':time' => date("H:i:s"),
        ':name' => $mePushName,
        ':country' => '',
        ':phone' => $phoneNumberSession,
        ':full_phone' => $phoneNumberSession,
        ':user_id' => $userId,
        ':user_token' => $session
    ]);
}

// Prepare SQL query to insert data into webhook_messages table
$sql = "INSERT INTO webhook_messages (event, session, me_id, me_push_name, payload_id, timestamp, sender, sender_notify_name, recipient, message_body, has_media, ack, ack_name, environment_version, engine, tier, full_phone, is_who, is_new, customer_token)
        VALUES (:event, :session, :me_id, :me_push_name, :payload_id, :timestamp, :sender, :sender_notify_name, :recipient, :message_body, :has_media, :ack, :ack_name, :environment_version, :engine, :tier, :full_phone, :is_who, :is_new, :customer_token)";

try {
    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':event', $event);
    $stmt->bindParam(':session', $session);
    $stmt->bindParam(':me_id', $meId);
    $stmt->bindParam(':me_push_name', $mePushName);
    $stmt->bindParam(':payload_id', $payloadId);
    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->bindParam(':sender', $sender);
    $stmt->bindParam(':sender_notify_name', $senderNotifyName);
    $stmt->bindParam(':recipient', $recipient);
    $stmt->bindParam(':message_body', $messageBody);
    $stmt->bindParam(':has_media', $hasMedia);
    $stmt->bindParam(':ack', $ack);
    $stmt->bindParam(':ack_name', $ackName);
    $stmt->bindParam(':environment_version', $environmentVersion);
    $stmt->bindParam(':engine', $engine);
    $stmt->bindParam(':tier', $tier);
    $stmt->bindParam(':full_phone', $phoneNumber);
    $stmt->bindParam(':is_who', $is_who);
    $stmt->bindParam(':is_new', $is_new);
    $stmt->bindParam(':customer_token', $customerToken);

    $stmt->execute();
    
    // Return success response
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    // Return error response
    http_response_code(200);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
