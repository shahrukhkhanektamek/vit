<?php 

$routes->group('partner', ['namespace' => 'App\Controllers\Partner', 'filter'=>'PartnerAuth',] ,function ($routes) {

    $routes->get('dashboard', 'PartnerDashboardController::index', ['as' => 'partner.dashboard']);


    $routes->group('profile', function($routes) {
        $routes->get('/', 'PartnerProfileController::index', ['as' => 'partner.profile.index']);
        $routes->post('update', 'PartnerProfileController::update', ['as' => 'partner.profile.update']);
        $routes->post('update-profile-image', 'PartnerProfileController::update_profile_image', ['as' => 'partner.profile.update-profile-image']);
    });

    $routes->group('password', function($routes) {
        $routes->get('/', 'PartnerPasswordController::index', ['as' => 'partner.password.index']);
        $routes->post('update', 'PartnerPasswordController::update', ['as' => 'partner.password.update']);
    });

    $routes->group('kyc', function($routes) {
        $routes->get('/', 'PartnerKycController::index', ['as' => 'partner.kyc.index']);
        $routes->post('update', 'PartnerKycController::update', ['as' => 'partner.kyc.update']);
    });

    $routes->group('earning', function($routes) {
        $routes->get('/', 'PartnerEarningController::index', ['as' => 'partner.earning.list']);
        $routes->get('load_data', 'PartnerEarningController::load_data', ['as' => 'partner.earning.load_data']);
    });


    $routes->group('package', function($routes) {
        $routes->get('/', 'VendorPackageController::index', ['as' => 'partner.package.list']);
        $routes->get('load_data', 'VendorPackageController::load_data', ['as' => 'partner.package.load_data']);
        $routes->post('get_package', 'VendorPackageController::get_package', ['as' => 'partner.package.get_package']);
    });

    $routes->group('package-history', function($routes) {
        $routes->get('/', 'VendorPackageHistoryController::index', ['as' => 'partner.package-history.list']);
        $routes->get('load_data', 'VendorPackageHistoryController::load_data', ['as' => 'partner.package-history.load_data']);
    });


    $routes->group('lead', function($routes) {
        $routes->get('/', 'PartnerLeadController::index', ['as' => 'partner.lead.list']);
        $routes->get('load_data', 'PartnerLeadController::load_data', ['as' => 'partner.lead.load_data']);
        $routes->get('view/(:any)', 'PartnerLeadController::view/$1', ['as' => 'partner.lead.view']);
        $routes->post('scratch', 'PartnerLeadController::scratch', ['as' => 'partner.lead.scratch']);
    });

    $routes->group('appointment', function($routes) {
        $routes->get('/', 'PartnerAppointmentController::index', ['as' => 'partner.appointment.list']);
        $routes->get('load_data', 'PartnerAppointmentController::load_data', ['as' => 'partner.appointment.load_data']);
        $routes->get('view/(:any)', 'PartnerAppointmentController::view/$1', ['as' => 'partner.appointment.view']);
        $routes->post('scratch', 'PartnerAppointmentController::scratch', ['as' => 'partner.appointment.scratch']);
    });

    $routes->group('review', function($routes) {
        $routes->get('/', 'PartnerReviewController::index', ['as' => 'partner.review.list']);
        $routes->get('load_data', 'PartnerReviewController::load_data', ['as' => 'partner.review.load_data']);
    });

    $routes->group('booking-enquiry', function($routes) {
        $routes->get('/', 'VendorBookingEnquiryController::index', ['as' => 'partner.booking-enquiry.list']);
        $routes->get('load_data', 'VendorBookingEnquiryController::load_data', ['as' => 'partner.booking-enquiry.load_data']);
        $routes->get('view/(:any)', 'VendorBookingEnquiryController::view/$1', ['as' => 'partner.booking-enquiry.view']);
        $routes->post('scratch', 'VendorBookingEnquiryController::scratch', ['as' => 'partner.booking-enquiry.scratch']);
    });


    
    



});

