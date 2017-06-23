<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;

class userManagerController extends Controller
{
    function removeUsers(Request $request) {
        if(count($request->get('ch')) != 0) {
            foreach($request->get('ch') as $usr) {
                $user = User::find($usr);
                $user->delete();
            }
            Session::flash('message', 'Pomyślnie usunięto użytkownika/użytkowników'); 
            Session::flash('alert-class', 'alert-success'); 
        } else {
            Session::flash('message', 'Wybierz użytkowników do usunięcia'); 
            Session::flash('alert-class', 'alert-warning');
        }
        
        return back();
    }

    function addUser(Request $request) {
        $this->validate($request,[
            'name'=>'required|min:3|max:30',
            'email'=>'required|min:6|max:40|unique:users',
            'account_type'=>'required',
            'password'=>'required|min:6|max:20'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->account_type = $request->account_type; //added
        $user->save();
        Session::flash('message', 'Pomyślnie dodano użytkownika '.$user->name); 
        Session::flash('alert-class', 'alert-success'); 
        return back();
    }
}
