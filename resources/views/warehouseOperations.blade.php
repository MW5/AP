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
                <a href='/resourcesManager' class="btn_styled">Wróć</a>
                <!--<button type="button" class="btn btn_grey btn_green" data-toggle="modal" data-target="#report_modal">Raportuj</button>-->

                <!--TEMPORATY SOLUTION-->
                <button type="button" class="btn_styled" id="report_warehouse_operations">Raportuj</button>

            </div>
        @endif
        <table class='ap_table'>
                <tr>
                    <th>Nazwa zasobu</th>
                    <th>Typ operacji</th>
                    <th>Poprzednia ilość</th>
                    <th>Zmiana ilości</th>
                    <th>Nowa ilość</th>
                    <th>Firma</th>
                    <th>Data operacji</th>
                    <th>Użytkownik</th>

                </tr>
                <?php $counter=0?>
                @foreach($warehouseOperations as $wO)
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
                            @foreach ($resources as $r)
                              @if ($r->id == $wO->resource_id)
                                {{$r->name}}
                              @endif
                            @endforeach
                        </td>
                        <td>
                          @if ($wO->operation_type == 0)
                            przyjęcie
                          @else
                            wydanie
                          @endif
                        </td>
                        <td>
                            {{$wO->old_val}}
                        </td>
                        <td>
                            @if ($wO->operation_type == 0)
                                + {{$wO->quantity_change}}
                            @else
                                - {{$wO->quantity_change}}
                            @endif
                        </td>
                        <td>
                            {{$wO->new_val}}
                        </td>
                        <td>
                          @foreach ($suppliers as $s)
                            @if ($s->id == $wO->supplier_id)
                              {{$s->name}}
                            @endif
                          @endforeach
                        </td>
                        <td>
                            {{$wO->created_at}}
                        </td>
                        <td>
                          @foreach ($users as $u)
                            @if ($u->id == $wO->user_id)
                              {{$u->name}}
                            @endif
                          @endforeach
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
