<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth-login");
    exit();
}

checkAdminAccess();

$stmt = $pdo->prepare("SELECT username, whatsapp_connected FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userId = $user['username'];

$apiKey = '8cd0de4e14cd240a97209625af4bdeb0'; // Replace with your actual API key
$ApiUrl = "https://server01.ezy.chat/api/screenshot?session=".$userId;
$statusApiUrl = "https://server01.ezy.chat/api/sessions/$userId";
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

            <!-- Start Content Body Top Header -->
            <div class="p-3 p-lg-4 user-chat-topbar">
                <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                <a href="/dashboard" class="user-chat-remove font-size-18 p-1"><i class="bx bx-chevron-left align-middle"></i></a>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex align-items-center">   
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="text-truncate mb-0 font-size-18"><a href="#" class="user-profile-show text-reset">Manage WhatsApp</a></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Content Body Top Header -->

            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">

                <div class="qr-code-container">
                        <br><br><br><br>
                        <center>
                        <h2>Manage Your WhatsApp</h2>
                        <?php if ($user["whatsapp_connected"]==0): ?>
                            <a href="/whatsapp_start">
                                <div class="btn btn-success">Start WhatsApp Server</div>
                            </a>
                        <?php elseif ($user["whatsapp_connected"]==1): ?>
                            <?php
                            $screenShot = fetchWhatsappScreenshot($ApiUrl, $apiKey);
                            ?>
                            <img src="data:image/png;base64,<?=$screenShot?>" alt="QR Code" class="img-fit">
                            <br><br>
                            <a href="/whatsapp_logout">
                                <div class="btn btn-danger">Logout WhatsApp Server</div>
                            </a>
                        <?php elseif ($user["whatsapp_connected"]==2): ?>
                            <a href="/whatsapp_logout">
                                <div class="btn btn-danger">Logout WhatsApp Server</div>
                            </a>
                        <?php else: ?>
                            <p>Account Suspended.</p>
                        <?php endif; ?>
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