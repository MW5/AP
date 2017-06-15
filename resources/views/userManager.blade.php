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
    <div class='container user_list_container'>
        <div class='action_bar'>
            <button type="button" class="btn btn-primary btn_green" data-toggle="modal" data-target="#add_user_modal">Dodaj użytkownika</button>
            <button form="remove_users_form" type="submit" class="btn btn-primary btn_red">Usuń zaznaczonych użytkowników</button>
        </div>
        <ul>
            <form id="remove_users_form" method="POST" action="/userManager/removeUsers">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($users as $user)
                <li>
                    @if ($user->name != Auth::user()->name)
                        <input type="checkbox" name="ch[]" value="{{$user->id}}">
                    @endif
                    {{$user->name}}
                    {{$user->email}}
                </li>
                @endforeach
                
            </form>
        </ul>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="add_user_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content ap_modal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dodaj użytkownika</h4>
                </div>
                <div class="modal-body">
                    <form id="add_user_form" method="POST" action="/userManager/addUser">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="form-group">
                            <label for="name">Nazwa użytkownika:</label>
                            <input id="name" type="text" class="form-control" name="name" placeholder="3-30 znaków"
                                value="{{ old('name') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Adres email:</label>
                            <input id="email" type="text" class="form-control" name="email" placeholder="6-200 znaków"
                                value="{{ old('email') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Hasło:</label>
                            <input id ="password" type="password" class="form-control" name="password" placeholder="3-20 znaków">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn_red" data-dismiss="modal">Zamknij</button>
                    <button form="add_user_form" type="submit" class="btn btn-primary btn_green">Dodaj użytkownika</button>
                </div>
            </div>
        </div>
    </div>
@endsection