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


Route::get('/resourceManager', 'PageController@index');
Route::post('/resourceManager/addResource', 'ResourceManagerController@addResource');
Route::post('/resourceManager/editResource/', 'ResourceManagerController@editResource');
Route::post('/resourceManager/removeResources', 'ResourceManagerController@removeResources');
Route::post('/resourceManager/acceptDelivery', 'ResourceManagerController@acceptDelivery');
Route::post('/resourceManager/warehouseRelease', 'ResourceManagerController@warehouseRelease');
Route::get('/resourceManager/warehouseOperations', 'PageController@warehouseOperations');
Route::get('/resourceManager/{resource}', 'PageController@resourceDetails');

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

Route::get('/carTaskManager', 'PageController@carTaskManager');
Route::post('/carTaskManager/addCarTask', 'CarTaskManagerController@addCarTask');
Route::post('/carTaskManager/removeCarTasks', 'CarTaskManagerController@removeCarTasks');
Route::post('/carTaskManager/editCarTask', 'CarTaskManagerController@editCarTask');
