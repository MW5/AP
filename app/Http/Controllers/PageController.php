<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
