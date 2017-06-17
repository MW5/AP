@extends('layouts.app')

@section('title')
    <title> Aplikacja wspomagająca zarządzanie DSU AP </title>
@endsection

@section('logged_user')
    <div id="user_greet">
        Zalogowany: {{Auth::user()->name}}
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
    <li class='curr_module'><a href="/resourcesManager">Moduł środków nietrwałych</a></li>
    <li><a href="/tireManager">Moduł opon</a></li>
    <li><a href="/userManager">Moduł użytkowników</a></li>
@endsection

@section('content')
    <div class='container ap_table_container'>
        <div class='ap_action_bar'>
            <button type="button" class="btn btn_grey btn_green" data-toggle="modal" data-target="#add_resource_modal">Dodaj zasób</button>
            <button form="remove_resources_form" type="submit" class="btn btn_grey btn_red">Usuń zaznaczone zasoby</button>
            <button type="button" class="btn btn_grey btn_green" data-toggle="modal" data-target="#accept_delivery_modal">Przyjmij dostawę</button>
            <button type="button" class="btn btn_grey btn_green" data-toggle="modal" data-target="#warehouse_release_modal">Wydaj zasoby</button>
        </div>
        <table class='ap_table'>
            <form id="remove_resources_form" method="POST" action="/resourcesManager/removeResources">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <th></th>
                    <th>Nazwa</th>
                    <th>Ilość</th>
                    <th>Pojemność</th>
                    <th>Proporcje</th>
                </tr>
                <?php $counter=0?>
                @foreach($resources as $resource)
                    <?php
                        if($counter%2==0) {
                            echo"<tr class='even'>";
                        } else {
                            echo"<tr class ='odd'>";
                        }?>
                    
                        <td>
                            <input type="checkbox" name="ch[]" value="{{$resource->id}}">
                        </td>
                        <td>
                            {{$resource->name}}
                        </td>
                        <td>
                            {{$resource->quantity}}
                        </td>
                        <td>
                            {{$resource->capacity}}
                        </td>
                        <td>
                            {{$resource->proportions}}
                        </td>
                    </tr>
                    <?php $counter+=1;?>
                @endforeach
                <?php $counter=0?>  
            </form>
        </table>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="add_resource_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_light_grey">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dodaj zasób</h4>
                </div>
                <div class="modal-body">
                    <form id="add_resource_form" method="POST" action="/resourcesManager/addResource">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="form-group">
                            <label for="name">Nazwa:</label>
                            <input id="name" type="text" class="form-control" name="name" placeholder="1-50 znaków"
                                value="{{ old('name') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="capacity">Pojemność opakowania:</label>
                            <input id="capacity" type="text" class="form-control" name="capacity" placeholder="do 20 znaków"
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="proportions">Proporcje:</label></br>
                            <input id="proportions" type="text" class="form-control" name="proportions" placeholder="do 20 znaków"
                                value="{{ old('proportions') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Opis:</label>
                            <textarea id ="description" class="form-control" name="description" placeholder="do 400 znaków"
                                    >{{ old('description') }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_grey btn_red" data-dismiss="modal">Zamknij</button>
                    <button form="add_resource_form" type="submit" class="btn btn_grey btn_green">Dodaj zasób</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" tabindex="-1" role="dialog" id="accept_delivery_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_light_grey">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Przyjmij dostawę</h4>
                </div>
                <div class="modal-body">
                    <form id="accept_delivery_form" method="POST" action="/resourcesManager/acceptDelivery">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="form-group">
                            <label for="supplier">Dostawa z:</label>
                            <input id="supplier" type="text" class="form-control" name="supplier" placeholder="1-50 znaków"
                                value="{{ old('supplier') }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_grey btn_red" data-dismiss="modal">Zamknij</button>
                    <button form="accept_delivery_form" type="submit" class="btn btn_grey btn_green">Przymij dostawę</button>
                </div>
            </div>
        </div>
    </div>


@endsection