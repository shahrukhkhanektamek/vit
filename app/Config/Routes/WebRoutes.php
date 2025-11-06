<?php 



$routes->add('(.*)', 'Home::all/$1');
// $routes->add('user/(:any)', 'Home::all/$1');
$routes->get('for-testing', 'Test::index');


$routes->post('bike-modal', 'Home::bike_modal');



$routes->post('search-vendor', 'Home::search_vendor');
$routes->post('search-partner', 'Home::search_partner');
$routes->post('search-user', 'Home::search_user');
$routes->post('search-employee', 'Home::search_employee');
$routes->post('search-country', 'Home::search_country');
$routes->post('search-state', 'Home::search_state');
$routes->post('search-city', 'Home::search_city');
$routes->post('search-education', 'Home::search_education');


$routes->post('contact-enquiry', 'Enquiry::contact_enquiry');
$routes->post('lead-enquiry', 'Enquiry::lead_enquiry');

$routes->get('result', 'Result::get');

