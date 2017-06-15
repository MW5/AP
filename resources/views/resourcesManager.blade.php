@extends('layouts.app')

@section('title')
    <title> Aplikacja wspomagająca zarządzanie DSU AP </title>
@endsection

@section('logged_user')
    <div id="user_greet">
        Witaj {{Auth::user()->name}}!
    </div>
@endsection

@section('nav_choices')
    <li class='curr_module'><a href="/resourcesManager">Moduł środków nietrwałych</a></li>
    <li><a href="/tireManager">Moduł opon</a></li>
    <li><a href="/userManager">Moduł użytkowników</a></li>
@endsection
