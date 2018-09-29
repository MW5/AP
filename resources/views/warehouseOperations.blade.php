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
        <div id="tableWarehouseOperations" class="table-list-container">
            <div class='ap_action_bar'>
                <a href='/resourceManager' class="btn_styled">Wróć</a>
                <button type="button" class="btn_styled export_list_btn">Eksportuj</button>
                <input class="search" placeholder="Filtruj">
            </div>
            <table class="table-list table ap_table" data-currentpage="1" >
                <thead>
                    <th><button type="button" class="sort" data-sort="jSortName">Nazwa zasobu</button></th>
                    <th><button type="button" class="sort" data-sort="jSortOperationType">Typ operacji</button></th>
                    <th><button type="button" class="sort" data-sort="jSortOldVal">Poprzednia ilość</button></th>
                    <th><button type="button" class="sort" data-sort="jSortValChange">Zmiana ilości</button></th>
                    <th><button type="button" class="sort" data-sort="jSortNewVal">Nowa ilość</button></th>
                    <th><button type="button" class="sort" data-sort="jSortSupplierName">Firma</button></th>
                    <th><button type="button" class="sort" data-sort="jSortOperationDate">Data operacji</button></th>
                    <th><button type="button" class="sort" data-sort="jSortUser">Użytkownik</button></th>
                    <th><button type="button" class="sort" data-sort="jSortWarehouse">Magazyn</button></th>
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
                                {{$wO->resource_name}}
                            </td>
                            <td class="jSortOperationType">
                                {{$wO->operation_type}}
                            </td>
                            <td class="jSortOldVal">
                                {{$wO->old_val}}
                            </td>
                            <td class="jSortValChange">
                                @if ($wO->operation_type == "przyjęcie")
                                    +{{$wO->quantity_change}}
                                @else
                                    -{{$wO->quantity_change}}
                                @endif
                            </td>
                            <td class="jSortNewVal">
                                {{$wO->new_val}}
                            </td>
                            <td class="jSortSupplierName">
                                {{$wO->supplier_name}}
                            </td>
                            <td class="jSortOperationDate">
                                {{$wO->created_at}}
                            </td>
                            <td class="jSortUser">
                                {{$wO->user_name}}
                            </td>
                            <td class="jSortWarehouse">
                                {{$wO->warehouse}}
                            </td>
                        </tr>
                        <?php $counter+=1;?>
                    @endforeach
                    <?php $counter=0?>
                </tbody>
            </table>
            <div class="table_action_row">
                <ul class="pagination"></ul>
                <button type="button" class="jPaginateBack btn_styled"><</button>
                <button type="button" class="jPaginateNext btn_styled">></button>
            </div> 
        </div>
    </div>

@endsection
