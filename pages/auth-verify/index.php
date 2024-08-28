<?php include("includes/htmlstart.php"); ?>
<div class="auth-bg">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xl-3 col-lg-4">
                <div class="p-4 pb-0 p-lg-5 pb-lg-0 auth-logo-section">
                    <div class="text-white-50">
                        <h3><a href="/" class="text-white"><i class="bx bxs-message-alt-detail align-middle text-white h3 mb-1 me-2"></i> EzChat</a></h5>
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
                                
                                <div class="py-md-5 py-4">
                                    
                                    <div class="text-center mb-5">
                                        <h3>Welcome Back to EzChat!</h3>
                                        <p class="text-muted">EzChat Password Recovery (Verify OTP - One Time Passcode)</p>
                                    </div>

                                    <?php if(!empty($status)){ ?>
                                        <?php include(WEBBY_ROOT.'/controller/error_handler.php'); ?>
                                    <?php } ?>

                                    <form action="" method="post">
                                        <input type="hidden" name="form" value="<?=$Token?>">
                                        <input type="hidden" name="action" value="user_verify_otp">
                                        <input type="hidden" name="page" value="<?=$page?>">
                                        <input type="hidden" name="csrf_token" value="<?=generateCsrfToken()?>">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">

                                        <div class="mb-3">
                                            <label for="otp" class="form-label">OTP</label>
                                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP (One Time Passcode)" required="required">
                                        </div>

                                        <div class="text-center mt-4">
                                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                        </div>

                                    </form><!-- end form -->
    
                                    <div class="mt-5 text-center text-muted">
                                        <p>Don't have an account ? <a href="auth-register.html" class="fw-medium text-decoration-underline"> Register</a></p>
                                    </div>

                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
    
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="text-center text-muted p-4">
                                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> EzChat</p>
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