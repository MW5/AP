@extends('layouts.app')

@section('title')
    <title> Moduł opon </title>
@endsection

@section('logged_user')
    <div id="user_greet">
        Witaj {{Auth::user()->name}}!
    </div>
@endsection

@section('logout_btn')
    <ul class="nav navbar-nav pull-right">
        <li><a href="{{ url('/logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Wyloguj
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
@endsection

@section('nav_choices')
    <li><a href="/resourcesManager">Moduł środków nietrwałych</a></li>
    <li class='curr_module'><a href="/tireManager">Moduł opon</a></li>
    <li><a href="/userManager">Moduł użytkowników</a></li>
@endsection