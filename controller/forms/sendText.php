<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate input
    $chatId = $_POST['chatId'] ?? '';
    $messageText = $_POST['text'] ?? '';
    $action = $_POST['action'] ?? '';

    if (empty($chatId) || empty($messageText) || $action !== 'sendText') {
        header("Location: /$page?token=$token&status=error&error=201"); // Error code for missing fields
        exit();
    }

    $responseData = sendMessageToWhatsApp($chatId, $messageText, $_SESSION['user_token']);

    header("Location: /$page?token=$token");
    exit();
}
?>