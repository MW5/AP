<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Resource;

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
        return view('resourcesManager', compact('resources'));
    }
    public function supplierManager() {
        $suppliers = DB::table('suppliers')->get();
        return view('supplierManager', compact('suppliers'));
    }
    public function resourceDetails($id) {
        $warehouseOperations = DB::table('warehouse_operations')->get();
        $resource = Resource::find($id);
        return view('resourceDetails', compact('warehouseOperations', 'resource'));
    }
    public function warehouseOperations() {
        $warehouseOperations = DB::table('warehouse_operations')->get();
        return view('warehouseOperations', compact('warehouseOperations'));
    }

    public function tireManager() {
        return view('tireManager');
    }

    public function userManager() {
        $users = DB::table('users')->get();
        return view('userManager', compact('users'));
    }

}
