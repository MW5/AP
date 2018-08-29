<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Session;

class SupplierManagerController extends Controller
{
  function removeSuppliers(Request $request) {
      if(!empty($request->get('ch')) != 0) {
          foreach($request->get('ch') as $supl) {
              $supplier = Supplier::find($supl);
              $supplier->delete();
          }
          Session::flash('message', 'Pomyślnie usunięto dostawcę/dostawców');
          Session::flash('alert-class', 'alert-success');
      } else {
          Session::flash('message', 'Wybierz dostawców do usunięcia');
          Session::flash('alert-class', 'alert-warning');
      }

      return back();
  }

  function addSupplier(Request $request) {
      $this->validate($request,[
          'name'=>'required|min:1|max:50|unique:suppliers',
          'address'=>'required|min:1|max:150',
          'nip'=>'required|digits:10',
          'email'=>'required|min:6|max:40|unique:suppliers',
          'phone_number'=>'required|min:1|max:15',
          'details'=>'max:150'
      ]);
      $supplier = new Supplier();
      $supplier->name = $request->name;
      $supplier->address = $request->address;
      $supplier->nip = $request->nip;
      $supplier->email = $request->email;
      $supplier->phone_number = $request->phone_number;
      $supplier->details = $request->details;
      
      $supplier->save();
      Session::flash('message', 'Pomyślnie dodano dostawcę '.$supplier->name);
      Session::flash('alert-class', 'alert-success');
      return back();
  }

  function editSupplier(Request $request) {
    $supplier =  Supplier::find($request->id);

      $this->validate($request,[
          'name'=>'required|min:1|max:50|unique:suppliers,name,'.$supplier->id,
          'address'=>'required|min:1|max:150',
          'nip'=>'required|digits:10',
          'email'=>'required|min:6|max:40|unique:suppliers,email,'.$supplier->id,
          'phone_number'=>'required|min:1|max:15',
          'details'=>'max:150'
      ]);

      $supplier->name = $request->name;
      $supplier->address = $request->address;
      $supplier->nip = $request->nip;
      $supplier->phone_number = $request->phone_number;
      $supplier->email = $request->email;
      $supplier->details = $request->details;
      $supplier->update();

      Session::flash('message', 'Pomyślnie edytowano dostawcę '.$supplier->name);
      Session::flash('alert-class', 'alert-success');
      return back();
  }
}
