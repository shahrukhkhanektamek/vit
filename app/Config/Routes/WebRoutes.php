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


$routes->group('gemini', function($routes) {

    $routes->group('ask-ally', function($routes) {
        $routes->get('/', 'GeminiController::ask_ally');
        $routes->post('action', 'GeminiController::action');
    });

    $routes->group('legal-research', function($routes) {
        $routes->get('/', 'GeminiController::legal_research');
        $routes->post('legal_research_action', 'GeminiController::legal_research_action');
    });

    $routes->group('legal-drafting', function($routes) {
        $routes->get('/', 'GeminiController::legal_drafting');
        $routes->post('legal_drafting_action', 'GeminiController::legal_drafting_action');
    });

    $routes->group('translator', function($routes) {
        $routes->get('/', 'GeminiController::translator');
        $routes->post('translator_action', 'GeminiController::translator_action');
    });
    
    $routes->group('complaint-writer', function($routes) {
        $routes->get('/', 'GeminiController::complaint_writer');
        $routes->post('complaint_writer_action', 'GeminiController::complaint_writer_action');
    });
    
    $routes->group('document-generator', function($routes) {
        $routes->get('/', 'GeminiController::document_generator');
        $routes->post('document_generator_action', 'GeminiController::document_generator_action');
    });
    
    $routes->group('document-analyzer', function($routes) {
        $routes->get('/', 'GeminiController::document_analyzer');
        $routes->post('document_analyzer_action', 'GeminiController::document_analyzer_action');
    });
    
    $routes->group('law-news', function($routes) {
        $routes->get('/', 'GeminiController::law_news');
        $routes->post('law_news_action', 'GeminiController::law_news_action');
    });
    
    $routes->group('legal-acts', function($routes) {
        $routes->get('/', 'GeminiController::legal_acts');
        $routes->post('legal_acts_action', 'GeminiController::legal_acts_action');
    });

});

