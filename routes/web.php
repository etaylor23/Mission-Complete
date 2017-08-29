<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\App;


Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
    Route::put('dashboard/maintenance-complete/{objective_slug}', 'DashboardController@maintenanceComplete');

    Route::get('dashboard', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);
    Route::get('chat', 'ChatsController@index');

    Route::get('follow/search', 'FollowController@searchUser');
    Route::get('follow/following', 'FollowController@showFollowing');
    Route::get('follow/followers', 'FollowController@showFollowers');
    Route::resource('follow', 'FollowController');

    Route::resource('api/campaign', 'CampaignsController');

    Route::get('campaign/list', 'CampaignsController@listCampaigns');
    Route::resource('campaign', 'CampaignsController');


    Route::resource('api/campaign.mission', 'MissionsContoller');
    Route::resource('campaign.mission', 'MissionsContoller');

    Route::resource('campaign.mission.objective', 'ObjectivesController');

    Route::get('messages', 'ChatsController@fetchMessages');
    Route::post('messages', 'ChatsController@sendMessage');

    Route::post('campaign/create', 'CampaignsController@store');
    Route::post('mission/create', 'MissionsContoller@store');
    Route::post('objective/create', 'ObjectivesController@store');
    Route::get('campaign/{slug}', 'CampaignsController@showCampaign');

    Route::get('/home', 'HomeController@index');

    Route::post('/tutorials', 'DashboardController@tutorials');



});

Auth::routes();
