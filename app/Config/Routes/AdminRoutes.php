<?php 

$adminEmployeeRoutes = function ($routes) {
    
    $routes->get('dashboard', 'AdminDashboardController::index', ['as' => 'admin.dashboard']);


    $routes->group('profile', function($routes) {
        $routes->get('/', 'AdminProfileController::index', ['as' => 'admin.profile.index']);
        $routes->post('update', 'AdminProfileController::update', ['as' => 'admin.profile.update']);
        $routes->post('update-profile-image', 'AdminProfileController::update_profile_image', ['as' => 'admin.profile.update-profile-image']);
    });

    $routes->group('password', function($routes) {
        $routes->get('/', 'AdminPasswordController::index', ['as' => 'admin.password.index']);
        $routes->post('update', 'AdminPasswordController::update', ['as' => 'admin.password.update']);
    });

    $routes->group('setting', function($routes) {
        $routes->get('main', 'AdminSettingController::main', ['as' => 'setting.main']);
        $routes->post('main-update', 'AdminSettingController::main_update', ['as' => 'setting.main-update']);

        $routes->get('policy', 'AdminSettingController::policy', ['as' => 'setting.policy']);
        $routes->post('policy-update', 'AdminSettingController::policy_update', ['as' => 'setting.policy-update']);

        $routes->get('logo', 'AdminSettingController::logo', ['as' => 'setting.logo']);
        $routes->post('logo-update', 'AdminSettingController::logo_update', ['as' => 'setting.logo-update']);        
    });



    $routes->group('script', function($routes) {
        $routes->get('/', 'AdminScriptController::index', ['as' => 'script.index']);
        $routes->post('update', 'AdminScriptController::update', ['as' => 'script.update']);
    });

    $routes->group('meta-tag', function($routes) {
        $routes->get('/', 'AdminMetaTagController::index', ['as' => 'meta-tag.list']);
        $routes->get('load_data', 'AdminMetaTagController::load_data', ['as' => 'meta-tag.load_data']);
        $routes->get('add', 'AdminMetaTagController::add', ['as' => 'meta-tag.add']);
        $routes->get('edit/(:any)?', 'AdminMetaTagController::edit/$1', ['as' => 'meta-tag.edit']);
        $routes->get('view/(:any)', 'AdminMetaTagController::view/$1', ['as' => 'meta-tag.view']);
        $routes->post('update', 'AdminMetaTagController::update', ['as' => 'meta-tag.update']);
        $routes->post('delete/(:any)', 'AdminMetaTagController::delete/$1', ['as' => 'meta-tag.delete']);
        $routes->post('block_unblock/(:any)', 'AdminMetaTagController::block_unblock/$1', ['as' => 'meta-tag.block_unblock']);
    });


    $routes->group('country', function($routes) {
        $routes->get('/', 'AdminCountryController::index', ['as' => 'country.list']);
        $routes->get('load_data', 'AdminCountryController::load_data', ['as' => 'country.load_data']);
        $routes->get('add', 'AdminCountryController::add', ['as' => 'country.add']);
        $routes->get('edit/(:any)?', 'AdminCountryController::edit/$1', ['as' => 'country.edit']);
        $routes->get('view/(:any)', 'AdminCountryController::view/$1', ['as' => 'country.view']);
        $routes->post('update', 'AdminCountryController::update', ['as' => 'country.update']);
        $routes->post('delete/(:any)', 'AdminCountryController::delete/$1', ['as' => 'country.delete']);
        $routes->post('block_unblock/(:any)', 'AdminCountryController::block_unblock/$1', ['as' => 'country.block_unblock']);
    });

    $routes->group('state', function($routes) {
        $routes->get('/', 'AdminStateController::index', ['as' => 'state.list']);
        $routes->get('load_data', 'AdminStateController::load_data', ['as' => 'state.load_data']);
        $routes->get('add', 'AdminStateController::add', ['as' => 'state.add']);
        $routes->get('edit/(:any)?', 'AdminStateController::edit/$1', ['as' => 'state.edit']);
        $routes->get('view/(:any)', 'AdminStateController::view/$1', ['as' => 'state.view']);
        $routes->post('update', 'AdminStateController::update', ['as' => 'state.update']);
        $routes->post('delete/(:any)', 'AdminStateController::delete/$1', ['as' => 'state.delete']);
        $routes->post('block_unblock/(:any)', 'AdminStateController::block_unblock/$1', ['as' => 'state.block_unblock']);
    });

    $routes->group('city', function($routes) {
        $routes->get('/', 'AdminCityController::index', ['as' => 'city.list']);
        $routes->get('load_data', 'AdminCityController::load_data', ['as' => 'city.load_data']);
        $routes->get('add', 'AdminCityController::add', ['as' => 'city.add']);
        $routes->get('edit/(:any)?', 'AdminCityController::edit/$1', ['as' => 'city.edit']);
        $routes->get('view/(:any)', 'AdminCityController::view/$1', ['as' => 'city.view']);
        $routes->post('update', 'AdminCityController::update', ['as' => 'city.update']);
        $routes->post('delete/(:any)', 'AdminCityController::delete/$1', ['as' => 'city.delete']);
        $routes->post('block_unblock/(:any)', 'AdminCityController::block_unblock/$1', ['as' => 'city.block_unblock']);
    });
    




    $routes->group('admin-user', function($routes) {
        $routes->get('/', 'AdminUserController::index', ['as' => 'admin-user.list']);
        $routes->get('load_data', 'AdminUserController::load_data', ['as' => 'admin-user.load_data']);
        $routes->get('add', 'AdminUserController::add', ['as' => 'admin-user.add']);
        $routes->get('edit/(:any)?', 'AdminUserController::edit/$1', ['as' => 'admin-user.edit']);
        $routes->get('view/(:any)', 'AdminUserController::view/$1', ['as' => 'admin-user.view']);
        $routes->post('update', 'AdminUserController::update', ['as' => 'admin-user.update']);

        $routes->get('change-password/(:any)', 'AdminUserController::change_password/$1', ['as' => 'admin-user.change-password']);
        $routes->post('change-password-action', 'AdminUserController::change_password_action', ['as' => 'admin-user.change-password-action']);

        $routes->post('delete/(:any)', 'AdminUserController::delete/$1', ['as' => 'admin-user.delete']);
        $routes->post('block_unblock/(:any)', 'AdminUserController::block_unblock/$1', ['as' => 'admin-user.block_unblock']);
    });




    $routes->group('certificate', function($routes) {
        $routes->get('/', 'AdminCertificateController::index', ['as' => 'certificate.list']);
        $routes->get('load_data', 'AdminCertificateController::load_data', ['as' => 'certificate.load_data']);
        $routes->get('add', 'AdminCertificateController::add', ['as' => 'certificate.add']);
        $routes->get('edit/(:any)?', 'AdminCertificateController::edit/$1', ['as' => 'certificate.edit']);
        $routes->get('view/(:any)?', 'AdminCertificateController::view/$1', ['as' => 'certificate.view']);
        $routes->post('update', 'AdminCertificateController::update', ['as' => 'certificate.update']);
        $routes->post('delete/(:any)', 'AdminCertificateController::delete/$1', ['as' => 'certificate.delete']);
        $routes->post('block_unblock/(:any)', 'AdminCertificateController::block_unblock/$1', ['as' => 'certificate.block_unblock']);
    });


    $routes->group('result', function($routes) {
        $routes->get('/', 'AdminResultController::index', ['as' => 'result.list']);
        $routes->get('load_data', 'AdminResultController::load_data', ['as' => 'result.load_data']);
        $routes->get('add', 'AdminResultController::add', ['as' => 'result.add']);
        $routes->get('edit/(:any)?', 'AdminResultController::edit/$1', ['as' => 'result.edit']);
        $routes->get('view/(:any)?', 'AdminResultController::view/$1', ['as' => 'result.view']);
        $routes->post('update', 'AdminResultController::update', ['as' => 'result.update']);
        $routes->post('delete/(:any)', 'AdminResultController::delete/$1', ['as' => 'result.delete']);
        $routes->post('block_unblock/(:any)', 'AdminResultController::block_unblock/$1', ['as' => 'result.block_unblock']);
    });




    /*enquiry statrt*/      

        $routes->group('contact-enquiry', function($routes) {
            $routes->get('/', 'AdminContactEnquiryController::index', ['as' => 'contact-enquiry.list']);
            $routes->get('load_data', 'AdminContactEnquiryController::load_data', ['as' => 'contact-enquiry.load_data']);
            $routes->get('view/(:any)', 'AdminContactEnquiryController::view/$1', ['as' => 'contact-enquiry.view']);
            $routes->post('delete/(:any)', 'AdminContactEnquiryController::delete/$1', ['as' => 'contact-enquiry.delete']);
        });

    /*enquiry end*/

};



$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter'=>'AdminAuth',], $adminEmployeeRoutes);


