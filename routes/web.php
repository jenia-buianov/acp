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

//Auth::routes();
Route::get('login', 'LoginController@showLoginForm');
Route::post('login','LoginController@verify');

Route::group(['middleware' => 'custom_auth'], function () {
    Route::get('/', 'DashboardController@preload');
    Route::post('/', 'DashboardController@index');
    Route::get('logout','LoginController@logout');
    Route::post('settings/{name}', 'SettingsController@allSettings');
    Route::post('module/{name}', 'ModulesController@openModule');
    Route::get('module/{name}', 'DashboardController@preload');
    Route::post('module/{name}/{action}', 'ModulesController@startAction');
});