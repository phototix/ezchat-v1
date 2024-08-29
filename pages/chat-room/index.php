<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /auth-login?status=error&error=401"); // Error code 401 for unauthorized access
    exit();
}

// Fetch user data for display (optional)
$stmt = $pdo->prepare("SELECT * FROM customers WHERE token = :token");
$stmt->execute([':token' => $token]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
$customerToken = $customer["token"];

$full_phone = $customer["full_phone"];
$stmt = $pdo->prepare("SELECT * FROM webhook_messages WHERE customer_token = :customer_token");
$stmt->execute([':customer_token' => $customerToken]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                <h4 class="mb-4"><?=$customer["name"]?></h4>
                                <p>(<?=$customer["country"]?>) <?=$customer["phone"]?></p>
                            </div>
                        </div>

                    </div> <!-- .p-4 -->

                    <div class="chat-room-list" data-simplebar>
                        
                        <div class="chat-message-list">
    
                            <ul class="list-unstyled chat-list chat-user-list" id="customer-list">

                                <li onclick="continueChatRoom()">
                                    <a href="#" class="unread-msg-user">、
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img online align-self-center me-2 ms-0">
                                                <img src="/assets/bullet.png" class="rounded-circle avatar-xs" alt="">
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-truncate mb-0">Continue Chat</p>
                                            </div>
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
        <div class="user-chat-overlay"></div>                

        <div class="chat-content d-lg-flex">

            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">
                <!-- conversation user -->

                <div id="users-chat" class="position-relative" style="display: ;">

                    <!-- start chat user head -->
                    <div class="p-3 p-lg-4 user-chat-topbar">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-8">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 d-block d-lg-none me-3">
                                        <a href="javascript: void(0);" onclick="closeChatRoom();" class="user-chat-remove font-size-18 p-1"><i class="bx bx-chevron-left align-middle"></i></a>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="d-flex align-items-center">                            
                                            <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                <img src="/assets/logo.jpg" class="rounded-circle avatar-sm" alt="">
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h6 class="text-truncate mb-0 font-size-18">
                                                    <div class="user-profile-show text-reset" id="topbarCustomerName"><?=$customer["name"]?></div>
                                                    <p class="text-truncate text-muted mb-0">(<?=$customer["country"]?>) <?=$customer["phone"]?></p>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- end chat user head -->

                    <!-- start chat conversation -->

                    <div class="chat-conversation p-3 p-lg-4 simplebar-scrollable-y" id="chat-conversation" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: -24px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 24px;">
                                            <ul class="list-unstyled chat-conversation-list" id="users-conversation">

                                                <?php foreach ($messages as $message): ?>
                                                    <?php if($message["is_who"]==1){ ?>
                                                        <li class="chat-list left">                        
                                                            <div class="conversation-list">
                                                                <div class="chat-avatar">
                                                                    <img src="/assets/user.jpg" alt="">
                                                                </div>
                                                                <div class="user-chat-content">
                                                                    <div class="ctext-wrap">
                                                                        <div class="ctext-wrap-content" id="<?=$message["id"]?>">        
                                                                            <p class="mb-0 ctext-content"><?=$message["message_body"]?></p>
                                                                        </div>
                                                                        <div class="dropdown align-self-start message-box-drop">                
                                                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    
                                                                                <i class="ri-more-2-fill"></i>                
                                                                            </a>                
                                                                            <div class="dropdown-menu">                
                                                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>
                                                                            </div>            
                                                                        </div>
                                                                    </div>
                                                                    <div class="conversation-name">
                                                                        <small class="text-muted time">10:07 am</small> <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span>
                                                                    </div>
                                                                </div>                
                                                            </div>            
                                                        </li>
                                                    <?php } ?>

                                                    <?php if($message["is_who"]==0){ ?>
                                                        <li class="chat-list right">                        
                                                            <div class="conversation-list">
                                                                <div class="user-chat-content">
                                                                    <div class="ctext-wrap">
                                                                        <div class="ctext-wrap-content" id="<?=$message["id"]?>">        
                                                                            <p class="mb-0 ctext-content"><?=$message["message_body"]?></p>
                                                                        </div>
                                                                        <div class="dropdown align-self-start message-box-drop">                
                                                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="ri-more-2-fill"></i>                
                                                                            </a>                
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>
                                                                            </div>            
                                                                        </div>
                                                                    </div>
                                                                    <div class="conversation-name">
                                                                        <small class="text-muted time">10:12 am</small> <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span>
                                                                    </div>
                                                                </div>                
                                                            </div>
                                                        </li>
                                                    <?php } ?>

                                                <?php endforeach; ?>

                                            </ul>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="simplebar-placeholder" style="width: 897px; height: 991px;"></div>
                        </div>

                    </div>

                    <!-- start chat input section -->
                    <div class="position-relative">
                        <div class="chat-input-section p-3 p-lg-4"> 
                       
                            <form enctype="multipart/form-data" method="post" action="">
                                <input type="hidden" name="form" value="<?php echo htmlspecialchars($token); ?>">
                                <input type="hidden" name="action" value="sendText">
                                <input type="hidden" name="chatId" value="<?=$customer["full_phone"]?>@c.us">
                                <input type="hidden" name="page" value="<?=$page?>">
                                <input type="hidden" name="csrf_token" value="<?=generateCsrfToken()?>">
                                <div class="row g-0 align-items-center">  
                                
                                    <div class="col">
                                        <div class="position-relative">
                                            <div class="chat-input-feedback">
                                                Please Enter a Message
                                            </div>
                                            <input autocomplete="off" name="text" type="text" class="form-control form-control-lg chat-input" autofocus="" placeholder="Type your message..." required>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="chat-input-links ms-2 gap-md-1">
                                            <div class="links-list-item d-none d-sm-block"></div>
                                            <div class="links-list-item">
                                                <button type="submit" class="btn btn-primary btn-lg chat-send waves-effect waves-light" data-bs-toggle="collapse" data-bs-target=".chat-input-collapse1.show">
                                                    <i class="bx bxs-send align-middle" id="submit-btn"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end chat input section -->

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