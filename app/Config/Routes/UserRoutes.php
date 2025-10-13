<?php 

$routes->group('user', ['namespace' => 'App\Controllers\User', 'filter'=>'UserAuth',] ,function ($routes) {
    
    // $routes->add('user/(:any)', 'Home::all/$1');

    $routes->get('dashboard', 'UserDashboardController::index', ['as' => 'user.dashboard']);


    $routes->group('profile', function($routes) {
        $routes->get('/', 'UserProfileController::index', ['as' => 'user.profile.index']);
        $routes->post('update', 'UserProfileController::update', ['as' => 'user.profile.update']);
        $routes->post('update-profile-image', 'UserProfileController::update_profile_image', ['as' => 'user.profile.update-profile-image']);
    });

    $routes->group('password', function($routes) {
        $routes->get('/', 'UserPasswordController::index', ['as' => 'user.password.index']);
        $routes->post('update', 'UserPasswordController::update', ['as' => 'user.password.update']);
    });


    $routes->group('advocates', function($routes) {
        $routes->get('/', 'UserAdvocatesController::index', ['as' => 'user.advocates.list']);
        $routes->get('load_data', 'UserAdvocatesController::load_data', ['as' => 'user.advocates.load_data']);
        $routes->get('view/(:any)', 'UserAdvocatesController::view/$1', ['as' => 'user.advocates.view']);
        $routes->post('scratch', 'UserAdvocatesController::scratch', ['as' => 'user.advocates.scratch']);
    });


    $routes->group('package', function($routes) {
        $routes->get('/', 'UserPackageController::index', ['as' => 'user.package.list']);
        $routes->get('load_data', 'UserPackageController::load_data', ['as' => 'user.package.load_data']);
        $routes->post('get_package', 'UserPackageController::get_package', ['as' => 'user.package.get_package']);

    });

    $routes->group('package-history', function($routes) {
        $routes->get('/', 'UserPackageHistoryController::index', ['as' => 'user.package-history.list']);
        $routes->get('load_data', 'UserPackageHistoryController::load_data', ['as' => 'user.package-history.load_data']);
    });


    $routes->group('review', function($routes) {
        $routes->get('/', 'UserReviewController::index', ['as' => 'user.review.list']);
        $routes->get('load_data', 'UserReviewController::load_data', ['as' => 'user.review.load_data']);
        $routes->post('delete', 'UserReviewController::delete', ['as' => 'user.review.delete']);
        $routes->post('add', 'UserReviewController::add', ['as' => 'user.review.add']);
    });

    $routes->group('lead', function($routes) {
        $routes->get('/', 'UserLeadController::index', ['as' => 'user.lead.list']);
        $routes->get('load_data', 'UserLeadController::load_data', ['as' => 'user.lead.load_data']);
    });

    $routes->group('appointment', function($routes) {
        $routes->get('/', 'UserAppointmentController::index', ['as' => 'user.appointment.list']);
        $routes->get('load_data', 'UserAppointmentController::load_data', ['as' => 'user.appointment.load_data']);
        $routes->post('book', 'UserAppointmentController::book', ['as' => 'user.review.book']);
        
        $routes->get('success/(:any)', 'UserAppointmentController::appointment_success/$1', ['as' => 'user.review.success']);
        $routes->get('invoice/(:any)', 'UserAppointmentController::appointment_invoice/$1', ['as' => 'user.review.invoice']);

    });



});

