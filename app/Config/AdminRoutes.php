<?php
$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {
    
    // Login/out
    $routes->get('/', 'AuthController::login');
    $routes->match(['get','post'], 'home', 'Home::index',['filter' => 'login']); // main page
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout',['filter'=>'login']);
    
    // Activation
    $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets password
    $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot', 'AuthController::attemptForgot');
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthController::attemptReset');

    //settings
    $routes->get('settings','SettingsController::index',['filter'=>'login:admin']);
    $routes->post('settings/save','SettingsController::save',['filter'=>'login:admin']);
    $routes->get('settings/remove_logo/(:any)','SettingsController::remove_logo/$1',['filter'=>'login:admin']);

    // Email Template
    $routes->get('email','EmailTemplatesController::index',['filter'=>'login:admin']);
    $routes->post('email/template/update','EmailTemplatesController::updateTemplate',['filter'=>'login:admin']);
    $routes->get('email/template/(:num)','EmailTemplatesController::getEmailTemplate/$1',['filter'=>'login:admin']);
    $routes->get('email/template/enable/(:num)','EmailTemplatesController::enable_template/$1',['filter'=>'login:admin']);
    $routes->get('email/template/disable/(:num)','EmailTemplatesController::disable_template/$1',['filter'=>'login:admin']);
    $routes->post('send_test_email','SettingsController::send_test_email',['filter'=>'login']);

    //category management
    $routes->get('category','CategoryController::index',['filter'=>'login:admin']);
    $routes->get('category/create','CategoryController::create',['filter'=>'login:admin']);
    $routes->post('category/store(/:num)?','CategoryController::store/$1',['filter'=>'login:admin']);
    $routes->get('category/edit/(:num)','CategoryController::edit/$1',['filter'=>'login:admin']);
    $routes->post('category/delete/(:num)','CategoryController::delete/$1',['filter'=>'login:admin']);
    $routes->post('category/table', 'CategoryController::table',['filter'=>'login:admin']);

    //roadmap management
    $routes->get('roadmap', 'RoadmapController::index',['filter'=>'login:admin']);    
    $routes->post('roadmap/update','RoadmapController::update',['filter'=>'login:admin']);
    $routes->post('roadmap/table', 'RoadmapController::table',['filter'=>'login:admin']);

    //boards management
    $routes->get('boards','BoardsController::index',['filter'=>'login:admin']);
    $routes->get('boards/create','BoardsController::create',['filter'=>'login:admin']);
    $routes->post('boards/store(/:num)?','BoardsController::store/$1',['filter'=>'login:admin']);
    $routes->get('boards/edit/(:num)','BoardsController::edit/$1',['filter'=>'login:admin']);
    $routes->post('boards/delete/(:num)','BoardsController::delete/$1',['filter'=>'login:admin']);
    $routes->post('boards/table', 'BoardsController::table',['filter'=>'login:admin']);

    //Feedback management
    $routes->get('feedback','FeedbackController::index',['filter'=>'login']);
    $routes->post('feedback/delete/(:num)','FeedbackController::delete/$1',['filter'=>'login']);
    $routes->post('feedback/update','FeedbackController::update',['filter'=>'login']);
    $routes->post('feedback/status_edit/(:num)','FeedbackController::status_edit/$1',['filter'=>'login']);
    $routes->post('feedback/category_edit/(:num)','FeedbackController::category_edit/$1',['filter'=>'login']);

    $routes->post('feedback/table','FeedbackController::table',['filter'=>'login']);
    $routes->get('feedback/create','FeedbackController::create',['filter'=>'login:admin']);
    $routes->post('feedback/store','FeedbackController::store',['filter'=>'login:admin']);
    $routes->post('feedback/request_more_info/(:num)','FeedbackController::request_more_info/$1',['filter'=>'login']);
    $routes->get('feedback/request_more_info/(:num)','FeedbackController::request_more_info/$1',['filter'=>'login']);
    $routes->get('feedback/edit/(:num)','FeedbackController::edit/$1',['filter'=>'login']);
    $routes->get('feedback/comments(/:num)?','FeedbackIdeasController::index/$1',['filter'=>'login']);
    $routes->post('feedback/comments/table','FeedbackIdeasController::table',['filter'=>'login']);
    $routes->post('change/comment/status','FeedbackIdeasController::change_comment_status',['filter'=>'login']);
    $routes->match(['get','post'],'comment/(:num)/edit','FeedbackIdeasController::edit_comment/$1',['filter'=>'login']);
    $routes->get('comment/(:num)/delete','FeedbackIdeasController::delete_comment/$1',['filter'=>'login']);


    //Users
    $routes->get('users','UserController::index',['filter'=>'login:admin']);
    $routes->get('users/update','UserController::update',['filter'=>'login:admin']);
    $routes->post('users/delete/(:num)','UserController::delete/$1',['filter'=>'login:admin']);
    $routes->post('users/table','UserController::table',['filter'=>'login:admin']);

    $routes->get('members','MemberController::index',['filter'=>'login:admin']);
    $routes->post('members/table','MemberController::table',['filter'=>'login:admin']);
    $routes->post('members/delete/(:num)','MemberController::delete/$1',['filter'=>'login:admin']);
    $routes->post('members/store(/:num)?','MemberController::store/$1',['filter'=>'login:admin']);
    $routes->get('members/show(/:num)?','MemberController::show/$1',['filter'=>'login:admin']);

    //charts
    $routes->post('refresh_chart','Home::refresh_chart_data',['filter'=>'login']);

});