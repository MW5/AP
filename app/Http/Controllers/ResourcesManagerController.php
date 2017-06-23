<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\WarehouseOperation;
use Session;

class ResourcesManagerController extends Controller
{
    function removeResources(Request $request) {
        if(count($request->get('ch')) != 0) {
            foreach($request->get('ch') as $res) {
                $resource = Resource::find($res);
                $resource->delete();
            }
            Session::flash('message', 'Pomyślnie usunięto zasob/zasoby'); 
            Session::flash('alert-class', 'alert-success'); 
        } else {
            Session::flash('message', 'Wybierz zasób do usunięcia'); 
            Session::flash('alert-class', 'alert-warning');
        }
        
        return back();
    }

    function addResource(Request $request) {
        $this->validate($request,[
            'name'=>'required|min:1|max:50|unique:resources',
            'critical_quantity'=>'required|min:0|numeric',
            'capacity'=>'max:20',
            'proportions'=>'max:20',
            'description'=>'required|min:5|max:400'
        ]);
        $resource = new Resource();
        $resource->name = $request->name;
        $resource->quantity = 0;
        $resource->critical_quantity = $request->critical_quantity;
        if($resource->capacity != "") {
            $resource->capacity = $request->capacity;
        } else {
            $resource->capacity = "";
        }
        if($resource->proportions != "") {
            $resource->proportions = $request->proportions;
        } else {
            $resource->proportions = "";
        }
        $resource->description = $request->description;
        $resource->save();
        Session::flash('message', 'Pomyślnie dodano '.$resource->name); 
        Session::flash('alert-class', 'alert-success'); 
        return back();
    }
    
    function acceptDelivery(Request $request) {
        $this->validate($request,[
            'supplier'=>'required|min:1|max:50',
        ]);
        
        $qtyArr = array();
        $arrCounter = 0;
        $arrBadVal = false;
        $arrZeroVals = true;
        
        foreach ($request->get('qty_field_accept') as $qty) {
                array_push($qtyArr, $qty);
        }
        
        foreach ($qtyArr as $qty) {
            if($qty<0 || !is_numeric($qty)) {
                $arrBadVal = true;
            }
            if($qty>0) {
                $arrZeroVals = false;
            }
        }

        if (!$arrBadVal && !$arrZeroVals) {
            foreach($request->get('res_id') as $res) {
                $resource = Resource::find($res);
                $resource->quantity = $resource->quantity+$qtyArr[$arrCounter];
                if($qtyArr[$arrCounter]>0) {
                    $resource->save();
//                    //logging
                    $warehouseOperation = new WarehouseOperation();
                    $warehouseOperation->resource_name = $resource->name;
                    $warehouseOperation->operation_type = "przyjęcie magazynowe";
                    $warehouseOperation->quantity = $qtyArr[$arrCounter];
                    $warehouseOperation->company_name = $request->supplier;
                    $warehouseOperation->user_name = $request->user_name;
                    $warehouseOperation->save();
                }
                $arrCounter++;
            }
            Session::flash('message', 'Pomyślnie przyjęto dostawę'); 
            Session::flash('alert-class', 'alert-success'); 
        } elseif ($arrZeroVals) {
            Session::flash('message', 'Nie określono żadnej wartości dodatniej'); 
            Session::flash('alert-class', 'alert-warning'); 
        }else {
            Session::flash('message', 'Błędna wartość'); 
            Session::flash('alert-class', 'alert-warning'); 
        }
        return back();
    }
    
    function warehouseRelease(Request $request) {
        $qtyArr = array();
        $arrCounter = 0;
        $arrBadVal = false;
        $arrZeroVals = true;
        $notEnough = false;
        
        foreach ($request->get('qty_field_release') as $qty) {
                array_push($qtyArr, $qty);
        }
        
        foreach ($qtyArr as $qty) {
            if($qty<0) {
                $arrBadVal = true;
            }
            if($qty>0) {
                $arrZeroVals = false;
            }
        }
        foreach($request->get('res_id') as $res) {
                $resource = Resource::find($res);
                if ($resource->quantity < $qtyArr[$arrCounter]) {
                    $notEnough = true;
                }
                $arrCounter++;
            }
        $arrCounter = 0;

        if (!$arrBadVal && !$arrZeroVals && !$notEnough) {
            foreach($request->get('res_id') as $res) {
                $resource = Resource::find($res);
                $resource->quantity = $resource->quantity-$qtyArr[$arrCounter];
                if($qtyArr[$arrCounter]>0) {
                    $resource->save();
//                    //logging
                    $warehouseOperation = new WarehouseOperation();
                    $warehouseOperation->resource_name = $resource->name;
                    $warehouseOperation->operation_type = "wydanie magazynowe";
                    $warehouseOperation->quantity = $qtyArr[$arrCounter];
                    $warehouseOperation->company_name = "";
                    $warehouseOperation->user_name = $request->user_name;
                    $warehouseOperation->save();
                }
                $arrCounter++;
            }
            Session::flash('message', 'Pomyślnie wydano zasoby'); 
            Session::flash('alert-class', 'alert-success'); 
        } elseif ($notEnough) {
            Session::flash('message', 'Wydawana ilość przekracza obecny stan magazynowy'); 
            Session::flash('alert-class', 'alert-warning'); 
        } elseif ($arrZeroVals) {
            Session::flash('message', 'Nie określono żadnej wartości dodatniej'); 
            Session::flash('alert-class', 'alert-warning'); 
        }else {
            Session::flash('message', 'Nie można wydać wartości ujemnej'); 
            Session::flash('alert-class', 'alert-warning'); 
        }
        return back();
    }
    
}
