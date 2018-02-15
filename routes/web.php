<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	if(!Auth::check()){
		return view('auth.login');
	}
    return redirect()->route('home');
});

Route::get('/home', function () {
    return redirect('/');
});

Auth::routes();

Route::group(['prefix' => 'panel', 'namespace' => 'Panel'], function(){

	Route::get('/', 'PanelController@index')->name('home');

});

