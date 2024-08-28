<?php
// Fetch user data for display (optional)
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

checkAdminAccess();

stopWhatsappInstance($user['username']);
?>
<center>
    <br><br><br><br>
    <p>Restarting WhatsApp instance... Please wait for 10 seconds.</p>
</center>
<script>
    setTimeout(function() {
        window.location.href = "/whatsapp_start";
    }, 10000);
</script>