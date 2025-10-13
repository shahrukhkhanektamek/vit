<?php 

$routes->group('payment', ['namespace' => 'App\Controllers\Payment',] ,function ($routes) {

    $routes->post('create-transaction', 'PaymentController::create_transaction');
    $routes->get('pay', 'PaymentController::pay');
    $routes->get('make-payment', 'PaymentController::make_payment');
    $routes->post('response', 'PaymentController::response');

});

$routes->group('/', ['namespace' => 'App\Controllers\Payment',] ,function ($routes) {
    $routes->get('payment-block', 'PaymentController::payment_block');
    $routes->get('payment-faild', 'PaymentController::payment_faild');
    $routes->get('payment-success', 'PaymentController::payment_success');
});
    
