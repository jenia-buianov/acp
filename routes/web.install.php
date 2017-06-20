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

Route::get('/', 'InstallController@preload');
Route::get('{page}', function (){
    return redirect('/');
});
Route::post('/', 'InstallController@start');
Route::post('/setup', 'InstallController@setup');
Route::post('/verify', 'InstallController@verify');
Route::post('/findRows', 'InstallController@rows');
Route::post('install/finish', 'InstallController@lastStep');

