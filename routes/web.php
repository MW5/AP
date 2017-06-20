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

Auth::routes();

Route::get('/', 'PageController@index');
Route::get('/home', 'PageController@index');


Route::get('/resourcesManager', 'PageController@index');
Route::post('/resourcesManager/addResource', 'ResourcesManagerController@addResource');
Route::post('/resourcesManager/removeResources', 'ResourcesManagerController@removeResources');
Route::post('/resourcesManager/acceptDelivery', 'ResourcesManagerController@acceptDelivery');
Route::post('/resourcesManager/warehouseRelease', 'ResourcesManagerController@warehouseRelease');
Route::get('/resourcesManager/warehouseOperations', 'PageController@warehouseOperations');

//Route::get(report route);

Route::get('/userManager', 'PageController@userManager');
Route::post('/userManager/addUser', 'UserManagerController@addUser');
Route::post('/userManager/removeUsers', 'UserManagerController@removeUsers');

Route::get('/tireManager', 'PageController@tireManager');

