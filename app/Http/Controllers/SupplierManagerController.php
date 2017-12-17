<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Session;

class SupplierManagerController extends Controller
{
  function removeSuppliers(Request $request) {
      if(count($request->get('ch')) != 0) {
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
          'details'=>'max:150',
      ]);
      $supplier = new Supplier();
      $supplier->name = $request->name;
      $supplier->address = $request->address;
      $supplier->nip = $request->nip;
      $supplier->email = $request->email;
      $supplier->phone_number = $request->phone_number;
      if ($request->details != "") {
        $supplier->details = $request->details;
      } else {
        $supplier->details = "-";
      }
      $supplier->save();
      Session::flash('message', 'Pomyślnie dodano dostawcę '.$supplier->name);
      Session::flash('alert-class', 'alert-success');
      return back();
  }

  // function editUser(Request $request) {
  //   $user =  User::find($request->id);
  //
  //     $this->validate($request,[
  //         'name'=>'required|min:3|max:30|unique:users,name,'.$user->id,
  //         'email'=>'required|min:6|max:40|unique:users,email,'.$user->id,
  //         'account_type'=>'required',
  //         'password'=>'min:6|max:20'
  //     ]);
  //
  //     $user->name = $request->name;
  //     $user->email = $request->email;
  //     $user->password = bcrypt($request->password);
  //     $user->account_type = $request->account_type;
  //     $user->update();
  //
  //     Session::flash('message', 'Pomyślnie edytowano użytkownika '.$user->name);
  //     Session::flash('alert-class', 'alert-success');
  //     return back();
  // }
}
