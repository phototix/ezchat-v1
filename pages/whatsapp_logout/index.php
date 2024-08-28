<?php
// Fetch user data for display (optional)
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

stopWhatsappInstance($user['username']);
$stmt = $pdo->prepare("UPDATE users SET whatsapp_connected = 0 WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
?>
<center>
    <br><br><br><br>
    <p>Loging out WhatsApp instance... Please wait for 10 seconds.</p>
</center>
<script>
    setTimeout(function() {
        window.location.href = "/whatsapp_manage";
    }, 10000);
</script>