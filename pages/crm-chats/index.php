<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /auth-login?status=error&error=401"); // Error code 401 for unauthorized access
    exit();
}

// Fetch user data for display (optional)
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, whatsapp_connected FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
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
                                <h4 class="mb-4">Chats</h4>
                            </div>
                            <div class="flex-shrink-0">

                            </div>
                        </div>

                    </div> <!-- .p-4 -->

                    <div class="chat-room-list" data-simplebar>
                        <!-- Start chat-message-list -->
                        <h5 class="mb-3 px-4 mt-4 font-size-11 text-muted text-uppercase">Favourites</h5>

                        <div class="chat-message-list">
    
                            <ul class="list-unstyled chat-list chat-user-list" id="favourite-users">
                            </ul>
                        </div>

                        <div class="d-flex align-items-center px-4 mt-5 mb-2">
                            <div class="flex-grow-1">
                                <h4 class="mb-0 font-size-11 text-muted text-uppercase">Direct Messages</h4>
                            </div>
                            <div class="flex-shrink-0">
                            </div>
                        </div>

                        <div class="chat-message-list">
    
                            <ul class="list-unstyled chat-list chat-user-list" id="usersList">
        
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


</div>
<!-- end  layout wrapper -->
<?php include("includes/javascript.php"); ?>
<?php include("includes/htmlend.php"); ?>