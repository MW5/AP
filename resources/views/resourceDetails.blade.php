@extends('layouts.app')

@section('title')
    <title> {{$resource->name}} - szczegóły </title>
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
    <li class='curr_module'><a href="/resourcesManager">Moduł zasobów magazynowych</a></li>
    <li><a href="/tireManager">Moduł opon</a></li>
    <li><a href="/userManager">Moduł użytkowników</a></li>
@endsection

@section('content')
    <div class='container ap_table_container'>
        <div class='ap_action_bar'>
            <a href='/resourcesManager' class="btn_styled">Wróć</a>
        </div>
        <div class="resource_description_container">
            <h1>{{$resource->name}}</h1>
            <h3>Obecny stan magazynowy: {{$resource->quantity}}</h3>
            <h3>Minimalna wymagana ilość: {{$resource->critical_quantity}}</h3>
            @if($resource->capacity != "")
                <h3>Pojemność opakowania: {{$resource->capacity}}</h3>
            @endif
            @if($resource->proportions != "")
            <h3>Proporcje [preparat:woda]: {{$resource->proportions}}</h3>
            @endif
            <p class="resource_description">{{$resource->description}}</p>
        </div>
        
        @if (Auth::user()->account_type == "administrator")
            <table class='ap_table'>
                    <tr>
                        <th>Typ operacji</th>
                        <th>Zmiana ilości</th>
                        <th>Firma</th>
                        <th>Data operacji</th>
                        <th>Użytkownik</th>
                    </tr>
                    <?php $counter=0?>
                    @foreach($warehouseOperations as $wO)
                        @if($wO->resource_name == $resource->name)
                            <?php
                                if($counter%2==0) {
                                    ?>
                                    <tr class='even'>
                                <?php
                                } else {
                                    ?>
                                    <tr class='odd'>
                                <?php
                                }?>
                                <td>
                                    {{$wO->operation_type}}
                                </td>
                                <td>
                                    @if($wO->operation_type == "przyjęcie magazynowe")
                                        + {{$wO->quantity}}
                                    @else
                                        - {{$wO->quantity}}
                                    @endif
                                </td>
                                <td>
                                    {{$wO->company_name}}
                                </td>
                                <td>
                                    {{$wO->user_name}}
                                </td>
                                <td>
                                    {{$wO->created_at}}
                                </td>
                            </tr>
                            <?php $counter+=1;?>
                        @endif
                    @endforeach
                    <?php $counter=0?>  
                </form>
            </table>
        @endif
        
        <!--report modal-->  
        <div class="modal fade" tabindex="-1" role="dialog" id="report_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal_styled">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Raportuj</h4>
                    </div>
                    <div class="modal-body">
                        <form id="report_warehouse_perations_form" method="POST" action="/resourcesManager/warehouseOperations/report">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="supplier">Add operation type select and min/max date selection</label>
                                    <input id="supplier" type="text" class="form-control" name="supplier" placeholder="1-50 znaków"
                                        value="{{ old('supplier') }}">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                        <button form="report_warehouse_operations_form" type="submit" class="btn btn_styled btn_safe">Raportuj</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection