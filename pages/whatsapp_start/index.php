<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /auth-login?status=error&error=401"); // Error code 401 for unauthorized access
    exit();
}

checkAdminAccess();

// Fetch user data for display (optional)
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

startWhatsappInstance($user['username']);
?>
<center>
    <br><br><br><br>
    <p>Starting WhatsApp instance... Please wait for 10 seconds.</p>
</center>
<script>
    setTimeout(function() {
        window.location.href = "/whatsapp_connect";
    }, 10000);
</script>