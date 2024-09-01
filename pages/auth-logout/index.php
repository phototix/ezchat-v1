<?php
// Destroy the session and redirect to login page
session_unset();
session_destroy();
?>
<?php include("includes/htmlstart.php"); ?>
<div class="auth-bg">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xl-3 col-lg-4">
                <div class="p-4 pb-0 p-lg-5 pb-lg-0 auth-logo-section">
                    <div class="text-white-50">
                        <h3><a href="/" class="text-white"><i class="bx bxs-message-alt-detail align-middle text-white h3 mb-1 me-2"></i> EzyChat</a></h5>
                        <p class="font-size-16">Best WhatsApp CRM in Malaysia</p>
                    </div>
                    <div class="mt-auto">
                        <img src="assets/images/auth-img.png" alt="" class="auth-img">
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-xl-9 col-lg-8">
                <div class="authentication-page-content">
                    <div class="d-flex flex-column h-100 px-4 pt-4">
                        <div class="row justify-content-center my-auto">
                            <div class="col-sm-8 col-lg-6 col-xl-5 col-xxl-4">
                                
                                <div class="py-md-5 py-4 text-center">
                                    
                                    <div class="avatar-xl mx-auto">
                                        <div class="avatar-title bg-primary-subtle text-primary h1 rounded-circle">
                                            <i class="bx bxs-user"></i>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-2">
                                        <h5>You are Logged Out</h5>
                                        <div class="mt-4">
                                            <a href="/" class="btn btn-primary w-100 waves-effect waves-light">Sign In</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
    
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="text-center text-muted p-4">
                                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> EzyChat</p>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
    
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end auth bg -->
<?php include("includes/javascript.php"); ?>
<?php include("includes/htmlend.php"); ?>