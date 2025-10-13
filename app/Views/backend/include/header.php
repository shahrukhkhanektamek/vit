<?php 
$login_user = get_user();
$user_role = get_role_by_id($login_user->role);


$setting = \App\Models\Setting::get();
$logo_setting = $setting['logo'];

?>


<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?=env('APP_NAME')?></title>

    <meta name="_token" content="<?= csrf_hash() ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=base_url('upload/').'/'.$logo_setting->favicon_image?>">

    <!-- One of the following themes -->
 <link rel="stylesheet" href="<?=base_url('public/assetsadmin/libs/@simonwep/pickr/themes/classic.min.css') ?>" />
<link rel="stylesheet" href="<?=base_url('public/assetsadmin/libs/@simonwep/pickr/themes/monolith.min.css') ?>" />
<link rel="stylesheet" href="<?=base_url('public/assetsadmin/libs/@simonwep/pickr/themes/nano.min.css') ?>" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/css/intlTelInput.css" rel="stylesheet" />

    <script src="<?=base_url('public/')?>/assetsadmin/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?=base_url('public/')?>/assetsadmin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url('public/')?>/assetsadmin/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?=base_url('public/')?>/assetsadmin/css/app.min.css" rel="stylesheet" type="text/css" />
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">





    <link rel="stylesheet" href="<?=base_url('public')?>/toast/saber-toast.css">
    <link rel="stylesheet" href="<?=base_url('public')?>/toast/style.css">
    <link rel="stylesheet" href="<?=base_url('public')?>/front_css.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?=base_url('public')?>/front_script.js"></script>
    <link rel="stylesheet" href="<?=base_url('public')?>/upload-multiple/style.css">
    <script src="<?=base_url('public')?>/upload-multiple/script.js"></script>
    <link rel="stylesheet" href="<?=base_url('public/')?>/assetsadmin/select2/css/select2.min.css">




    <script src="https://cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>


    <style>
    .pagination svg {
        width: 10px;
    }
    
    .pagination  {
        display: flex;
        justify-content: space-between;
    }
    .pagination li a {
        padding: 3px 10px !important;
        display: inline-block;
        border: 1px solid;
        margin: 0 5px 0 0;
        border-radius: 3px;
    }
    .pagination li.active a {
        background: lightgray;
        border-color: lightgray;
    }
    


    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #71519d;
      border: 1px solid #71519d;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      color: white;
    }
    .select2-container .select2-selection--single
    {
      height: calc(2.25rem + 2px);
    }
    .select2-container--default .select2-selection--single {
        padding: 5px 5px;
        padding-top: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
      top: 70%;
    }
    .select2-container--default .select2-selection--single {
      border: 1px solid #ced4da;
    }
    #data-list {
        position: relative;
        min-height: 250px;
    }
    .my-loader2 {
        position: absolute;
    }
    .hide
    {
        display: none;
    }

    .select2-container {
        z-index: 1102;
    }

    .ui-sortable-handle {
        cursor: move;
    }
    .card-header .select2-container
    {
        z-index: 1;
    }
    .detail-popup {
        position: absolute;
        z-index: 999;
        width: 200px;
        background: white;
        padding: 5px 5px;
        top: 50%;
        left: 99%;
        border-radius: 5px;
         display: none; 
    }
    .person:hover .detail-popup {
        display: block;
    }
    .detail-popup p {
        font-size: 12px;
        margin: 0;
        color: #3BAA9D !important;
    }
    .person {
        position: relative;
    }
    .table>:not(caption)>*>* a {
        font-weight: 800;
        text-decoration: underline;
    }
    td .btn {
        text-decoration: none !important;
    }
    .earningboard {
        background-image: linear-gradient(to right, #7bf1fd, #0753b1);
        padding: 17px;
        border-radius: 10px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 10px;
    }
    .hovercard:hover {
        background: linear-gradient(45deg, #69390e, #a3721e) !important;
        transition: 0.25s;
    }
    .secondcolor {
        background-image: linear-gradient(to right, #10879b, #0557ab) !important;
    }
    .thirdcolor {
        background-image: linear-gradient(to right, #1a4253, #04489c) !important;
    }
    .fourthcolor {
        background-image: linear-gradient(to right, #38184a, #0545a6) !important;
    }
    .innerboard span {
        font-size: 64px;
        color: white;
    }
    .hovercard:hover h2 {
        color: white !important;
    }

    .innercontent h2 {
        color: white;
        /* text-align: right; */
        font-size: 32px;
        font-weight: 800;
    }
    .innercontent h3 {
        color: white;
    }
    .user-d-img {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 3px solid white;
    }
    .z-index1 .select2 {
    z-index: 1;
}
.followup-btn.active {
    background: #d53439;
    border: #d53439;
}
.cke_notifications_area{display:none !important;}

.resaponse-area-card {
    min-height: 150px;
    display: none;
}

.resaponse-area-copy-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 20px;
}

</style>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

    <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?=base_url(route_to($user_role->route.'.dashboard'))?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" alt="logo" height="34">
                        </span>
                        <!-- <span class="logo-lg">
                            <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" alt="" height="17">
                        </span> -->
                    </a>
                    <!-- <a href="<?=base_url(route_to($user_role->route.'.dashboard'))?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" alt="logo" height="42">
                        </span>
                    </a> -->
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

             

        

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?=image_check($login_user->image,'user.png') ?>" loading="lazy" alt="Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?=$login_user->name?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                    <?=$user_role->name?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <!-- <h6 class="dropdown-header">Welcome Giannina!</h6> -->
                        <a class="dropdown-item" href="<?=base_url(route_to($user_role->route.'.profile.index'))?>"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="<?=base_url(route_to($user_role->route.'.password.index'))?>"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Password</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item logout" ><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="<?=base_url(route_to($user_role->route.'.dashboard'))?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?=base_url('upload/').'/'.$logo_setting->favicon_image?>?tr=?tr=w-auto,h-30,fo-ico" loading="lazy" alt="icon" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" loading="lazy" alt="logo" height="42">
                    </span>
                </a>
                <!-- Light Logo-->
                <!-- <a href="<?=base_url(route_to($user_role->route.'.dashboard'))?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?=base_url('upload/').'/'.$logo_setting->favicon_image?>" loading="lazy" alt="favicon" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?=base_url('upload/').'/'.$logo_setting->logo_image?>" loading="lazy" alt="logo" height="42">
                    </span>
                </a> -->
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
    
            <!-- <div class="dropdown sidebar-user m-1 rounded">
                <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center gap-2">
                        <img class="rounded header-profile-user" src="<?=base_url('public/')?>/assetsadmin/images/users/avatar-1.jpg" alt="Header Avatar">
                        <span class="text-start">
                            <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                            <span class="d-block fs-14 sidebar-user-name-sub-text"><i class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span class="align-middle">Online</span></span>
                        </span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Welcome Anna!</h6>
                    <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                    <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                    <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                    <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
                    <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                    <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                    <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                </div>
            </div> -->
            <div id="scrollbar">
                <div class="container-fluid">


                    <div id="two-column-menu">
                    </div>
                    



                    <ul class="navbar-nav" id="navbar-nav">
                        <!--<li class="menu-title"><span data-key="t-menu">Menu</span></li>-->
                        

                        
                        <?=view('backend/include/nav/'.$user_role->nav)?>
                        






                        
                        <li class="nav-item">
                            <a class="nav-link menu-link logout" >
                                <i class="ri-logout-circle-r-line"></i> <span data-key="t-logout">Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
