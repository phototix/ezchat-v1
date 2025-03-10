<?php
// Include database connection
include 'controller/conn.php';

header('Content-Type: application/json; charset=utf-8');

// Capture raw POST data
$rawData = file_get_contents('php://input');
$rawData = mb_convert_encoding($rawData, 'UTF-8', 'auto');
// Decode JSON data
$data = json_decode($rawData, true);

// Add incoming webhook payload for debug & maintainance.
$logQuery = "INSERT INTO chat_logs (token, timestamp, payload) VALUES ('$Token', '$Today $Time', '$rawData')";
$stmtCheck = $pdo->prepare($logQuery);
$stmtCheck->execute();

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
$mediaURL="";
$mediaExt="";

if($hasMedia==1){
    $mediaURL = $data['payload']['mediaUrl'];
    $lastDotPosition = strrpos($mediaURL, '.');
    if ($lastDotPosition !== false) {
        $mediaExt = substr($mediaURL, $lastDotPosition + 1);
    }
    $mediaURL = str_replace("http://localhost:3000", "", $mediaURL);
}

// Prepare data for store to table
$contact = $sender;
$parts = explode('@', $contact);
$phoneNumber = $parts[0];

$is_who = 1; // 0 is EzyChat, 1 is Customer.
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

// Check if the record with the same payload_id already exists
$checkQuery = "SELECT COUNT(*) FROM customers WHERE full_phone=:full_phone AND user_token=:user_token";
$stmtCheck = $pdo->prepare($checkQuery);
$stmtCheck->execute([':full_phone' => $phoneNumberSession, ':user_token' => $session]);
$recordCount = $stmtCheck->fetchColumn();

$is_new=1;
if($recordCount>0){ $is_new=0; }

if($is_new==1&&$phoneNumber!=="status"){
    // Fetch user records
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:username");
    $stmt->execute([':username' => $session]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userID = $user["id"];

    $Token = md5(uniqid());
    // Prepare SQL query to insert data into webhook_messages table
    $sql = "INSERT INTO customers (token, date, time, name, country, phone, full_phone, user_id, user_token, remark)
            VALUES ('$Token', '$Today', '$Time', '$senderNotifyName', '', '$phoneNumber', '$phoneNumber', '$userID', '$session', 'Chat Auto Contact')";
    // Prepare SQL statement to insert the new agent
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $customerToken = $Token;
}else{
    $customerToken = $customer["token"];
}

if($phoneNumber!=="status"){
    // Prepare SQL query to insert data into webhook_messages table
    $sql = "INSERT INTO webhook_messages (event, session, me_id, me_push_name, payload_id, timestamp, sender, sender_notify_name, recipient, message_body, has_media, ack, ack_name, environment_version, engine, tier, full_phone, is_who, is_new, customer_token, media_url, media_type)
            VALUES (:event, :session, :me_id, :me_push_name, :payload_id, :timestamp, :sender, :sender_notify_name, :recipient, :message_body, :has_media, :ack, :ack_name, :environment_version, :engine, :tier, :full_phone, :is_who, :is_new, :customer_token, :media_url, :media_type)";

    try {
        // Prepare and execute the SQL statement
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':event', $event);
        $stmt->bindParam(':session', $session);
        $stmt->bindParam(':me_id', $meId);
        $stmt->bindParam(':me_push_name', $senderNotifyName);
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
        $stmt->bindParam(':media_url', $mediaURL);
        $stmt->bindParam(':media_type', $mediaExt);

        $stmt->execute();
        
        // Return success response
        http_response_code(200);
        echo json_encode(["status" => "success"]);
        exit();
    } catch (PDOException $e) {
        // Return error response
        http_response_code(200);
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        exit();
    }
}
?>
