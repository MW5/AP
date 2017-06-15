@extends('layouts.app')

@section('title')
    <title> Moduł użytkowników </title>
@endsection

@section('logged_user')
    <div id="user_greet">
        Witaj {{Auth::user()->name}}!
    </div>
@endsection

@section('nav_choices')
    <li><a href="/resourcesManager">Moduł środków nietrwałych</a></li>
    <li><a href="/tireManager">Moduł opon</a></li>
    <li class='curr_module'><a href="/userManager">Moduł użytkowników</a></li>
@endsection