<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['namespace' => 'Api', 'middleware' => 'ajax_calls'], function() {

	Route::get('homePanel', [
		'uses' => 'PanelController@homePanel',
		'as' => 'home.panel'
	]);

	Route::get('settings', [
		'uses' => 'PanelController@settings',
		'as' => 'settings'
	]);

	Route::post('settings/update', [
		'uses' => 'PanelController@settingsUpdate',
		'as' => 'settings.update'
	]);

	Route::get('projects', [
		'uses' => 'PanelController@projects',
		'as' => 'projects'
	]);

	Route::post('project/store', [
		'uses' => 'PanelController@projectStore',
		'as' => 'project.store'
	]);

	Route::get('project/{id}', [
		'uses' => 'PanelController@project',
		'as' => 'project'
	]);

	Route::post('project/update/{id}', [
		'uses' => 'PanelController@projectUpdate',
		'as' => 'project.update'
	]);

	Route::get('project/delete/{id}', [
		'uses' => 'PanelController@projectDelete',
		'as' => 'project.delete'
	]);

	Route::get('get', [
		'uses' => 'PanelController@get',
		'as' => 'get'
	]);

	Route::post('postSave', [
		'uses' => 'PanelController@postSave',
		'as' => 'post.save'
	]);

	Route::get('post', [
		'uses' => 'PanelController@post',
		'as' => 'post'
	]);
});
