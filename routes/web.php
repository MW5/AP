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
//edit resource should also be here
Route::post('/resourcesManager/removeResources', 'ResourcesManagerController@removeResources');
Route::post('/resourcesManager/acceptDelivery', 'ResourcesManagerController@acceptDelivery');
Route::post('/resourcesManager/warehouseRelease', 'ResourcesManagerController@warehouseRelease');
Route::get('/resourcesManager/warehouseOperations', 'PageController@warehouseOperations');
Route::get('/resourcesManager/{resource}', 'PageController@resourceDetails');

//Route::get(report route);

Route::get('/userManager', 'PageController@userManager');
Route::post('/userManager/addUser', 'UserManagerController@addUser');
Route::post('/userManager/removeUsers', 'UserManagerController@removeUsers');
Route::post('/userManager/editUser/', 'UserManagerController@editUser');

Route::get('/supplierManager', 'PageController@supplierManager');
Route::post('/supplierManager/addSupplier', 'SupplierManagerController@addSupplier');
Route::post('/supplierManager/removeSuppliers', 'SupplierManagerController@removeSuppliers');
Route::post('/supplierManager/editSupplier/', 'SupplierManagerController@editSupplier');

Route::get('/carManager', 'PageController@carManager');
Route::post('/carManager/addCar', 'CarManagerController@addCar');
Route::post('/carManager/removeCars', 'CarManagerController@removeCars');
Route::post('/carManager/editCar/', 'CarManagerController@editCar');
