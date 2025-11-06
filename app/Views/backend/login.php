
<?php $setting = \App\Models\Setting::get() ?>
<?php $logo_setting = $setting['logo']?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>Login - <?=env('APP_NAME') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="_token" content="<?= csrf_hash() ?>">
    <meta name="base_url" content="<?=base_url('/')?>/">
    <meta content="Login - <?=env('APP_NAME')?>" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=base_url('upload/').'/'.$logo_setting->favicon_image?>">
    <!-- Layout config Js -->
    <script src="<?=base_url('public/')?>/assetsadmin/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?=base_url('public/')?>/assetsadmin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url('public/')?>/assetsadmin/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?=base_url('public/')?>/assetsadmin/css/app.min.css" rel="stylesheet" type="text/css" />



    <link rel="stylesheet" href="<?=base_url('public')?>/toast/saber-toast.css">
    <link rel="stylesheet" href="<?=base_url('public')?>/toast/style.css">
    <link rel="stylesheet" href="<?=base_url('public')?>/front_css.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?=base_url('public')?>/front_script.js"></script>
    
    
    



</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-1 text-white-50">
                            <div>
                                <a href="<?=route_to('auth.login')?>" class="d-inline-block auth-logo" style="background:#FFF;padding:5px 15px 6px;border-radius:5px;">
                                    <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" loading="lazy" alt="logo" height="46">
                                </a>
                            </div>
                            <!-- <p class="mt-2 fs-15 fw-medium">The Art of Pole Dancing & Flexibility</p> -->
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-5 mt-md-4 mt-lg-4 card-bg-fill">

                            <div class="card-body p-3 p-md-4 p-lg-4">
                                <div class="">
                                    <form class="needs-validation form_data" action="<?= base_url(route_to('auth.login-action')); ?>" method="post" id="LoginForm" novalidate >

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                                            <div class="invalid-feedback">Please provide a valid username.</div>
                                        </div>

                                        <div class="mb-3">
                                            <!-- <div class="float-end">
                                                <a href="forgot-password.php" class="text-muted">Forgot password?</a>
                                            </div> -->
                                            <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" name="password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">Please provide a valid password</div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In<i class="ri-login-circle-line ms-2"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

    </div>
    <!-- end auth-page-wrapper -->

        <!--<footer class="footer login_style">-->
        <!--    <div class="container">-->
        <!--        <div class="row">-->
        <!--            <div class="col-lg-12">-->
        <!--                <div class="text-center">-->
        <!--                    <p class="mb-0 text-muted">© <script>document.write(new Date().getFullYear())</script> <?=env('APP_NAME')?>. -->
                            <!--Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="#" target="_blank">{{env('COPY_WRIGHT')}}</a>-->
        <!--                    </p>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</footer>-->


    <script src="<?=base_url('public/')?>/toast/saber-toast.js"></script>
    <script src="<?=base_url('public/')?>/toast/script.js"></script>
    <!-- <script>check_login()</script> -->

    <!-- JAVASCRIPT -->
    <script src="<?=base_url('public/')?>/assetsadmin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/js/plugins.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/js/pages/form-validation.init.js"></script>
    <!-- password-addon init -->
    <script src="<?=base_url('public/')?>/assetsadmin/js/pages/password-addon.init.js"></script>
</body>

</html>