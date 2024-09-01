<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth-login");
    exit();
}

$stmt = $pdo->prepare("SELECT username, whatsapp_connected FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
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

    <!-- start chat-leftsidebar -->
    <div class="chat-leftsidebar">

        <div class="tab-content">

            <!-- Start chats tab-pane -->
            <div class="tab-pane show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
                <!-- Start chats content -->
                <div>
                    <div class="px-4 pt-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-4">Dashboard</h4>
                            </div>
                        </div>

                    </div> <!-- .p-4 -->

                    <div class="chat-room-list" data-simplebar>
                        <!-- Start chat-message-list -->
                        <h5 class="mb-3 px-4 mt-4 font-size-11 text-muted text-uppercase">Actions</h5>

                        <div class="chat-message-list">
    
                            <ul class="list-unstyled chat-list chat-user-list" id="dashboard-list">
                                <li id="showChatButton" class="">
                                    <a href="javascript: void(0);" class="unread-msg-user">、
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img online align-self-center me-2 ms-0">
                                                <img src="/assets/dashboard.png" class="rounded-circle avatar-xs" alt="">
                                                <?php if ($showBadgeNumbersInMenu): ?>
                                                    <span class="user-status"></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-truncate mb-0">Dashboard</p>
                                            </div>

                                            <?php if ($showBadgeNumbersInMenu): ?>
                                                <div class="ms-auto">
                                                    <span class="badge bg-dark-subtle text-reset rounded p-1">18</span>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </a>
                                </li>
                            </ul>

                        </div>
                        
                    </div>

                </div>
                <!-- Start chats content -->
                
            </div>
            <!-- End chats tab-pane -->

        </div>
        <!-- end tab content -->
    </div>
    <!-- end chat-leftsidebar -->

    <!-- Start User chat -->
    <div class="user-chat w-100 overflow-hidden user-chat-show">

        <div class="chat-content d-lg-flex">

            <!-- Start Content Body Top Header -->
            <div class="p-3 p-lg-4 user-chat-topbar">
                <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                <a href="javascript: void(0);" id="closeChatBody" class="user-chat-remove font-size-18 p-1"><i class="bx bx-chevron-left align-middle"></i></a>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex align-items-center">                            
                                    <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                        <img src="/assets/logo.jpg" class="rounded-circle avatar-sm" alt="">
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="text-truncate mb-0 font-size-18"><a href="#" class="user-profile-show text-reset"><?=ucwords($user["username"])?></a></h6>
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

                <div class="qr-code-container p-3">
                    <br><br><br><br>
                    <center>
                    <h2>Welcome to EzyChat!</h2>
                    </center>

                    <div class="row">
                        <div class="col">
                            <div class="card" style="min-height: 16em;">
                              <div class="card-header">
                                WhatsApp Server
                              </div>
                              <div class="card-body">
                                <h5 class="card-title">Start/Logout Your Instance</h5>
                                <p class="card-text">Start connect your WhatsApp and communicate with your customers!</p>
                                <a href="/whatsapp_manage" class="btn btn-primary">Manage</a>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" style="min-height: 16em;">
                              <div class="card-header">
                                Featured
                              </div>
                              <div class="card-body">
                                <h5 class="card-title">Join as Official Account</h5>
                                <p class="card-text">Become Official Business with WhatsApp</p>
                                <a href="#" class="btn btn-primary">Learn More</a>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" style="min-height: 16em;">
                              <div class="card-header">
                                Promotion!
                              </div>
                              <div class="card-body">
                                <h5 class="card-title">Version 2 Launch Promo</h5>
                                <p class="card-text">Stay tune for launch promo!</p>
                              </div>
                            </div>
                        </div>
                    </div>

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