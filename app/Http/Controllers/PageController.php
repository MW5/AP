<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Resource;
use App\WarehouseOperation;

class PageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $resources = DB::table('resources')->get();
        $suppliers = DB::table('suppliers')->get();
        return view('resourcesManager', compact('resources', 'suppliers'));
    }
    public function supplierManager() {
        $suppliers = DB::table('suppliers')->get();
        return view('supplierManager', compact('suppliers'));
    }
    public function resourceDetails($id) {
        $warehouseOperations = WarehouseOperation::where([
            ['created_at', '>=', date("Y-m-d", strtotime('-30 days'))],
            ['resource_id', $id]
          ])->get();
        $resource = Resource::find($id);
        return view('resourceDetails', compact('warehouseOperations', 'resource'));
    }
    public function warehouseOperations() {
        $warehouseOperations = DB::table('warehouse_operations')->get();
        $users = DB::table('users')->get();
        $resources = DB::table('resources')->get();
        $suppliers = DB::table('suppliers')->get();
        return view('warehouseOperations', compact('warehouseOperations', 'users', 'resources', 'suppliers'));
    }

    public function carManager() {
      $cars = DB::table('cars')->get();
      return view('carManager', compact('cars'));
    }
    public function carTaskManager() {
      $carTasks = DB::table('car_tasks')->get();
      $cars = DB::table('cars')->get();
      $users = DB::table('users')->get();
      return view('carTaskManager', compact('carTasks', 'cars', 'users'));
    }

    public function userManager() {
        $users = DB::table('users')->get();
        return view('userManager', compact('users'));
    }

}
