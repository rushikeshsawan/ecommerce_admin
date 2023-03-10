<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/hybrix/html/auth-pass-reset-basic-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Feb 2023 05:33:52 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Reset Password | Hybrix - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="<?= base_url() ?>assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?= base_url() ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>


    <section class="auth-page-wrapper-2 py-4 position-relative d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="auth-card card bg-primary h-100 rounded-0 rounded-start border-0 d-flex align-items-center justify-content-center overflow-hidden p-4">
                        <div class="auth-image">
                            <img src="<?= base_url() ?>assets/images/logo-light-full.png" alt="" height="42" />
                            <img src="<?= base_url() ?>assets/images/effect-pattern/auth-effect-2.png" alt="" class="auth-effect-2" />
                            <img src="<?= base_url() ?>assets/images/effect-pattern/auth-effect.png" alt="" class="auth-effect" />
                            <img src="<?= base_url() ?>assets/images/effect-pattern/auth-effect.png" alt="" class="auth-effect-3" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card mb-0 border-0 py-3 shadow-none">
                        <div class="card-body p-4 p-sm-5 m-lg-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary fs-20">Forgot Password?</h5>
                                <p class="text-muted mb-4">Reset password with Hybrix</p>
                                <div class="display-5 mb-4 text-danger">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>

                            <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                Enter your email and instructions will be sent to you!
                            </div>
                            <div class="p-2">

                                <?php
                                if (session()->get('success')) {
                                    if (isset($validation)) {
                                        // print_r($validation);
                                    }
                                ?>

                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= session()->get('success') ?>

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo base_url() ?>resetpassword" method="post">
                                        <div class="mb-4">
                                            <label class="form-label">OTP</label>
                                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                            <input type="number" value="<?= set_value('otp') ?>" name="otp" class="form-control" id="email" placeholder="Enter OTP" required>
                                            <div class="text-danger"><?php if (isset($validation['otp'])) {
                                                                            echo ($validation['otp']);
                                                                        }  ?></div>
                                        </div>
                                        <label class="form-label">Password</label>
                                        <input type="password" value="<?= set_value('password') ?>" name="password" class="form-control" id="email" placeholder="Enter Password" required="">
                                        <input type="hidden" name="email" value="<?php echo session()->get('email'); ?>">
                                        <div class="text-danger"><?php if (isset($validation['email'])) {
                                                                        echo "<br>Session Timeout, Please Reload the page and reset Password Again";
                                                                    } else if (isset($validation['password'])) {
                                                                        echo ($validation['password']);
                                                                    }
                                                                     ?></div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>

                        </div>
                    <?php



                                } else {
                    ?>
                        <form action="<?php echo base_url() ?>forgetpassword" method="post">
                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                <input value="<?= set_value("email") ?>" type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required="">
                            </div>
                            <?php
                                    if (session()->get('Error')) {
                            ?>

                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->get('Error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php

                                    }

                            ?>
                            <div class="text-center mt-4">
                                <button class="btn btn-primary w-100" type="submit">Send OTP</button>
                            </div>

                        <?php
                                }

                        ?>




                        </form><!-- end form -->
                    </div>
                    <div class="mt-4 text-center">
                        <p class="mb-0">Wait, I remember my password... <a href="/login" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                    </div>
                </div><!-- end card body -->
            </div>
        </div><!--end col-->
        </div><!--end row-->
        </div><!--edn container-->
    </section>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins.js"></script>


    <script src="<?= base_url() ?>assets/js/pages/two-step-verification.init.js"></script>

</body>


<!-- Mirrored from themesbrand.com/hybrix/html/auth-pass-reset-basic-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Feb 2023 05:33:52 GMT -->

</html>