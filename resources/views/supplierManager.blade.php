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
    @if (Auth::user()->account_type == 0)
        <div class='ap_action_bar'>
            <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_supplier_modal">Dodaj dostawcę</button>
            <button form="remove_suppliers_form" type="submit" class="btn_styled">Usuń zaznaczonych dostawców</button>
        </div>
    @endif

    <div id="tableSuppliers" class="table-list-container">
      <form id="remove_suppliers_form" method="POST" action="/supplierManager/removeSuppliers">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="table-list table ap_table" data-currentpage="1" >

                  <thead>
                        <th></th>
                        <th><button type="button" class="sort" data-sort="jSortName">Nazwa</button></th>
                        <th><button type="button" class="sort" data-sort="jSortAddress">Adres</button></th>
                        <th><button type="button" class="sort" data-sort="jSortNip">Nip</button></th>
                        <th><button type="button" class="sort" data-sort="jSortEmail">Adres email</button></th>
                        <th><button type="button" class="sort" data-sort="jSortPhoneNumber">Numer telefonu</button></th>
                        <th><button type="button" class="sort" data-sort="jSortDetails">Informacje dodatkowe</button></th>
                  </thead>

                  <!-- IMPORTANT, class="list" must be on tbody -->
                  <tbody class="list">
                    <?php $counter=0?>
                    @foreach($suppliers as $supplier)
                        <?php
                            if($counter%2==0) {
                                ?>
                            <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#edit_supplier_modal"
                             data-supplier-id="{{$supplier->id}}"
                             data-supplier-name="{{$supplier->name}}"
                             data-supplier-address="{{$supplier->address}}"
                             data-supplier-nip="{{$supplier->nip}}"
                             data-supplier-email="{{$supplier->email}}"
                             data-supplier-phone-number="{{$supplier->phone_number}}"
                             data-supplier-details="{{$supplier->details}}">
                                <?php
                            } else {
                                ?>
                                <tr class='odd clickable_row_no_href' data-toggle="modal" data-target="#edit_supplier_modal"
                                 data-supplier-id="{{$supplier->id}}"
                                 data-supplier-name="{{$supplier->name}}"
                                 data-supplier-address="{{$supplier->address}}"
                                 data-supplier-nip="{{$supplier->nip}}"
                                 data-supplier-email="{{$supplier->email}}"
                                 data-supplier-phone-number="{{$supplier->phone_number}}"
                                 data-supplier-details="{{$supplier->details}}">
                                <?php
                            }?>

                            <td>
                                <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$supplier->id}}">
                            </td>
                            <td class="jSortName">
                                {{$supplier->name}}
                            </td>
                            <td class="jSortAddress">
                                {{$supplier->address}}
                            </td>
                            <td class="jSortNip">
                                {{$supplier->nip}}
                            </td>
                            <td class="jSortEmail">
                                {{$supplier->email}}
                            </td>
                            <td class="jSortPhoneNumber">
                                {{$supplier->phone_number}}
                            </td>
                            <td class="jSortDetails">
                                {{$supplier->details}}
                            </td>
                        </tr>
                        <?php $counter+=1;?>
                    @endforeach
                    <?php $counter=0?>

                  </tbody>

              </table>
            </form>

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



    <!--add supplier modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add_supplier_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dodaj dostawcę</h4>
                </div>
                <div class="modal-body">
                    <form id="add_supplier_form" method="POST" action="/supplierManager/addSupplier">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name">Nazwa dostawcy:</label>
                            <input id="name" type="text" class="form-control" name="name" placeholder="1-50 znaków"
                                value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="address">Adres:</label>
                            <input id="address" type="text" class="form-control" name="address" placeholder="1-150 znaków"
                                value="{{ old('address') }}">
                        </div>

                        <div class="form-group">
                            <label for="nip">Nip:</label>
                            <input id="nip" type="text" class="form-control" name="nip" placeholder="10 cyfr"
                                value="{{ old('nip') }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Adres email:</label>
                            <input id="email" type="text" class="form-control" name="email" placeholder="6-40 znaków"
                                value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Numer telefonu:</label>
                            <input id="phone_number" type="text" class="form-control" name="phone_number" placeholder="1-15 cyfr"
                                value="{{ old('phone_number') }}">
                        </div>

                        <div class="form-group">
                            <label for="details">Informacje dodatkowe</label>
                            <textarea id ="details" class="form-control" name="details" placeholder="5 do 400 znaków"
                                    >{{ old('details') }}</textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="add_supplier_form" type="submit" class="btn btn_styled btn_safe">Dodaj dostawcę</button>
                </div>
            </div>
        </div>
    </div>

   <!-- edit supplier modal-->
   <div class="modal fade" tabindex="-1" role="dialog" id="edit_supplier_modal">
       <div class="modal-dialog" role="document">
           <div class="modal-content modal_styled">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Edytuj dostawcę</h4>
               </div>
               <div class="modal-body">
                   <form id="edit_supplier_form" method="POST" action="/supplierManager/editSupplier">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input id="edit_id" type="hidden" name="id">

                       <div class="form-group">
                           <label for="edit_name">Nazwa dostawcy:</label>
                           <input id="edit_name" type="text" class="form-control" name="name" placeholder="1-50 znaków"
                               value="{{ old('name') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_address">Adres:</label>
                           <input id="edit_address" type="text" class="form-control" name="address" placeholder="1-150 znaków"
                               value="{{ old('address') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_nip">Nip:</label>
                           <input id="edit_nip" type="text" class="form-control" name="nip" placeholder="10 cyfr"
                               value="{{ old('nip') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_email">Adres email:</label>
                           <input id="edit_email" type="text" class="form-control" name="email" placeholder="6-40 znaków"
                               value="{{ old('email') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_phone_number">Numer telefonu:</label>
                           <input id="edit_phone_number" type="text" class="form-control" name="phone_number" placeholder="1-15 cyfr"
                               value="{{ old('phone_number') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_details">Informacje dodatkowe</label>
                           <textarea id ="edit_details" class="form-control" name="details" placeholder="5 do 400 znaków"
                                   >{{ old('details') }}</textarea>
                       </div>
                   </form>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                   <button form="edit_supplier_form" type="submit" class="btn btn_styled btn_safe">Edytuj dostawcę</button>
               </div>
           </div>
       </div>
   </div>
@endsection
