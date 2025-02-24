<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth-login");
    exit();
}
checkAdminAccess();

$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userId = $user['username'];
$apiKey = '8cd0de4e14cd240a97209625af4bdeb0'; // Replace with your actual API key
$qrApiUrl = "https://server01.ezy.chat/api/screenshot?session=".$userId;
$statusApiUrl = "https://server01.ezy.chat/api/sessions/$userId";

// Function to fetch QR code image
function fetchQrCode($url, $apiKey) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: image/png',
        'X-Api-Key: ' . $apiKey
    ]);
    $imageData = curl_exec($ch);
    curl_close($ch);
    return $imageData["data"];
}

// Check WhatsApp connection status
$status = checkWhatsappStatus($statusApiUrl, $apiKey);

if ($status === 'WORKING') {
        // Redirect to dashboard if already connected
        $stmt = $pdo->prepare("UPDATE users SET whatsapp_connected = 1 WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        header("Location: /whatsapp_manage");
        exit();
} elseif ($status === 'SCAN_QR_CODE') {
        // Display the QR code for the user to scan
        $qrCode = fetchQrCode($qrApiUrl, $apiKey);
} elseif ($status === 'FAILED') {
        header("Location: /whatsapp_restart");
} elseif ($status === 'STOPPED') {
        header("Location: /whatsapp_restart");
} else {
        // Handle other statuses if needed
        header("Location: /dashboard");
}
?>
<?php include("includes/htmlstart.php"); ?>
<div class="layout-wrapper d-lg-flex">

    <!-- Start left sidebar-menu -->
    <div class="side-menu flex-lg-column">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="/dashboard" class="logo logo-dark">
                <span class="logo-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M8.5,18l3.5,4l3.5-4H19c1.103,0,2-0.897,2-2V4c0-1.103-0.897-2-2-2H5C3.897,2,3,2.897,3,4v12c0,1.103,0.897,2,2,2H8.5z M7,7h10v2H7V7z M7,11h7v2H7V11z"/></svg>
                </span>
            </a>

            <a href="chat.html" class="logo logo-light">
                <span class="logo-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M8.5,18l3.5,4l3.5-4H19c1.103,0,2-0.897,2-2V4c0-1.103-0.897-2-2-2H5C3.897,2,3,2.897,3,4v12c0,1.103,0.897,2,2,2H8.5z M7,7h10v2H7V7z M7,11h7v2H7V11z"/></svg>
                </span>
            </a>
        </div>
        <!-- end navbar-brand-box -->

        <!-- Start side-menu nav -->
        <div class="flex-lg-column my-0 sidemenu-navigation">
            <ul class="nav nav-pills side-menu-nav" role="tablist">

                <?php include("includes/sidemenu.php"); ?>
                
            </ul>
        </div>
        <!-- end side-menu nav -->
    </div>
    <!-- end left sidebar-menu -->

    <!-- Start User chat -->
    <div class="user-chat w-100 overflow-hidden user-chat-show">

        <div class="chat-content d-lg-flex">

            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">

                <div class="qr-code-container p-5">
                    <br><br><br><br>
                    <center>

                    <?php if ($qrCode): ?>
                        <div class="card" style="min-height: 16em;">
                          <div class="card-header">
                            Scan this QR Code to Connect WhatsApp
                          </div>
                          <div class="card-body">
                            <img src="data:image/png;base64,<?=$qrCode?>" alt="QR Code" class="img-fit">
                            <script>
                                setTimeout(function() {
                                    window.location.href = "";
                                }, 10000);
                            </script>
                          </div>
                        </div>
                    <?php else: ?>
                        <p>Unable to fetch QR code. Please try again later.</p>
                    <?php endif; ?>
                    
                    <br><br>
                    <a href="/whatsapp_restart" style="color:red;">Restart Instance</a>
                    </center>
                </div>
                
            </div>
            <!-- end chat conversation section -->

        </div>
        <!-- end user chat content -->
    </div>
    <!-- End User chat -->

</div>
<!-- end  layout wrapper -->
<?php include("includes/javascript.php"); ?>
<?php include("includes/htmlend.php"); ?>