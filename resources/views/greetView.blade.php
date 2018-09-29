@extends('layouts.app')

@section('title')
    <title> Ekran powitalny </title>
@endsection

@section('logged_user')
    <div id="user_greet">
        Zalogowany: {{Auth::user()->name}}
    </div>
@endsection

@section('logout_btn')
    <ul class="nav navbar-nav navbar-right">
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

@section('content')
<div class='greet_view'>
    <div class='greet_view_text_container'>
        <p>Aplikacja wspomagająca zarządzanie Działem Samochodów Używanych</p>
    </div>
</div>
@endsection
