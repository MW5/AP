<?php

use Illuminate\Http\Request;
use App\User;
use App\Resource;
use App\WarehouseOperation;
use App\CarTask;
use App\Supplier;
use App\Car;
use App\CarStatusSetterService;

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
            $warehouseOperation->operation_type = $warehouseOperation->operationRelease;
            $warehouseOperation->old_val = $resource->quantity+1;
            $warehouseOperation->quantity_change = -1;
            $warehouseOperation->new_val = $resource->quantity;
            $warehouseOperation->user_name = $request->userName;
            $warehouseOperation->save();

            return "true";
        } else {
            return "false";
        }
    }
});
    
Route::get('/getFiltered', function(Request $request) {
    
    $pattern = htmlspecialchars($request->pattern);

    switch ($request->module) {
        case "resources":
            $query = Resource::query();
            $columns = ['name','quantity','critical_quantity',
                'capacity','proportions','description'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $pattern . '%');
            }
            return $query->select('name','quantity','critical_quantity',
                'capacity','proportions','description')->get();  
            break;
        case "Manager/s":
            $query = WarehouseOperation::query();
            $columns = ['resource_name','operation_type','old_val',
                'quantity_change','new_val','supplier_name','user_name', 'created_at'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $pattern . '%');
            }
            return $query->select('resource_name','operation_type','old_val',
                'quantity_change','new_val','supplier_name','user_name', 'created_at')->get();  
            break;
        case "suppliers":
            $query = Supplier::query();
            $columns = ['name','address','nip',
                'phone_number','email','details'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $pattern . '%');
            }
            return $query->select('name','address','nip',
                'phone_number','email','details')->get();  
            break;
        case "cars":
            $query = Car::query();
            $columns = ['reg_num','make','model',
                'status'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $pattern . '%');
            }
            return $query->select('reg_num','make','model',
                'status')->get();  
            break;
        case "car_tasks": 
            $query = CarTask::query();
            $columns = ['car_reg_num', 'task_type', 'status', 'begin_time',
                'begin_user_name', 'end_time', 'end_user_name'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $pattern . '%');
            }
            return $query->select('car_reg_num', 'task_type', 'status', 'begin_time',
                'begin_user_name', 'end_time', 'end_user_name')->get();  
            break;
        case "users":
            $query = User::query();
            $columns = ['name', 'email', 'account_type'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $pattern . '%');
            }
            return $query->select('name', 'email', 'account_type')->get();  
            break;
    }
});

Route::post('/getConditionTasks', function(Request $request) {
    if ($request->token == "token") {
        $carTasks = DB::table('car_tasks')->where('task_type', 'weryfikacja stanu')->where('status', '!=', 'zakończone')->get();
        return $carTasks;
    } else {
        return "false";
    }
});
Route::post('/getPolishingTasks', function(Request $request) {
    if ($request->token == "token") {
    $carTasks = DB::table('car_tasks')->where('task_type', 'polerowanie')->where('status', '!=', 'zakończone')->get();
        return $carTasks;
    } else {
        return "false";
    }
});
Route::post('/getAutodetailingTasks', function(Request $request) {
    if ($request->token == "token") {
        $carTasks = DB::table('car_tasks')->where('task_type', 'autodetailing')->where('status', '!=', 'zakończone')->get();
        return $carTasks;
    } else {
        return "false";
    }
});

Route::post('/serveTask', function(Request $request) {
    $carTask = CarTask::where('car_reg_num',$request->regNum)->where('task_type', $request->taskType)->first();

    $userName = $request->userName;
    
    $operationType = $request->operationType;
    $currentDate = date('Y-m-d H:i:s', time());
    
    if($operationType == "begin") {
        $carTask->status = "realizowane";
        $carTask->begin_time = $currentDate;
        $carTask->begin_user_name = $userName;
    } else {
        $carTask->status = "zakończone";
        $carTask->end_time = $currentDate;
        $carTask->end_user_name = $userName;
    }
    
    if ($carTask->update()) {
        CarStatusSetterService::setCarStatus($carTask);
        return "true";
    }
    return "false";
});
