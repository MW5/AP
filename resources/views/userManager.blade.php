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

@section('content')
    <div class='container ap_table_container'>
        <div id="tableUsers" class="table-list-container">
            <div class='ap_action_bar'>
                @if (Auth::user()->account_type == Auth::user()->manager)
                <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_user_modal">Dodaj użytkownika</button>
                <button form="remove_users_form" type="submit" class="btn_styled">Usuń zaznaczonych użytkowników</button>
                @endif
                <button type="button" class="btn_styled export_list_btn">Eksportuj</button>
                <input class="search" placeholder="Filtruj">
            </div>
            <form id="remove_users_form" method="POST" action="/userManager/removeUsers">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table-list table ap_table" data-currentpage="1" >
                  <thead>
                        <th></th>
                        <th><button type="button" class="sort" data-sort="jSortName">Nazwa</button></th>
                        <th><button type="button" class="sort" data-sort="jSortEmail">Adres email</button></th>
                        <th><button type="button" class="sort" data-sort="jSortAccountType">Typ konta</button></th>
                        <th><button type="button" class="sort" data-sort="jSortWarehouse">Magazyn</button></th>
                  </thead>
                    <tbody class="list">
                        <?php $counter=0?>
                        @foreach($users as $user)
                            <?php
                                if($counter%2==0) {
                                    ?>
                        @if (Auth::user()->account_type == Auth::user()->manager)
                                <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#edit_user_modal"
                        @else
                                <tr class='even not-active' data-toggle="modal" data-target="#edit_user_modal"
                        @endif
                                 data-user-id="{{$user->id}}"
                                 data-user-name="{{$user->name}}"
                                 data-user-email="{{$user->email}}"
                                 data-user-account-type="{{$user->account_type}}"
                                 data-user-warehouse="{{$user->warehouse}}">
                                    <?php
                                } else {
                                    ?>
                                    @if (Auth::user()->account_type == Auth::user()->manager)
                                            <tr class='odd clickable_row_no_href' data-toggle="modal" data-target="#edit_user_modal"
                                    @else
                                            <tr class='odd not-active' data-toggle="modal" data-target="#edit_user_modal"
                                    @endif
                                    data-user-id="{{$user->id}}"
                                    data-user-name="{{$user->name}}"
                                    data-user-email="{{$user->email}}"
                                    data-user-account-type="{{$user->account_type}}"
                                    data-user-warehouse="{{$user->warehouse}}">
                                    <?php
                                }?>

                                <td>
                                @if ($user->name != Auth::user()->name && Auth::user()->account_type == Auth::user()->manager)
                                    <label class="checkbox_container">
                                        <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$user->id}}">
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                                </td>
                                <td class="jSortName">
                                    {{$user->name}}
                                </td>
                                <td class="jSortEmail">
                                    {{$user->email}}
                                </td>
                                <td class="jSortAccountType">
                                    {{$user->account_type}}
                                </td>
                                <td class="jSortWarehouse">
                                    {{$user->warehouse}}
                                </td>
                            </tr>
                            <?php $counter+=1;?>
                        @endforeach
                        <?php $counter=0?>
                    </tbody>
                </table>
            </form>
            <div class="table_action_row">
                <ul class="pagination"></ul>
                <button type="button" class="jPaginateBack btn_styled"><</button>
                <button type="button" class="jPaginateNext btn_styled">></button>
            </div> 
        </div>
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
                            <label for="password">Typ konta:</label>
                            <select id="user_account_type" name="account_type">
                              <option value="menadżer">menadżer</option>
                              <option value="brygadzista polerni">brygadzista polerni</option>
                              <option value="brygadzista hali autodetailingu">brygadzista hali autodetailingu</option>
                              <option value="pracownik polerni">pracownik polerni</option>
                              <option value="pracownik autodetailingu">pracownik autodetailingu</option>
                            </select>
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
                        <input id="edit_id" type="hidden" name="id">

                        <div class="form-group">
                            <label for="edit_name">Nazwa użytkownika:</label>
                            <input id="edit_name" type="text" class="form-control" name="name" placeholder="3-30 znaków">
                        </div>

                        <div class="form-group">
                            <label for="edit_email">Adres email:</label>
                            <input id="edit_email" type="text" class="form-control" name="email" placeholder="6-40 znaków">
                        </div>
                        <div class="form-group">
                            <label for="password">Typ konta:</label>
                            <select id="edit_user_account_type" name="account_type">
                              <option value="menadżer">menadżer</option>
                              <option value="brygadzista polerni">brygadzista polerni</option>
                              <option value="brygadzista hali autodetailingu">brygadzista hali autodetailingu</option>
                              <option value="pracownik polerni">pracownik polerni</option>
                              <option value="pracownik autodetailingu">pracownik autodetailingu</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input id="edit_pass_change_confirmation" name="pass_change_conf" type="checkbox"><label for="edit_password">Zmień hasło:</label>
                            <input id ="edit_password" type="password" class="form-control" name="password" placeholder="6-20 znaków">
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
