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
                                        <h3>Welcome Back !</h3>
                                        <p class="text-muted">Sign in to continue to EzChat</p>
                                    </div>

                                    <?php if(!empty($status)){ ?>
                                        <?php include(WEBBY_ROOT.'/controller/error_handler.php'); ?>
                                    <?php } ?>

                                    <form action="" method="post">
                                        <input type="hidden" name="token" value="<?=$Token?>">
                                        <input type="hidden" name="action" value="user_login">
                                        <input type="hidden" name="page" value="<?=$page?>">
                                        <input type="hidden" name="csrf_token" value="<?=generateCsrfToken()?>">

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" required="required">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="auth-recoverpw.html" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label for="userpassword" class="form-label">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5" placeholder="Enter Password" id="password-input" name="password" required="required">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
    
                                        <div class="form-check form-check-info font-size-16">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label font-size-14" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>
    
                                        <div class="text-center mt-4">
                                            <button class="btn btn-primary w-100" type="submit">Log In</button>
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