@extends('layouts.app')

@section('title')
    <title> Rejestr operacji magazynowych </title>
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
    <li class='curr_module'><a href="/resourcesManager">Moduł zasobów magazynowych</a></li>
    <li><a href="/tireManager">Moduł opon</a></li>
    <li><a href="/userManager">Moduł użytkowników</a></li>
@endsection

@section('content')
    <div class='container ap_table_container'>
        @if (Auth::user()->account_type == "administrator")
            <div class='ap_action_bar'>
                <a href='/resourcesManager' class="btn btn_grey btn_green">Wróć</a>
                <button type="button" class="btn btn_grey btn_green" data-toggle="modal" data-target="#report_modal">Raportuj</button>
            </div>
        @endif
        <table class='ap_table'>
                <tr>
                    <th>Nazwa zasobu</th>
                    <th>Typ operacji</th>
                    <th>Ilość</th>
                    <th>Firma</th>
                    <th>Data przyjęcia</th>
                </tr>
                <?php $counter=0?>
                @foreach($warehouseOperations as $wO)
                    <?php
                        if($counter%2==0) {
                            echo"<tr class='even'>";
                        } else {
                            echo"<tr class ='odd'>";
                        }?>
                        
                        <td>
                            {{$wO->resource_name}}
                        </td>
                        <td>
                            {{$wO->operation_type}}
                        </td>
                        <td>
                            {{$wO->quantity}}
                        </td>
                        <td>
                            {{$wO->company_name}}
                        </td>
                        <td>
                            {{$wO->created_at}}
                        </td>
                    </tr>
                    <?php $counter+=1;?>
                @endforeach
                <?php $counter=0?>  
            </form>
        </table>
        
        <!--report modal-->  
        <div class="modal fade" tabindex="-1" role="dialog" id="report_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal_light_grey">
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
                        <button type="button" class="btn btn_grey btn_red" data-dismiss="modal">Zamknij</button>
                        <button form="report_warehouse_operations_form" type="submit" class="btn btn_grey btn_green">Raportuj</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection