<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /auth-login?status=error&error=401"); // Error code 401 for unauthorized access
    exit();
}

// Fetch user data for display (optional)
$user_id = $_SESSION['user_id'];

// Prepare the SQL statement to get the customer data
$sql = "SELECT id, name, country, phone, full_phone, remark, is_whatsapp, is_business, token FROM customers WHERE user_id='$user_id' ORDER BY id DESC";
$stmt = $pdo->query($sql);

// Fetch the customer data
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of records
$stmt = $pdo->prepare("SELECT * FROM customers WHERE token = :customer_token");
$stmt->execute([':customer_token' => $token]);
$customerData = $stmt->fetch(PDO::FETCH_ASSOC);
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
                                <input type="text" class="form-control bg-light border-0 pe-0" id="serachChatUser" placeholder="Search here.." 
                                aria-label="Example text with button addon" aria-describedby="searchbtn-addon" autocomplete="off">
                                <button class="btn btn-light" type="button" id="searchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                            </div>
                        </form>

                    </div> <!-- .p-4 -->

                    <div class="chat-room-list" data-simplebar>
                        
                        <div class="chat-message-list">
    
                            <ul class="list-unstyled chat-list chat-user-list" id="customer-list">

                                <?php foreach ($customers as $customer): ?>
                                    <li>
                                        <a href="/chat-room?token=<?=$customer['token']?>" class="unread-msg-user">、
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
                
                <div class="container mt-5">
                    <h2>Edit Customer Profile</h2>

                    <?php if(!empty($status)){ ?>
                        <?php include(WEBBY_ROOT.'/controller/error_handler.php'); ?>
                    <?php } ?>

                    <form method="post" action="">
                        <input type="hidden" name="token" value="<?=$Token?>">
                        <input type="hidden" name="action" value="crm_update_customer">
                        <input type="hidden" name="page" value="<?=$page?>">
                        <!-- Hidden Token for CSRF protection -->
                        <input type="hidden" name="csrf_token" value="<?=generateCsrfToken()?>">

                        <!-- Customer Name -->
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="customerName" name="customer_name" value="<?= htmlspecialchars($customerData['name']) ?>" required>
                        </div>

                        <!-- Customer Phone -->
                        <div class="mb-3">
                            <label for="customerPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="customerPhone" name="customer_phone" value="<?= htmlspecialchars($customerData['phone']) ?>" required>
                        </div>

                        <!-- Customer Country -->
                        <div class="mb-3">
                            <label for="customerCountry" class="form-label">Country</label>
                            <select class="form-select" id="customerCountry" name="customer_country">
                                <?php foreach ($countries as $countryName => $countryCode) : ?>
                                    <option <?php if($customerData['country']==$countryCode){ ?> selected <?php } ?>value="<?php echo htmlspecialchars($countryCode); ?>"><?php echo htmlspecialchars($countryName); ?></option>
                                <?php endforeach; ?>
                                <!-- Add more countries as needed -->
                            </select>
                        </div>

                        <!-- Customer Remarks -->
                        <div class="mb-3">
                            <label for="customerRemarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="customerRemarks" name="customer_remarks" rows="3"><?= htmlspecialchars($customerData['remark']) ?></textarea>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
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
                        <input type="hidden" name="token" value="<?=$Token?>">
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
<script>
$(document).ready(function(){

  $("#serachChatUser").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#customer-list li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?php include("includes/htmlend.php"); ?>