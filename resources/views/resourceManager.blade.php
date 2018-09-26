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
        <div id="tableResources" class="table-list-container">
            @if (Auth::user()->account_type == "administracyjne")
                <div class='ap_action_bar'>
                    <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_resource_modal">Dodaj zasób</button>
                    <button form="remove_resources_form" type="submit" class="btn_styled">Usuń zaznaczone zasoby</button>
                    <button id="accept_delivery_btn" type="button" class="btn_styled" data-toggle="modal" data-target="#accept_delivery_modal">Przyjmij dostawę</button>
                    <button id="warehouse_release_btn" type="button" class=" btn_styled" data-toggle="modal" data-target="#warehouse_release_modal">Wydaj zasoby</button>
                    <a href='resourceManager/warehouseOperations' class="btn_styled">Rejestr operacji magazynowych</a>
                    <button type="button" class="btn_styled export_list_btn">Eksportuj</button>
                    <input class="search" placeholder="Filtruj">
                </div>
            @endif
            <form id="remove_resources_form" method="POST" action="/resourceManager/removeResources">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table-list table ap_table" data-currentpage="1" >
                    <thead>
                        <th></th>
                        <th><button type="button" class="sort" data-sort="jSortName">Nazwa</button></th>
                        <th><button type="button" class="sort" data-sort="jSortQuantity">Ilość</button></th>
                        <th><button type="button" class="sort" data-sort="jSortCriticalQuantity">Ilość minimalna</button></th>
                        <th><button type="button" class="sort" data-sort="jSortCapacity">Pojemność</button></th>
                        <th><button type="button" class="sort" data-sort="jSortProportions">Proporcje [preparat:woda]</button></th>
                    </thead>
                    <tbody class="list">
                      <?php $counter=0?>
                      @foreach($resources as $resource)
                            <?php
                                if($counter%2==0) {
                                    ?>
                                    <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#row_click_decision_modal"
                                        data-resource-id="{{$resource->id}}"
                                        data-resource-name="{{$resource->name}}"
                                        data-resource-critical-quantity="{{$resource->critical_quantity}}"
                                        data-resource-capacity="{{$resource->capacity}}"
                                        data-resource-proportions="{{$resource->proportions}}"
                                        data-resource-description="{{$resource->description}}">
                                    <?php
                                } else {
                                    ?>
                                    <tr class ='odd clickable_row_no_href' data-toggle="modal" data-target="#row_click_decision_modal"
                                        data-resource-id="{{$resource->id}}"
                                        data-resource-name="{{$resource->name}}"
                                        data-resource-critical-quantity="{{$resource->critical_quantity}}"
                                        data-resource-capacity="{{$resource->capacity}}"
                                        data-resource-proportions="{{$resource->proportions}}"
                                        data-resource-description="{{$resource->description}}">
                                    <?php
                                }?>
                                <td>
                                    @if (Auth::user()->account_type == "administracyjne")
                                        <label class="checkbox_container">
                                            <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$resource->id}}">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endif
                                </td>
                                <td class="jSortName">
                                    {{$resource->name}}
                                </td>
                                @if ($resource->quantity ==  $resource->critical_quantity+1)
                                    <td class="low_quantity jSortQuantity">
                                @elseif ($resource->quantity <=  $resource->critical_quantity)
                                    <td class="critical_quantity jSortQuantity">
                                @else
                                    <td class="normal_quantity jSortQuantity">
                                @endif
                                    {{$resource->quantity}}
                                </td>
                                <td class="jSortCriticalQuantity">
                                    {{$resource->critical_quantity}}
                                </td>
                                <td class="jSortCapacity">
                                    {{$resource->capacity}}
                                </td>
                                <td class="jSortProportions">
                                    {{$resource->proportions}}
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

    <!-- row click decision modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="row_click_decision_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Wybierz akcję</h4>
                </div>
                <div class="modal-footer">
                    <a id="details_btn_href">
                      <button id="details_btn" type="button" class="btn btn_styled btn_safe">Szczegóły zasobu</button>
                    </a>
                    <button id="edit_resource_btn" type="button" class="btn btn_styled btn_safe" data-toggle="modal"
                    data-dismiss="modal" data-target="#edit_resource_modal">Edytuj zasób</button>
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
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
                    <form id="add_resource_form" method="POST" action="/resourceManager/addResource">
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
                                value="{{ old('capacity') }}">
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

    <!--edit resource modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit_resource_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edytuj zasób</h4>
                </div>
                <div class="modal-body">
                    <form id="edit_resource_form" method="POST" action="/resourceManager/editResource">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input id="edit_id" type="hidden" name="id">

                        <div class="form-group">
                            <label for="edit_name">Nazwa:</label>
                            <input id="edit_name" type="text" class="form-control" name="name" placeholder="1-50 znaków"
                                value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="edit_critical_quantity">Minimalna ilość zamkniętych opakowań:</label>
                            <input id="edit_critical_quantity" type="text" class="form-control" name="critical_quantity" placeholder="wartość liczbowa, 0-1000"
                                value="{{ old('critical_quantity') }}">
                        </div>

                        <div class="form-group">
                            <label for="edit_capacity">Pojemność opakowania:</label>
                            <input id="edit_capacity" type="text" class="form-control" name="capacity" placeholder="niewymagane, do 20 znaków"
                                >
                        </div>
                        <div class="form-group">
                            <label for="edit_proportions">Proporcje [preparat:woda]:</label>
                            <input id="edit_proportions" type="text" class="form-control" name="proportions" placeholder="niewymagane, do 20 znaków"
                                value="{{ old('proportions') }}">
                        </div>

                        <div class="form-group">
                            <label for="edit_description">Opis:</label>
                            <textarea id ="edit_description" class="form-control" name="description" placeholder="5 do 400 znaków"
                                    >{{ old('description') }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="edit_resource_form" type="submit" class="btn btn_styled btn_safe">Edytuj zasób</button>
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
                    <form class='ap_form' id="accept_delivery_form" method="POST" action="/resourceManager/acceptDelivery">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_name" value="{{Auth::user()->name}}">
                        <div class="ap_form_row" id="accept_delivery_resources">
                        </div>
                        <div class="ap_form_row">
                            <label for="resource_ids">Wybierz zasoby:</label></br>
                                <select class="js-example-basic-multiple ap_form_select" name="states[]" multiple="multiple" id="accept_delivery_select_resources" name='resource_ids'>
                                    @foreach ($resources as $resource)
                                      <option value='{{$resource->id}}'>{{$resource->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="ap_form_row">
                            <button type="button" class="btn_styled" id="accept_delivery_resources_btn">Dodaj do listy</button>
                        </div>
                        <div class="ap_form_row">
                            <label for="supplier_id">Dostawa z:</label>
                            <select id="accept_delivery_select_supplier" class="ap_form_select" name='supplier_id'>
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
                    <form id="warehouse_release_form" class='ap_form' method="POST" action="/resourceManager/warehouseRelease">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_name" value="{{Auth::user()->name}}">
                        <div class="ap_form_row" id="accept_release_resources">
                        </div>
                        <div class="ap_form_row">
                            <label for="resource_ids">Wybierz zasoby:</label>
                                <select class="js-example-basic-multiple" name="states[]" multiple="multiple" id="accept_release_select_resources" name='resource_ids'>
                                    @foreach ($resources as $resource)
                                      <option value='{{$resource->id}}'>{{$resource->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="ap_form_row">
                            <button type="button" class="btn_styled" id="accept_release_resources_btn">Dodaj do listy</button>
                        </div>
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
