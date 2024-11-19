<?php

$routes->group('api', ['namespace' => 'App\Controllers\Api'],['filter' => 'cors'],function($routes){
    $routes->get('category/board/(:num)','CategoryController::index/$1');
    $routes->get('category/(:num)','CategoryController::show/$1');
    $routes->get('settings','SettingsController::index');    
    $routes->post('(:num)/feedback/save','FeedbackController::create/$1');
    $routes->match(['get','post'],'feedback/index/(:num)','FeedbackController::index/$1');
    $routes->get('feedback/index/(:num)(/:num)?','FeedbackController::index/$1/$2');
    $routes->get('feedback/(:num)','FeedbackController::show/$1');
    $routes->get('feedback/count/(:num)','FeedbackController::feedbacks_status_count/$1');
    $routes->get('feedback/votecount','FeedbackController::feedbacks_vote_count');
    $routes->get('board','BoardController::index');
    $routes->get('roadmap','RoadmapController::index');
    $routes->post('users/create','UsersController::create');
    $routes->post('ideas/(:num)/vote','UpvotesController::update/$1');
    $routes->delete('ideas/(:num)/vote','UpvotesController::delete/$1');
    $routes->post('(:num)/ideas/(:num)/feedback','IdeasFeedbackController::create/$1/$2');
    $routes->post('roadmap/kanban','RoadmapController::get_roadmap_wise_feedback');

    //Filter Routes
    $routes->get('feedback/roadmap/filter/(:any)','FeedbackController::roadmap_filter/$1');
    $routes->post('feedback/roadmap/filter/sorted_by','FeedbackController::roadmap_filter_sorted_by');
});