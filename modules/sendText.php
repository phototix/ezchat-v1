<?php require_once('../controller/functions.php'); ?>
<?php
// Example usage
$chatId = '6596844131@c.us';
$messageText = 'Hi there!';
$session = 'ezychat_superadmin';
sendMessageToWhatsApp($chatId, $messageText, $session);
?>