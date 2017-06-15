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
        }
        Session::flash('message', 'Pomyślnie usunięto użytkownika/użytkowników'); 
        Session::flash('alert-class', 'alert-success'); 
        return back();
    }
}
