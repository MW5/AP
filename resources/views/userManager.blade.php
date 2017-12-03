@extends('layouts.app')

@section('title')
    <title> Moduł użytkowników </title>
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

@section('nav_choices')
    <li><a href="/resourcesManager">Moduł zasobów magazynowych</a></li>
    <li><a href="/tireManager">Moduł opon</a></li>
    <li class='curr_module'><a href="/userManager">Moduł użytkowników</a></li>
@endsection

@section('content')
    <div class='container ap_table_container'>
        @if (Auth::user()->account_type == "administrator")
            <div class='ap_action_bar'>
                <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_user_modal">Dodaj użytkownika</button>
                <button form="remove_users_form" type="submit" class="btn_styled">Usuń zaznaczonych użytkowników</button>
            </div>
        @endif
        <table class='ap_table'>
            <form id="remove_users_form" method="POST" action="/userManager/removeUsers">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <th></th>
                    <th>Użytkownik</th>
                    <th>Adres email</th>
                    <th>Typ konta</th>
                </tr>
                <?php $counter=0?>
                @foreach($users as $user)
                    <?php
                        if($counter%2==0) {
                            ?>
                        <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#edit_user_modal"
                         data-user-id="{{$user->id}}"
                         data-user-name="{{$user->name}}"
                         data-user-email="{{$user->email}}"
                         data-user-account-type="{{$user->account_type}}">
                            <?php
                        } else {
                            ?>
                            <tr class ='odd clickable_row_no_href' data-toggle="modal" data-target="#edit_user_modal"
                            data-user-id="{{$user->id}}"
                            data-user-name="{{$user->name}}"
                            data-user-email="{{$user->email}}"
                            data-user-account-type="{{$user->account_type}}">
                            <?php
                        }?>

                        <td>
                        @if ($user->name != Auth::user()->name && Auth::user()->account_type == "administrator")
                            <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$user->id}}">
                        @endif
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->account_type}}
                        </td>
                    </tr>
                    <?php $counter+=1;?>
                @endforeach
                <?php $counter=0?>
            </form>
        </table>
    </div>

    <!--add user modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add_user_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
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
                            <input id="email" type="text" class="form-control" name="email" placeholder="6-40 znaków"
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="account_type">Typ konta:</label></br>
                            <input id="radio_user" type="radio"  name="account_type" value='użytkownik'><span class='ap_radio_label'>Użytkownika</span></br>
                            <input id="radio_admin" type="radio"  name="account_type" value='administrator'><span class='ap_radio_label'>Administracyjne</span>
                        </div>

                        <div class="form-group">
                            <label for="password">Hasło:</label>
                            <input id ="password" type="password" class="form-control" name="password" placeholder="6-20 znaków">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="add_user_form" type="submit" class="btn btn_styled btn_safe">Dodaj użytkownika</button>
                </div>
            </div>
        </div>
    </div>

<!--    edit user modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit_user_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edytuj użytkownika</h4>
                </div>
                <div class="modal-body">
                    <form id="edit_user_form" method="POST" action="/userManager/editUser">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input id="user_id" type="hidden" name="user_id">

                        <div class="form-group">
                            <label for="edit_name">Nazwa użytkownika:</label>
                            <input id="edit_name" type="text" class="form-control" name="edit_name" placeholder="3-30 znaków"
                                value="{{ old('edit_name') }}">
                        </div>

                        <div class="form-group">
                            <label for="edit_email">Adres email:</label>
                            <input id="edit_email" type="text" class="form-control" name="edit_email" placeholder="6-40 znaków"
                                value="{{ old('edit_email') }}">
                        </div>
                        <div class="form-group">
                            <label for="edit_account_type">Typ konta:</label></br>
                            <input id="edit_radio_user" type="radio"  name="edit_account_type" value='użytkownik'><span class='ap_radio_label'>Użytkownika</span></br>
                            <input id="edit_radio_admin" type="radio"  name="edit_account_type" value='administrator'><span class='ap_radio_label'>Administracyjne</span>
                        </div>

                        <div class="form-group">
                            <input id="edit_pass_change_confirmation" type="checkbox"><label for="edit_password">Zmień hasło:</label>
                            <input id ="edit_password" type="password" class="form-control" name="edit_password" placeholder="6-20 znaków">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="edit_user_form" type="submit" class="btn btn_styled btn_safe">Edytuj użytkownika</button>
                </div>
            </div>
        </div>
    </div>
@endsection
