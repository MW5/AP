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
            'name'=>'required|min:1|max:50',
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
}
