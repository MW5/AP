<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
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
            'capacity'=>'max:20',
            'proportions'=>'max:20',
            'description'=>'max:400'
        ]);
        $resource = new Resource();
        $resource->name = $request->name;
        $resource->quantity = 0;
        $resource->capacity = $request->capacity;
        $resource->proportions = $request->proportions;
        $resource->description = $request->description;
        $resource->save();
        Session::flash('message', 'Pomyślnie dodano '.$resource->name); 
        Session::flash('alert-class', 'alert-success'); 
        return back();
    }
    
    function acceptDelivery(Request $request) {
        
        $qtyArr = array();
        $arrCounter = 0;
        $arrBadVal = false;
        $arrZeroVals = true;
        
        foreach ($request->get('qty_field') as $qty) {
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

        if (!$arrBadVal && !$arrZeroVals) {
            foreach($request->get('res_id') as $res) {
                $resource = Resource::find($res);
                $resource->quantity = $resource->quantity+$qtyArr[$arrCounter];
                $resource->save();
                $arrCounter++;
            }
            Session::flash('message', 'Pomyślnie przyjęto dostawę'); 
            Session::flash('alert-class', 'alert-success'); 
        } elseif ($arrZeroVals) {
            Session::flash('message', 'Nie określono żadnej wartości dodatniej'); 
            Session::flash('alert-class', 'alert-warning'); 
        }else {
            Session::flash('message', 'Nie można przyjąć wartości ujemnej'); 
            Session::flash('alert-class', 'alert-warning'); 
        }
        return back();
    }
}
