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
            <!-- Start Profile tab-pane -->
            <div class="tab-pane" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                <!-- Start profile content -->
                <div>
                    <div class="user-profile-img">
                        <img src="assets/images/small/img-4.jpg" class="profile-img" style="height: 160px;" alt="">
                        <div class="overlay-content">
                            <div>
                                <div class="user-chat-nav p-2 ps-3">
            
                                    <div class="d-flex w-100 align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="text-white mb-0">My Profile</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <button class="btn nav-btn text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class='bx bx-dots-vertical-rounded'></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Info <i class="bx bx-info-circle ms-2 text-muted"></i></a>
                                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Setting <i class="bx bx-cog text-muted ms-2"></i></a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Help <i class="bx bx-help-circle ms-2 text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center p-3 p-lg-4 border-bottom pt-2 pt-lg-2 mt-n5 position-relative">
                        <div class="mb-lg-3 mb-2">
                            <img src="assets/images/users/avatar-1.jpg" class="rounded-circle avatar-lg img-thumbnail" alt="">
                        </div>

                        <h5 class="font-size-16 mb-1 text-truncate">User Profile</h5>
                        <p class="text-muted font-size-14 text-truncate mb-0">Profile Remarks</p>
                    </div>
                    <!-- End profile user -->

                    <!-- Start user-profile-desc -->
                    <div class="p-4 profile-desc" data-simplebar>
                        <div class="text-muted">
                            <p class="mb-4">Some text here...</p>
                        </div>

                        <hr class="my-4">

                    </div>
                    <!-- end user-profile-desc -->
                </div>
                <!-- End profile content -->
            </div> 
            <!-- End Profile tab-pane -->

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
                        <form>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control bg-light border-0 pe-0" id="serachChatUser" onkeyup="searchUser()" placeholder="Search here.." 
                                aria-label="Example text with button addon" aria-describedby="searchbtn-addon" autocomplete="off">
                                <button class="btn btn-light" type="button" id="searchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                            </div>
                        </form>

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

            <!-- Start contacts tab-pane -->
            <div class="tab-pane" id="pills-contacts" role="tabpanel" aria-labelledby="pills-contacts-tab">
                <!-- Start Contact content -->
                <div>
                    <div class="px-4 pt-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-4">Contacts</h4>
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
                            <div class="input-group mb-4">
                                <input type="text" class="form-control bg-light border-0 pe-0" id="searchContact" onkeyup="searchContacts()" placeholder="Search Contacts.." aria-label="Search Contacts..." 
                                aria-describedby="button-searchcontactsaddon" autocomplete="off">
                                <button class="btn btn-light" type="button" id="button-searchcontactsaddon"><i class='bx bx-search align-middle'></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- end p-4 -->

                    <div class="chat-message-list chat-group-list" data-simplebar >
                        <div class="sort-contact">            
                        </div>
                    </div>
                    <!-- end contact lists -->
                </div>
                <!-- Start Contact content -->
            </div>
            <!-- End contacts tab-pane -->

            <!-- Start calls tab-pane -->
            <div class="tab-pane" id="pills-calls" role="tabpanel" aria-labelledby="pills-calls-tab">
                <!-- Start Contact content -->
                <div>
                    <div class="px-4 pt-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-3">Calls</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end p-4 -->

                    <!-- Start contact lists -->
                    <div class="chat-message-list chat-call-list" data-simplebar>
                        <ul class="list-unstyled chat-list" id="callList">      
          
                        </ul>
                    </div>
                    <!-- end contact lists -->
                </div>
                <!-- Start Contact content -->
            </div>
            <!-- End calls tab-pane -->

            <!-- Start bookmark tab-pane -->
            <div class="tab-pane" id="pills-bookmark" role="tabpanel" aria-labelledby="pills-bookmark-tab">
                <!-- Start Contact content -->
                <div>
                    <div class="px-4 pt-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-3">Bookmark</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end p-4 -->

                    <!-- Start contact lists -->
                    <div class="chat-message-list chat-bookmark-list" data-simplebar>
                        <ul class="list-unstyled chat-list">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">design-phase-1-approved.pdf</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">12.5 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-pin"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Bg Pattern</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">https://bgpattern.com/</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Image-001.jpg</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">4.2 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-pin"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Images</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">https://images123.com/</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-pin"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Bg Gradient</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">https://bggradient.com/</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Image-012.jpg</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">3.1 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">analytics dashboard.zip</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">6.7 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Image-031.jpg</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">4.2 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Changelog.txt</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">6.7 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Widgets.zip</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">6.7 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">logo-light.png</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">4.2 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Image-2.jpg</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">3.1 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs ms-1 me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-truncate p-0">Landing-A.zip</a></h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">6.7 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-16 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
    
                        </ul>
                    </div>
                    <!-- end contact lists -->
                </div>
                <!-- Start Contact content -->
            </div>
            <!-- End bookmark tab-pane -->
            
            <!-- Start settings tab-pane -->
            <div class="tab-pane" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                <!-- Start Settings content -->
                <div>
                    <div class="user-profile-img">
                        <img src="assets/images/small/img-4.jpg" class="profile-img profile-foreground-img" style="height: 160px;" alt="">
                        <div class="overlay-content">
                            <div>
                                <div class="user-chat-nav p-3">
            
                                    <div class="d-flex w-100 align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="text-white mb-0">Settings</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Change Background">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center p-3 p-lg-4 border-bottom pt-2 pt-lg-2 position-relative">


                    </div>
                    <!-- End profile user -->

                    <!-- Start User profile description -->
                    <div class="user-setting" data-simplebar>
                        <div id="settingprofile" class="accordion accordion-flush">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headerpersonalinfo">
                                    <button class="accordion-button font-size-14 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#personalinfo" aria-expanded="true" aria-controls="personalinfo">
                                        <i class="bx bxs-user text-muted me-3"></i> Personal Info
                                    </button>
                                </div>
                                <div id="personalinfo" class="accordion-collapse collapse show" aria-labelledby="headerpersonalinfo" data-bs-parent="#settingprofile">
                                    <div class="accordion-body">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-soft-primary btn-sm"><i class="bx bxs-pencil align-middle"></i></button>
                                        </div>

                                        <div>
                                            <p class="text-muted mb-1">Name</p>
                                            <h5 class="font-size-14">Adam Zampa</h5>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end personal info card -->

                            <div class="accordion-item">
                                <div class="accordion-header" id="headersecurity">
                                    <button class="accordion-button font-size-14 fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesecurity" aria-expanded="false" aria-controls="collapsesecurity">
                                        <i class="bx bxs-check-shield text-muted me-3"></i> Security
                                    </button>
                                </div>
                                <div id="collapsesecurity" class="accordion-collapse collapse" aria-labelledby="headersecurity" data-bs-parent="#settingprofile">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item p-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-13 mb-0 text-truncate">Show security notification</h5>

                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input" id="security-notificationswitch">
                                                            <label class="form-check-label" for="security-notificationswitch"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- end security card -->

    

                            <div class="accordion-item">
                                <div class="accordion-header" id="headerhelp">
                                    <button class="accordion-button font-size-14 fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsehelp" aria-expanded="false" aria-controls="collapsehelp">
                                        <i class="bx bxs-help-circle text-muted me-3"></i> Help
                                    </button>
                                </div>
                                <div id="collapsehelp" class="accordion-collapse collapse" aria-labelledby="headerhelp" data-bs-parent="#settingprofile">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item py-3 px-0 pt-0">
                                                <h5 class="font-size-13 mb-0"><a href="#" class="text-body d-block">FAQs</a></h5>
                                            </li>
                                            <li class="list-group-item py-3 px-0">
                                                <h5 class="font-size-13 mb-0"><a href="#" class="text-body d-block">Contact</a></h5>
                                            </li>
                                            <li class="list-group-item py-3 px-0 pb-0">
                                                <h5 class="font-size-13 mb-0"><a href="#" class="text-body d-block">Terms & Privacy policy</a></h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end profile-setting-accordion -->
                    </div>
                    <!-- End User profile description -->
                </div>
                <!-- Start Settings content -->
            </div>
            <!-- End settings tab-pane -->
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
                
            </div>
            <!-- end chat conversation section -->

            <!-- start User profile detail sidebar -->
            <div class="user-profile-sidebar">

                <!-- Start user-profile-desc -->
                <div class="p-4 user-profile-desc" data-simplebar>

                    <div class="text-center border-bottom">
                        <div class="row">
                            <div class="col-sm col-4">
                                <div class="mb-4">
                                    <div class="dropdown">
                                        <button class="btn avatar-sm p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="avatar-title bg-light text-body rounded">
                                                <i class='bx bx-dots-horizontal-rounded'></i>
                                            </span>
                                        </button>
                    
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Archive <i class="bx bx-archive text-muted"></i></a>
                                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Muted <i class="bx bx-microphone-off text-muted"></i></a>
                                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Delete <i class="bx bx-trash text-muted"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="font-size-11 text-uppercase text-muted mt-2">More</h5>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end user-profile-desc -->
            </div>
            <!-- end User profile detail sidebar -->
        </div>
        <!-- end user chat content -->
    </div>
    <!-- End User chat -->

    <!-- Start Add contact Modal -->
    <div class="modal fade" id="addContact-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addContact-exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-header-colored shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16" id="addContact-exampleModalLabel">Create Contact</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label for="addcontactemail-input" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addcontactemail-input" placeholder="Enter Email">
                        </div>
                        <div class="mb-3">
                            <label for="addcontactname-input" class="form-label">Name</label>
                            <input type="text" class="form-control" id="addcontactname-input" placeholder="Enter Name">
                        </div>
                        <div class="mb-0">
                            <label for="addcontact-invitemessage-input" class="form-label">Invatation Message</label>
                            <textarea class="form-control" id="addcontact-invitemessage-input" rows="3" placeholder="Enter Message"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Invite</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add contact Modal -->

    <!-- audiocall Modal -->
    <div class="modal fade audiocallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-body p-0">
                    <div class="text-center p-4 pb-0">
                        <div class="avatar-xl mx-auto mb-4">
                            <img src="assets/images/users/avatar-2.jpg" alt="" class="img-thumbnail rounded-circle">
                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <div class="avatar-md h-auto">
                                <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                    <span class="avatar-title bg-transparent text-muted font-size-20">
                                        <i class="bx bx-microphone-off"></i>
                                    </span>
                                </button>
                                <h5 class="font-size-11 text-uppercase text-muted mt-2">Mute</h5>
                            </div>
                            <div class="avatar-md h-auto">
                                <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                    <span class="avatar-title bg-transparent text-muted font-size-20">
                                        <i class="bx bx-volume-full"></i>
                                    </span>
                                </button>
                                <h5 class="font-size-11 text-uppercase text-muted mt-2">Speaker</h5>
                            </div>
                            <div class="avatar-md h-auto">
                                <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                    <span class="avatar-title bg-transparent text-muted font-size-20">
                                        <i class="bx bx-user-plus"></i>
                                    </span>
                                </button>
                                <h5 class="font-size-11 text-uppercase text-muted mt-2">Add New</h5>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" class="btn btn-danger avatar-md call-close-btn rounded-circle" data-bs-dismiss="modal">
                                <span class="avatar-title bg-transparent font-size-24">
                                    <i class="mdi mdi-phone-hangup"></i>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="p-4 bg-primary-subtle mt-n4">
                        <div class="mt-4 text-center">
                            <h5 class="font-size-18 mb-0 text-truncate">...</h5>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
    <!-- audiocall Modal -->

    <!-- videocall Modal -->
    <div class="modal fade videocallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-body p-0">
                    <img src="assets/images/users/avatar-2.jpg" alt="" class="videocallModal-bg">
                    <div class="position-absolute start-0 end-0 bottom-0">
                        <div class="text-center">
                            <div class="d-flex justify-content-center align-items-center text-center">
                                <div class="avatar-md h-auto">
                                    <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                        <span class="avatar-title bg-transparent text-muted font-size-20">
                                            <i class="bx bx-microphone-off"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="avatar-md h-auto">
                                    <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                        <span class="avatar-title bg-transparent text-muted font-size-20">
                                            <i class="bx bx-volume-full"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="avatar-md h-auto">
                                    <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                        <span class="avatar-title bg-transparent text-muted font-size-20">
                                            <i class="bx bx-video-off"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="avatar-md h-auto">
                                    <button type="button" class="btn btn-light avatar-sm rounded-circle">
                                        <span class="avatar-title bg-transparent text-muted font-size-20">
                                            <i class="bx bx-refresh"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-danger avatar-md call-close-btn rounded-circle" data-bs-dismiss="modal">
                                    <span class="avatar-title bg-transparent font-size-24">
                                        <i class="mdi mdi-phone-hangup"></i>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="p-4 bg-primary mt-n4">
                            <div class="text-white mt-4 text-center">
                                <h5 class="font-size-18 text-truncate mb-0 text-white">...</h5>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

    <!-- Start Add pinned tab Modal -->
    <div class="modal fade pinnedtabModal" tabindex="-1" role="dialog" aria-labelledby="pinnedtabModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-header-colored shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16" id="pinnedtabModalLabel">Bookmark</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <div>
                                <h5 class="font-size-16 mb-0">10 Pinned tabs</h5>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div>
                                <button type="button" class="btn btn-sm btn-soft-primary"><i class="bx bx-plus"></i> Pin</button>
                            </div>
                        </div>
                    </div>
                    <div class="chat-bookmark-list mx-n4" data-simplebar style="max-height: 299px;">
                        <ul class="list-unstyled chat-list">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">design-phase-1-approved.pdf</a></h5>
                                        <p class="text-muted font-size-13 mb-0">12.5 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-pin"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">Bg Pattern</a></h5>
                                        <p class="text-muted font-size-13 mb-0">https://bgpattern.com/</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">Image-001.jpg</a></h5>
                                        <p class="text-muted font-size-13 mb-0">4.2 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-pin"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">Images</a></h5>
                                        <p class="text-muted font-size-13 mb-0">https://images123.com/</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-pin"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">Bg Gradient</a></h5>
                                        <p class="text-muted font-size-13 mb-0">https://bggradient.com/</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-image"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">Image-012.jpg</a></h5>
                                        <p class="text-muted font-size-13 mb-0">3.1 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-14 text-truncate mb-1"><a href="#" class="p-0">analytics dashboard.zip</a></h5>
                                        <p class="text-muted font-size-13 mb-0">6.7 MB</p>
                                    </div>

                                    <div class="flex-shrink-0 ms-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle font-size-18 text-muted px-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Open <i class="bx bx-folder-open ms-2 text-muted"></i></a>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Edit <i class="bx bx-pencil ms-2 text-muted"></i></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add pinned tab Modal -->

    <!-- forward Modal -->
    <div class="modal fade forwardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-header-colored shadow-lg border-top-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16">Share this Message</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body p-4">
                    <div>
                        <div class="replymessage-block mb-2">
                            <h5 class="conversation-name">Jean Berwick</h5>
                            <p class="mb-0">Yeah everything is fine. Our next meeting tomorrow at 10.00 AM</p>
                        </div>
                        <textarea class="form-control" placeholder="Type your message..." rows="2"></textarea>
                    </div>
                    <hr class="my-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control bg-light border-0 pe-0" placeholder="Search here.." 
                        aria-label="Example text with button addon" aria-describedby="forwardSearchbtn-addon">
                        <button class="btn btn-light" type="button" id="forwardSearchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                    </div>

                    <div class="d-flex align-items-center px-1">
                        <div class="flex-grow-1">
                            <h4 class="mb-0 font-size-11 text-muted text-uppercase">Contacts</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-sm btn-primary">Share All</button>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 150px;" class="mx-n4 px-1">
                        <div>
                            <div class="contact-list-title">
                                A
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Albert Rodarte</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Allison Etter</h5>                        
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list A -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                C
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Craig Smiley</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list C -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                D
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Daniel Clay</h5>  
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Doris Brown</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list D -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                I
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Iris Wells</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list I -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                J
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Juan Flakes</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">John Hall</h5>
                                        </div>                                                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Joy Southern</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list J -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                M
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Mary Farmer</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Mark Messer</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Michael Hinton</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list M -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                O
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Ossie Wilson</h5>
                                        </div>                        
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list O -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                P
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Phillis Griffin</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                                <li> 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Paul Haynes</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list P -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                R
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Rocky Jackson</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list R -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                S
                            </div>

                            <ul class="list-unstyled contact-list mb-0">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Sara Muller</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Simon Velez</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14 m-0">Steve Walker</h5>
                                        </div>
                
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-sm btn-primary">Send</button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list S -->
                    </div>
                </div>                        
            </div>
        </div>
    </div>
    <!-- forward Modal -->

    <!-- contactModal -->
    <div class="modal fade contactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-header-colored shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16">Contacts</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body p-4">
                    
                    <div class="input-group mb-4">
                        <input type="text" class="form-control bg-light border-0 pe-0" placeholder="Search here.." id="searchContactModal" onkeyup="searchContactOnModal()" 
                        aria-label="Example text with button addon" aria-describedby="contactSearchbtn-addon">
                        <button class="btn btn-light" type="button" id="contactSearchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                    </div>

                    <div class="d-flex align-items-center px-1">
                        <div class="flex-grow-1">
                            <h4 class=" font-size-11 text-muted text-uppercase">Contacts</h4>
                        </div>
                    </div>
                    <div class="contact-modal-list mx-n4 px-1" data-simplebar style="max-height: 200px;">
                        <div class="mt-3">
                            <div class="contact-list-title">
                                A
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Albert Rodarte</h5>
                                    </div>
                                </li>

                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Allison Etter</h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list A -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                C
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Craig Smiley</h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list C -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                D
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Daniel Clay</h5>
                                    </div>
                                </li>

                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Doris Brown</h5>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list D -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                I
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li >
                                    <div>
                                        <h5 class="font-size-14 m-0">Iris Wells</h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list I -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                J
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Juan Flakes</h5>
                                    </div>
                                </li>

                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">John Hall</h5>
                                    </div>
                                </li>

                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Joy Southern</h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end contact list J -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                M
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Mary Farmer</h5>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Mark Messer</h5>
                                    </div>
                                </li>

                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Michael Hinton</h5>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list M -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                O
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Ossie Wilson</h5>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list O -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                P
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Phillis Griffin</h5>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Paul Haynes</h5>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list P -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                R
                            </div>

                            <ul class="list-unstyled contact-list">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Rocky Jackson</h5>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list R -->

                        <div class="mt-3">
                            <div class="contact-list-title">
                                S
                            </div>

                            <ul class="list-unstyled contact-list mb-0">
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Sara Muller</h5>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Simon Velez</h5>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h5 class="font-size-14 m-0">Steve Walker</h5>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- end contact list S -->
                    </div>
                </div>       
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"><i class="bx bxs-send align-middle"></i></button>
                </div>                 
            </div>
        </div>
    </div>
    <!-- contactModal -->
    <!-- <video id="video" autoplay="true">

    </video>     -->
</div>
<!-- end  layout wrapper -->
<?php include("includes/javascript.php"); ?>
<?php include("includes/htmlend.php"); ?>