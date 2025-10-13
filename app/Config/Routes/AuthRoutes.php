<?php 



$routes->group('admin', ['namespace' => 'App\Controllers'] ,function ($routes) {
    $routes->get('/', 'AuthBackend::login_view');
});
$routes->group('vendor', ['namespace' => 'App\Controllers'] ,function ($routes) {
    $routes->get('/', 'AuthBackend::login_view');
});


$routes->group('auth', ['namespace' => 'App\Controllers'] ,function ($routes) {
    
    $routes->get('/', 'AuthBackend::login_view');
    $routes->get('login', 'AuthBackend::login_view', ['as' => 'auth.login']);
    $routes->post('login-action', 'AuthBackend::login_action', ['as' => 'auth.login-action']);
    $routes->get('logout', 'AuthBackend::logout', ['as' => 'auth.logout']);
    $routes->post('check_login', 'AuthBackend::check_login', ['as' => 'check_login']);

});


$routes->group('user', ['namespace' => 'App\Controllers'] ,function ($routes) {
    
    $routes->get('/', 'AuthUser::login_view');
    $routes->get('login', 'AuthUser::login_view', ['as' => 'auth.user.login']);
    $routes->post('login-action', 'AuthUser::login_action', ['as' => 'auth.user.login-action']);
    $routes->get('logout', 'AuthUser::logout', ['as' => 'auth.user.logout']);
    $routes->post('check_login', 'AuthUser::check_login', ['as' => 'check_login']);
    $routes->post('send_password', 'AuthUser::send_password', ['as' => 'auth.user.send_password']);

    $routes->post('signup-action', 'AuthUser::register_action', ['as' => 'auth.user.signup-action']);

});

$routes->group('vendor', ['namespace' => 'App\Controllers'] ,function ($routes) {
    
    $routes->post('login-action', 'AuthUser::login_action', ['as' => 'auth.vendor.login-action']);
    $routes->post('vendor-signup-action', 'AuthUser::vendor_register_action', ['as' => 'auth.vendor.signup-action']);

});

