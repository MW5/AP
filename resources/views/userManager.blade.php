@extends('layouts.app')

@section('title')
    <title> Moduł użytkowników </title>
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
    <li><a href="/tireManager">Moduł opon</a></li>
    <li class='curr_module'><a href="/userManager">Moduł użytkowników</a></li>
@endsection

@section('content')
    <div class='container-fluid user_list_container'>
        <div class='action_bar'>
            <button href="/addUsr" type="submit" class="btn btn-primary btn_green">Dodaj użytkownika</button>
            <button form="remove_users" type="submit" class="btn btn-primary btn_red">Usuń zaznaczonych użytkowników</button>
        </div>
        <ul>
            <form id='remove_users' method='POST' action='/userManager/removeUsers'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($users as $user)
                <li>
                    <input type="checkbox" name="ch[]" value="{{$user->id}}">
                    {{$user->name}}
                    {{$user->email}}
                </li>
                @endforeach
                
            <form>
        </ul>
    </div>
@endsection