@extends('layouts.app')

@section('title')
    <title> Moduł zasobów </title>
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
        @if (Auth::user()->account_type == 0)
            <div class='ap_action_bar'>
                <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_resource_modal">Dodaj zasób</button>
                <button form="remove_resources_form" type="submit" class="btn_styled">Usuń zaznaczone zasoby</button>
                <button type="button" class="btn_styled" data-toggle="modal" data-target="#accept_delivery_modal">Przyjmij dostawę</button>
                <button type="button" class=" btn_styled" data-toggle="modal" data-target="#warehouse_release_modal">Wydaj zasoby</button>
                <a href='resourcesManager/warehouseOperations' class="btn_styled">Rejestr operacji magazynowych</a>
            </div>
        @endif
        <table class='ap_table'>
            <form id="remove_resources_form" method="POST" action="/resourcesManager/removeResources">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <th></th>
                    <th>Nazwa</th>
                    <th>Ilość</th>
                    <th>Pojemność</th>
                    <th>Proporcje [preparat:woda]</th>
                </tr>
                <?php $counter=0?>
                @foreach($resources as $resource)
                        <?php
                            if($counter%2==0) {
                                ?>
                            <tr class='even clickable_row' data-href='resourcesManager/{{$resource->id}}'>
                                <?php
                            } else {
                                ?>
                                <tr class ='odd clickable_row' data-href='resourcesManager/{{$resource->id}}'>
                                <?php
                            }?>
                            <td>
                                @if (Auth::user()->account_type == 0)
                                    <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$resource->id}}">
                                @endif
                            </td>

                            <td>
                                {{$resource->name}}
                            </td>
                            @if ($resource->quantity ==  $resource->critical_quantity+1)
                                <td class="low_quantity">
                            @elseif ($resource->quantity <=  $resource->critical_quantity)
                                <td class="critical_quantity">
                            @else
                                <td class="normal_quantity">
                            @endif

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

    <!--add resource modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add_resource_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
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
                            <label for="critical_quantity">Minimalna ilość zamkniętych opakowań:</label>
                            <input id="critical_quantity" type="text" class="form-control" name="critical_quantity" placeholder="wartość liczbowa, 0-1000"
                                value="{{ old('critical_quantity') }}">
                        </div>

                        <div class="form-group">
                            <label for="capacity">Pojemność opakowania:</label>
                            <input id="capacity" type="text" class="form-control" name="capacity" placeholder="niewymagane, do 20 znaków"
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="proportions">Proporcje [preparat:woda]:</label>
                            <input id="proportions" type="text" class="form-control" name="proportions" placeholder="niewymagane, do 20 znaków"
                                value="{{ old('proportions') }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Opis:</label>
                            <textarea id ="description" class="form-control" name="description" placeholder="5 do 400 znaków"
                                    >{{ old('description') }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="add_resource_form" type="submit" class="btn btn_styled btn_safe">Dodaj zasób</button>
                </div>
            </div>
        </div>
    </div>

    <!--accept delivery modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="accept_delivery_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Przyjmij dostawę</h4>
                </div>
                <div class="modal-body">
                    <form class='ap_form' id="accept_delivery_form" method="POST" action="/resourcesManager/acceptDelivery">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                        @foreach ($resources as $resource)
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-sm-6 horizontal_label" for="{{$resource->name}}_field_accept">{{$resource->name}}</label>
                                    <div class="col-sm-4">
                                        <button type="button" class="resource_increase" id="{{$resource->id}}_inc_btn_accept">+</button>
                                        <button type="button" class="resource_decrease" id="{{$resource->id}}_dec_btn_accept">-</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="res_id[]" value="{{$resource->id}}">
                                        <input id="{{$resource->id}}_field_accept" type="text" class="form-control horizontal_input" name="qty_field_accept[]"
                                               value=0>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label for="supplier_id">Dostawa z:</label>
                              <select name='supplier_id'>
                                  @foreach ($suppliers as $supplier)
                                    <option value='{{$supplier->id}}'>{{$supplier->name}}</option>
                                  @endforeach
                              </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="accept_delivery_form" type="submit" class="btn btn_styled btn_safe">Przymij dostawę</button>
                </div>
            </div>
        </div>
    </div>

     <!--warehouse release modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="warehouse_release_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Wydaj zasoby</h4>
                </div>
                <div class="modal-body">
                    <form id="warehouse_release_form" class='form-horizontal' method="POST" action="/resourcesManager/warehouseRelease">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                        @foreach ($resources as $resource)
                            <div class="form-group">
                                <label class="control-label col-sm-6 horizontal_label" for="{{$resource->id}}_field_release">{{$resource->name}}</label>
                                <div class="col-sm-4">
                                    <button type="button" class="resource_increase" id="{{$resource->id}}_inc_btn_release">+</button>
                                    <button type="button" class="resource_decrease" id="{{$resource->id}}_dec_btn_release">-</button>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="res_id[]" value="{{$resource->id}}">
                                    <input id="{{$resource->id}}_field_release" type="text" class="form-control horizontal_input" name="qty_field_release[]"
                                           value=0>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="warehouse_release_form" type="submit" class="btn btn_styled btn_safe">Wydaj</button>
                </div>
            </div>
        </div>
    </div>


@endsection
