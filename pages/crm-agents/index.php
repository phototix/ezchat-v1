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

// Set the number of records per page
$recordsPerPage = 10;

// Get the current page number from the URL, default to 1 if not set
$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($p - 1) * $recordsPerPage;
if($offset<0){ $offset=0; }

// Prepare the SQL statement to get the customer data
$sql = "SELECT id, name, country, phone, full_phone, email, username FROM users WHERE user_id='$user_id' AND user_type='agent' LIMIT $offset, $recordsPerPage";
$stmt = $pdo->query($sql);

// Fetch the customer data
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of records
$totalRecordsStmt = $pdo->query("SELECT COUNT(*) FROM users WHERE user_id='$user_id' AND user_type='agent'");
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
                                <h4 class="mb-4">Agents</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Add New Agent">

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
                        
                        
                    </div>

                </div>
                <!-- Start chats content -->

                <!-- Start add group Modal -->
                <div class="modal fade" id="addgroup-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addgroup-exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content modal-header-colored shadow-lg border-0">
                            <div class="modal-header">
                                <h5 class="modal-title text-white font-size-16" id="addgroup-exampleModalLabel">Create New Group</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <form>
                                    <div class="mb-4">
                                        <label for="addgroupname-input" class="form-label">Group Name</label>
                                        <input type="text" class="form-control" id="addgroupname-input" placeholder="Enter Group Name">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Group Members</label>
                                        <div class="mb-3">
                                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#groupmembercollapse" aria-expanded="false" aria-controls="groupmembercollapse">
                                                Select Members
                                            </button>
                                        </div>

                                        <div class="collapse" id="groupmembercollapse">
                                            <div class="card border">
                                                <div class="card-header">
                                                    <h5 class="font-size-15 mb-0">Contacts</h5>
                                                </div>
                                                <div class="card-body p-2">
                                                    <div data-simplebar style="max-height: 150px;">
                                                        <div>
                                                            <div class="contact-list-title">
                                                                A
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck1" checked>
                                                                        <label class="form-check-label" for="memberCheck1">Albert Rodarte</label>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck2">
                                                                        <label class="form-check-label" for="memberCheck2">Allison Etter</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                C
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck3">
                                                                        <label class="form-check-label" for="memberCheck3">Craig Smiley</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                D
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck4">
                                                                        <label class="form-check-label" for="memberCheck4">Daniel Clay</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                I
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck5">
                                                                        <label class="form-check-label" for="memberCheck5">Iris Wells</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                J
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck6">
                                                                        <label class="form-check-label" for="memberCheck6">Juan Flakes</label>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck7">
                                                                        <label class="form-check-label" for="memberCheck7">John Hall</label>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck8">
                                                                        <label class="form-check-label" for="memberCheck8">Joy Southern</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                M
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck9">
                                                                        <label class="form-check-label" for="memberCheck9">Michael Hinton</label>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck10">
                                                                        <label class="form-check-label" for="memberCheck10">Mary Farmer</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                P
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck11">
                                                                        <label class="form-check-label" for="memberCheck11">Phillis Griffin</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                R
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck12">
                                                                        <label class="form-check-label" for="memberCheck12">Rocky Jackson</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        <div>
                                                            <div class="contact-list-title">
                                                                S
                                                            </div>

                                                            <ul class="list-unstyled contact-list">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="memberCheck13">
                                                                        <label class="form-check-label" for="memberCheck13">Simon Velez</label>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addgroupdescription-input" class="form-label">Description</label>
                                        <textarea class="form-control" id="addgroupdescription-input" rows="3" placeholder="Enter Description"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Create Groups</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End add group Modal -->
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
                
                <div class="container mt-4">
                    <h1 class="mb-4">Agent List</h1>
                    
                    <!-- Customer Table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($customer['id']); ?></td>
                                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?><br>(<?php echo htmlspecialchars($customer['username']); ?>)</td>
                                <td><?php echo htmlspecialchars($customer['country']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
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
                    <h5 class="modal-title text-white font-size-16" id="addContact-exampleModalLabel">Create Agent Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="create_agent" action="" method="post">
                        <input type="hidden" name="form" value="<?=$Token?>">
                        <input type="hidden" name="action" value="crm_add_agent">
                        <input type="hidden" name="page" value="<?=$page?>">
                        <input type="hidden" name="csrf_token" value="<?=generateCsrfToken()?>">
                        <div class="mb-3">
                            <label for="agent_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="agent_name" name="agent_name" placeholder="Enter Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="agent_email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="agent_email" name="agent_email" placeholder="Enter Agent Email" required="required">
                        </div>

                        <div class="mb-3">
                            <label for="agent_country" class="form-label">Country</label>
                            <select class="form-control" name="agent_country" id="agent_country" required>
                                <?php foreach ($countries as $countryName => $countryCode) : ?>
                                    <option value="<?php echo htmlspecialchars($countryCode); ?>"><?php echo htmlspecialchars($countryName); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="agent_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="agent_phone" name="agent_phone" placeholder="Enter phone" required="required">
                        </div>
                                        
                        <div class="mb-3">
                            <label for="userpassword" class="form-label">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5" placeholder="Enter Password" id="userpassword" name="userpassword" required="required">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5" placeholder="Enter Password" id="confirmpassword" name="confirmpassword" required="required">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('create_agent').submit();">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add contact Modal -->

    </video>     -->
</div>
<!-- end  layout wrapper -->
<?php include("includes/javascript.php"); ?>
<?php include("includes/htmlend.php"); ?>