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
                <!--TEMPORATY SOLUTION-->
                <button type="button" class="btn_styled" id="report_warehouse_operations">Raportuj</button>

            </div>
        @endif
        <div id="tableWarehouseOperations" class="table-list-container">
            <table class="table-list table ap_table" data-currentpage="1" >
                <thead>
                    <th></th>
                    <th><button type="button" class="sort" data-sort="jSortName">Nazwa zasobu</button></th>
                    <th><button type="button" class="sort" data-sort="jSortOperationType">Typ operacji</button></th>
                    <th><button type="button" class="sort" data-sort="jSortOldVal">Poprzednia ilość</button></th>
                    <th><button type="button" class="sort" data-sort="jSortValChange">Zmiana ilości</button></th>
                    <th><button type="button" class="sort" data-sort="jSortNewVal">Nowa ilość</button></th>
                    <th><button type="button" class="sort" data-sort="jSortSupplierName">Firma</button></th>
                    <th><button type="button" class="sort" data-sort="jSortOperationDate">Data operacji</button></th>
                    <th><button type="button" class="sort" data-sort="jSortUser">Użytkownik</button></th>
                </thead>
                <tbody class="list">
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

                            <td class="jSortName">
                                @foreach ($resources as $r)
                                  @if ($r->id == $wO->resource_id)
                                    {{$r->name}}
                                  @endif
                                @endforeach
                            </td>
                            <td class="jSortOperationType">
                              @if ($wO->operation_type == 0)
                                przyjęcie
                              @else
                                wydanie
                              @endif
                            </td>
                            <td class="jSortOldVal">
                                {{$wO->old_val}}
                            </td>
                            <td class="jSortValChange">
                                @if ($wO->operation_type == 0)
                                    + {{$wO->quantity_change}}
                                @else
                                    - {{$wO->quantity_change}}
                                @endif
                            </td>
                            <td class="jSortNewVal">
                                {{$wO->new_val}}
                            </td>
                            <td class="jSortSupplierName">
                              @foreach ($suppliers as $s)
                                @if ($s->id == $wO->supplier_id)
                                  {{$s->name}}
                                @endif
                              @endforeach
                            </td>
                            <td class="jSortOperationDate">
                                {{$wO->created_at}}
                            </td>
                            <td class="jSortUser">
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
                </tbody>
            </table>
            <!--tutaj gdzies byl zamkniety form-->
            <table class="table-footer">
              <tr>
                <td class="table-pagination">
                  <button type="button" class="jPaginateBack"><i class="material-icons keyboard_arrow_left">&#xe314;</i></button>
                  <ul class="pagination"></ul>
                  <button type="button" class="jPaginateNext"><i class="material-icons keyboard_arrow_right">&#xe315;</i></button>
                </td>
                <td></td>
                  <td class="table-search">
                    <input class="search" placeholder="Search">
                </td>
              </tr>
            </table>
        </div>
    </div>

@endsection
