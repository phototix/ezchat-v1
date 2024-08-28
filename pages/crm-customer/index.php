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
                                <li id="showChatButton" class="">
                                    <a href="javascript: void(0);" class="unread-msg-user">、
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img online align-self-center me-2 ms-0">
                                                <img src="/assets/bullet.png" class="rounded-circle avatar-xs" alt="">
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-truncate mb-0">Customers List</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
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
                                        <img src="/assets/logo.png" class="rounded-circle avatar-sm" alt="">
                                        <span class="user-status"></span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="text-truncate mb-0 font-size-18"><a href="#" class="user-profile-show text-reset">Customer List</a></h6>
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
                
                <div class="container" style="margin-top: 6rem;">
                    
                    <!-- Customer Table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Phone</th>
                                <th>Remark</th>
                                <th>WhatsApp</th>
                                <th>Business</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($customer['id']); ?></td>
                                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['country']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                                <td><?php echo htmlspecialchars($customer['remark']); ?></td>
                                <td><?php echo $customer['is_whatsapp'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $customer['is_business'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($p > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?p=<?php echo $p - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $p ? 'active' : ''; ?>">
                                <a class="page-link" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($p < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?p=<?php echo $p + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>

            </div>
            <!-- end chat conversation section -->

        </div>
        <!-- end user chat content -->
    </div>
    <!-- End User chat -->

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