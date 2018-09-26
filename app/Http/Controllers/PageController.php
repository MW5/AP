<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Resource;
use App\WarehouseOperation;
use App\CarTask;
use App\User;
use App\Supplier;

class PageController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $resources = DB::table('resources')->orderBy('created_at', 'desc')->get();
        $suppliers = DB::table('suppliers')->get();
        return view('resourceManager', compact('resources', 'suppliers'));
    }
    public function supplierManager() {
        $suppliers = DB::table('suppliers')->orderBy('created_at', 'desc')->get();
        return view('supplierManager', compact('suppliers'));
    }
    public function resourceDetails($id) {
        $resource = Resource::find($id);
        $warehouseOperations = WarehouseOperation::where([
            ['created_at', '>=', date("Y-m-d", strtotime('-30 days'))],
            ['resource_name', $resource->name]
          ])->get();
        return view('resourceDetails', compact('warehouseOperations', 'resource'));
    }
    public function warehouseOperations() {
        $warehouseOperations = DB::table('warehouse_operations')->orderBy('created_at', 'desc')->get();
        $users = DB::table('users')->get();
        $resources = DB::table('resources')->get();
        $suppliers = DB::table('suppliers')->get();
        return view('warehouseOperations', compact('warehouseOperations', 'users', 'resources', 'suppliers'));
    }

    public function carManager() {
      $cars = DB::table('cars')->orderBy('created_at', 'desc')->get();
      return view('carManager', compact('cars'));
    }
    public function carTaskManager() {
      $carTasks = DB::table('car_tasks')->orderBy('created_at', 'desc')->get();
      $cars = DB::table('cars')->get();
      $users = DB::table('users')->get();
      return view('carTaskManager', compact('carTasks', 'cars', 'users'));
    }

    public function userManager() {
        $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        return view('userManager', compact('users'));
    }
}
