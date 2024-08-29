<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /auth-login?status=error&error=401"); // Error code 401 for unauthorized access
    exit();
}

// Fetch user data for display (optional)
$user_id = $_SESSION['user_id'];

// Set the number of records per page
$recordsPerPage = 10;

// Get the current page number from the URL, default to 1 if not set
$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($p - 1) * $recordsPerPage;
if($offset<0){ $offset=0; }

// Prepare the SQL statement to get the customer data
$sql = "SELECT id, name, country, phone, full_phone, remark, is_whatsapp, is_business FROM customers WHERE user_id='$user_id' LIMIT $offset, $recordsPerPage";
$stmt = $pdo->query($sql);

// Fetch the customer data
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of records
$totalRecordsStmt = $pdo->query("SELECT COUNT(*) FROM customers WHERE user_id='$user_id'");
$totalRecords = $totalRecordsStmt->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage);
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
                                <h4 class="mb-4">Customers</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Add Contact">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContact-exampleModal">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <form>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control bg-light border-0 pe-0" id="serachChatUser" onkeyup="searchUser()" placeholder="Search here.." 
                                aria-label="Example text with button addon" aria-describedby="searchbtn-addon" autocomplete="off">
                                <button class="btn btn-light" type="button" id="searchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                            </div>
                        </form>

                    </div> <!-- .p-4 -->

                    <div class="chat-room-list" data-simplebar>
                        
                        <div class="chat-message-list">
    
                            <ul class="list-unstyled chat-list chat-user-list" id="customer-list">

                                <?php foreach ($customers as $customer): ?>
                                    <li onclick="showChatRoom();">
                                        <a href="javascript: void(0);" class="unread-msg-user">、
                                            <div class="d-flex align-items-center">
                                                <div class="chat-user-img online align-self-center me-2 ms-0">
                                                    <img src="/assets/user.jpg" class="rounded-circle avatar-xs" alt="">
                                                </div>
                                                <div class="overflow-hidden">
                                                    <p class="text-truncate mb-0"><?php echo htmlspecialchars($customer['name']); ?></p>
                                                    <?php echo htmlspecialchars($customer['full_phone']); ?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                
                            </ul>

                        </div>

                        <div class="d-flex align-items-center px-4 mt-5 mb-2">
                            <div class="flex-grow-1">
                                <h4 class="mb-0 font-size-11 text-muted text-uppercase">Guides</h4>
                            </div>
                            <div class="flex-shrink-0">
                                
                            </div>
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
    <div class="user-chat w-100 overflow-hidden">
        <div class="user-chat-overlay"></div>                

            <div class="chat-content d-lg-flex">
                <!-- start chat conversation section -->
                <div class="w-100 overflow-hidden position-relative">
                    <!-- conversation user -->

                    <div id="users-chat" class="position-relative" style="display: none;">

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
                                                        <div class="user-profile-show text-reset" id="topbarCustomerName">Customer Name</div>
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
                                                    <li class="chat-list left" id="1">                        
                                                        <div class="conversation-list">
                                                            <div class="chat-avatar">
                                                                <img src="assets/images/users/avatar-2.jpg" alt="">
                                                            </div>
                                                            <div class="user-chat-content">
                                                                <div class="ctext-wrap">
                                                                    <div class="ctext-wrap-content" id="1">        
                                                                        <p class="mb-0 ctext-content">Good morning 😊</p>
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

                                                    <li class="chat-list right" id="2">                        
                                                        <div class="conversation-list">
                                                            <div class="user-chat-content">
                                                                <div class="ctext-wrap">
                                                                    <div class="ctext-wrap-content" id="2">        
                                                                        <p class="mb-0 ctext-content">Good morning, How are you? What about our next meeting?</p>
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
                           
                                <form id="chatinput-form" enctype="multipart/form-data"> 
                                    <div class="row g-0 align-items-center">  
                                    
                                        <div class="col">
                                            <div class="position-relative">
                                                <div class="chat-input-feedback">
                                                    Please Enter a Message
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control form-control-lg chat-input" autofocus="" id="chat-input" placeholder="Type your message...">
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
            </div>
        </div>
    </div>

    <!-- Start Add contact Modal -->
    <div class="modal fade" id="addContact-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addContact-exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-header-colored shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16" id="addContact-exampleModalLabel">Create Customer Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="create_customer" action="" method="post">
                        <input type="hidden" name="form" value="<?=$Token?>">
                        <input type="hidden" name="action" value="crm_add_customer">
                        <input type="hidden" name="page" value="<?=$page?>">
                        <input type="hidden" name="csrf_token" value="<?=generateCsrfToken()?>">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_country" class="form-label">Country</label>
                            <select class="form-control" name="customer_country" id="customer_country" required>
                                <?php foreach ($countries as $countryName => $countryCode) : ?>
                                    <option value="<?php echo htmlspecialchars($countryCode); ?>"><?php echo htmlspecialchars($countryName); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter phone" required="required">
                        </div>

                        <div class="mb-3">
                            <label for="customer_remarks" class="form-label">Remark</label>
                            <input type="text" class="form-control" id="customer_remarks" name="customer_remarks" placeholder="Enter Remarks">
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('create_customer').submit();">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add contact Modal -->

</div>
<!-- end  layout wrapper -->
<?php include("includes/javascript.php"); ?>
<?php include("includes/htmlend.php"); ?>