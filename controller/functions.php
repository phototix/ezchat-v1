<?php
// Function to generate a CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to verify a CSRF token
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to start WhatsApp instance
function startWhatsappInstance($userId) {
    $startApiUrl = "https://server01.ezy.chat/api/sessions/start";
    $apiKey = "8cd0de4e14cd240a97209625af4bdeb0";
    $payload = json_encode([
        "name" => $userId,
        "config" => [
            "proxy" => null,
            "noweb" => [
                "store" => [
                    "enabled" => true,
                    "fullSync" => false
                ]
            ],
            "webhooks" => [
                [
                    "url" => "https://portal.ezy.chat/webhook.php",
                    "events" => ["message", "session.status"],
                    "hmac" => null,
                    "retries" => null,
                    "customHeaders" => null
                ]
            ],
            "debug" => false
        ]
    ]);

    $ch = curl_init($startApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-Api-Key: ' . $apiKey, 'accept: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        die("Failed to start WhatsApp instance.");
    }

    return json_decode($response, true);
}

// Function to start WhatsApp instance
function stopWhatsappInstance($userId) {
    $startApiUrl = "https://server01.ezy.chat/api/sessions/logout";
    $apiKey = "8cd0de4e14cd240a97209625af4bdeb0";
    $payload = json_encode([
        "name" => $userId
    ]);

    $ch = curl_init($startApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-Api-Key: ' . $apiKey, 'accept: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Function to check WhatsApp connection status
function checkWhatsappStatus($statusApiUrl, $apiKey) {
    $ch = curl_init($statusApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-Api-Key: ' . $apiKey, 'accept: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true)['status'];
}

// Function to fetch QR code image
function fetchWhatsappScreenshot($url, $apiKey) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: image/png',
        'X-Api-Key: ' . $apiKey
    ]);
    $imageData = curl_exec($ch);
    curl_close($ch);
    return $imageData;
}

function checkAdminAccess(){
    if($_SESSION['user_type']=="agent"){
        header("Location: /dashboard");
        exit();
    }
}
?>