<?php

use Illuminate\Http\Request;
use App\User;
use App\Resource;
use App\WarehouseOperation;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/credentialsApi', function(Request $request) {
    $name = $request->name;
    $password = $request->password;

    if (Auth::attempt(['name' => $name, 'password' => $password])) {
        echo "true";
    } else {
        echo "false";
    }
});

Route::post('/getResources', function(Request $request) {
    if ($request->token == "token") {
        $resources = DB::table('resources')->get();
        echo $resources;
    } else {
        echo "false";
    }
});

Route::post('/releaseResource', function(Request $request) {
    if ($request->token == "token") {
        $resource = Resource::where('name', '=', $request->name)->first();
        if ($resource->quantity > 0) {
            $resource->quantity = $resource->quantity-1;
            $resource->save();

            $warehouseOperation = new WarehouseOperation();
            $warehouseOperation->resource_name = $resource->name;
            $warehouseOperation->operation_type = "wydanie magazynowe";
            $warehouseOperation->quantity = 1;
            $warehouseOperation->company_name = "";
            $warehouseOperation->user_name = $request->userName;
            $warehouseOperation->save();

            echo "true";
        } else {
            echo "false";
        }
    }
});
