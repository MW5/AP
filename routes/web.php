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
//
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'PageController@index');
Route::get('/home', 'PageController@index');
Route::get('/resourcesManager', 'PageController@index');

Route::get('/userManager', 'PageController@userManager');
Route::post('/userManager/removeUsers', 'userManagerController@removeUsers');
Route::post('/userManager/addUser', 'userManagerController@addUser');

Route::get('/tireManager', 'PageController@tireManager');

