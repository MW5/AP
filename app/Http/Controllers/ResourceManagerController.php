<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\WarehouseOperation;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Rules\NameExistsInWarehouse;
use App\Rules\CodeExistsInWarehouse;
use App\Rules\NameExistsInWarehouseEditFix;
use App\Rules\CodeExistsInWarehouseEditFix;
use Mail;

class ResourceManagerController extends Controller
{
    function removeResources(Request $request) {
        if(!empty($request->get('ch')) != 0) {
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
        $resource = new Resource();
        $this->validate($request,[
            'code' => new CodeExistsInWarehouse,
            'name' => new NameExistsInWarehouse,
            'critical_quantity'=>'required|min:0|max:1000|numeric',
            'capacity'=>'max:20',
            'proportions'=>'max:20',
            'description'=>'required|min:5|max:400'
        ]);
        $resource = new Resource();
        $resource->code = $request->code;
        $resource->name = $request->name;
        $resource->quantity = 0;
        $resource->critical_quantity = $request->critical_quantity;
        $resource->capacity = $request->capacity;
        $resource->proportions = $request->proportions;
        $resource->description = $request->description;
        $resource->warehouse = Auth::user()->warehouse;
        $resource->save();

        Session::flash('message', 'Pomyślnie dodano '.$resource->name);
        Session::flash('alert-class', 'alert-success');
        return back();
    }

    function editResource(Request $request) {
      $resource =  Resource::find($request->id);

        $this->validate($request,[
          'code'=> new CodeExistsInWarehouseEditFix($request->code, $request->id),
          'name'=> new NameExistsInWarehouseEditFix($request->name, $request->id),
          'critical_quantity'=>'required|min:0|max:1000|numeric',
          'capacity'=>'max:20',
          'proportions'=>'max:20',
          'description'=>'required|min:5|max:400'
        ]);

        $resource->code = $request->code;
        $resource->name = $request->name;
        $resource->critical_quantity = $request->critical_quantity;
        $resource->capacity = $request->capacity;
        $resource->proportions = $request->proportions;
        $resource->description = $request->description;
        $resource->update();

        Session::flash('message', 'Pomyślnie edytowano zasób '.$resource->name);
        Session::flash('alert-class', 'alert-success');
        return back();
    }

    function acceptDelivery(Request $request) {
        $this->validate($request,[
            'qty_field_accept'=>'required'
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
                    //logging
                    $warehouseOperation = new WarehouseOperation();
                    $warehouseOperation->resource_name = $resource->name;
                    $warehouseOperation->operation_type = $warehouseOperation->operationAccept;
                    $warehouseOperation->old_val = $resource->quantity-$qtyArr[$arrCounter];
                    $warehouseOperation->quantity_change = $qtyArr[$arrCounter];
                    $warehouseOperation->new_val = $resource->quantity;
                    $warehouseOperation->supplier_name = $request->supplier_name;
                    $warehouseOperation->user_name = $request->user_name;
                    $warehouseOperation->warehouse = Auth::user()->warehouse;
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
        $this->validate($request,[
            'qty_field_release'=>'required'
        ]);
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
                    //logging
                    $warehouseOperation = new WarehouseOperation();
                    $warehouseOperation->resource_name = $resource->name;
                    $warehouseOperation->operation_type = $warehouseOperation->operationRelease;
                    $warehouseOperation->old_val = $resource->quantity+$qtyArr[$arrCounter];
                    $warehouseOperation->quantity_change = $qtyArr[$arrCounter];
                    $warehouseOperation->new_val = $resource->quantity;
                    $warehouseOperation->user_name = $request->user_name;
                    $warehouseOperation->warehouse = Auth::user()->warehouse;
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

    function prepareOrder(Request $request) {
        $order = "";
        $this->validate($request,[
            'qty_field_order'=>'required'
        ]);
        $qtyArr = array();
        $arrCounter = 0;
        $arrBadVal = false;
        $arrZeroVals = true;

        foreach ($request->get('qty_field_order') as $qty) {
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
                $arrCounter++;
            }
        $arrCounter = 0;

        if (!$arrBadVal && !$arrZeroVals) {
            foreach($request->get('res_id') as $res) {
                $resource = Resource::find($res);
                $resource->quantity = $resource->quantity+$qtyArr[$arrCounter];
                if($qtyArr[$arrCounter]>0) {
                    $order = $order . "<li>" . $resource->code . " / " . $resource->name . " / " .
                    $resource->quantity . "</li>";
                }
             $arrCounter++;
            }
        }

        Mail::send('emails.mailOrder',
            ['resourcesOrdered'=>$order],
            function ($message) use ($request) {
                $message->from('dsu@dsu.pl', 'System generowania zamówień DSU');
                $message->to($request->order_email);
                $message->subject('Zamówienie DSU');
            }
        );

        Session::flash('message', 'Zamówienie zostało wysłane');
        Session::flash('alert-class', 'alert-success');
      }

}
