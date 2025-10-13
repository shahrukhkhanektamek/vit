
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>Singup - Free Spirit Pole Dance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="<?= csrf_hash() ?>">
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://ik.imagekit.io/freespiritpoledance/logo/favicon.png?tr=fo-ico">
    <!-- Layout config Js -->
    <script src="{{url('public/')}}/assetsadmin/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{url('public/')}}/assetsadmin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url('public/')}}/assetsadmin/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url('public/')}}/assetsadmin/css/app.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/css/intlTelInput.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{url('public')}}/toast/saber-toast.css">
    <link rel="stylesheet" href="{{url('public')}}/toast/style.css">
    <link rel="stylesheet" href="{{url('public')}}/front_css.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{url('public')}}/front_script.js"></script>

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
                        <div class="text-center mt-sm-3 mb-4 text-white-50">
                            <div>
                                <a href="login.php" class="d-inline-block auth-logo">
                                    <img src="https://ik.imagekit.io/freespiritpoledance/logo/white-logo.svg" loading="lazy" alt="logo" height="46">
                                </a>
                            </div>
                            <p class="mt-2 fs-15 fw-medium">The Art of Pole Dancing & Flexibility</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-5 mt-md-2 mt-lg-2 card-bg-fill">

                            <div class="card-body p-3 p-md-4 p-lg-4">
                                <div class="">
                                    <form class="row gx-3 form_data" action="{{route('auth.register-action')}}" method="post" id="LoginForm" novalidate >
                                        <div class="col-lg-6 col-md-6 mb-3">
                                            <label for="studentname" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="studentname" placeholder="Enter name" autocomplete="false" name="name" required>
                                            <div class="invalid-feedback">Please enter name</div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-3">
                                            <div class="row gx-2">
                                                <div class="col-lg-7 col-md-7 col-6">
                                                    <label for="studentsex" class="form-label">Sex <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="studentsex" name="gender" required>
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                        <option value="3">Other</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please enter sex</div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-6">
                                                    <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="age" name="age" placeholder="i.e 32" required>
                                                    <div class="invalid-feedback">Please provide a valid phone number.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <label for="phone" class="form-label">Phone number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phone" name="mobile" placeholder="i.e 1234567890" required>
                                            <div class="invalid-feedback">Please provide a valid phone number.</div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 mb-3">
                                            
                                            <label class="btn btn-success"><input type="radio" name="type" value="2" checked> Student</label>
                                            <label class="btn btn-primary"><input type="radio" name="type" value="3"> Teacher</label>
                                            
                                        </div>

                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <label for="useremail" class="form-label">Email address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="useremail" placeholder="Enter email address" name="email" required>
                                            <div class="invalid-feedback">Please enter email</div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <label class="form-label" for="password-input">Create password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">Please enter password</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <label class="form-label" for="confirm-password-input">Confirm password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 confirm-password-input" onpaste="return false" placeholder="Enter password" id="confirm-password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="cpassword" required>
                                                
                                                <div class="invalid-feedback">Please enter password</div>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the Free Spirit <a href="#" target="_blank" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                        </div>

                                        <div id="password-contain" class="p-3 bg-light rounded">
                                            <h5 class="fs-13">Password must contain:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                        </div>

                                        <div class="mt-2">
                                            <button class="btn btn-success w-100" type="submit">Sign Up<i class="ri-login-circle-line ms-2"></i></button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account? <a href="{{route('auth.login')}}" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <footer class="footer login_style">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">© <script>document.write(new Date().getFullYear())</script> Free Spirit Pole Dance. Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://nabilansari.in/" target="_blank">nabilansari.in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    <!-- JAVASCRIPT -->
    <script src="{{url('public/')}}/assetsadmin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('public/')}}/assetsadmin/js/plugins.js"></script>
    <!-- validation init -->
    <script src="{{url('public/')}}/assetsadmin/js/pages/form-validation.init.js"></script>
    <!-- password create init -->
    <script src="{{url('public/')}}/assetsadmin/js/pages/passowrd-create.init.js"></script>
    <!-- prismjs plugin -->
    <script src="{{url('public/')}}/assetsadmin/libs/prismjs/prism.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/intlTelInput.js"></script>


<script src="{{url('public/')}}/toast/saber-toast.js"></script>
    <script src="{{url('public/')}}/toast/script.js"></script>

<script>
const input = document.querySelector("#phone");
const iti = window.intlTelInput(input, {
  separateDialCode: "true",
  initialCountry: "ch",
  countrySearch: "true",
  validationNumberType: "MOBILE",
  utilsScript:
    "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/utils.js"
});

// store the instance variable so we can access it in the console e.g. window.iti.getNumber()
window.iti = iti;
</script>

</body>

</html>