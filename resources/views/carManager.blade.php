@extends('layouts.app')

@section('title')
    <title> Moduł samochodów </title>
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
        @if (Auth::user()->account_type == "administrator")
            <div class='ap_action_bar'>
                <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_car_modal">Dodaj samochód</button>
                <button form="remove_cars_form" type="submit" class="btn_styled">Usuń zaznaczone samochody</button>
            </div>
        @endif
        <table class='ap_table'>
            <form id="remove_cars_form" method="POST" action="/carManager/removeCars">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <th></th>
                    <th>Numer rejestracyjny</th>
                    <th>Marka</th>
                    <th>Model</th>
                    <th>Status</th>
                </tr>
                <?php $counter=0?>
                @foreach($cars as $car)
                    <?php
                        if($counter%2==0) {
                            ?>
                        <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#edit_car_modal"
                         data-car-id="{{$car->id}}"
                         data-car-reg-num="{{$car->reg_num}}"
                         data-car-make="{{$car->make}}"
                         data-car-model="{{$car->model}}"
                         data-car-status="{{$car->status}}">
                            <?php
                        } else {
                            ?>
                            <tr class='odd clickable_row_no_href' data-toggle="modal" data-target="#edit_car_modal"
                             data-car-id="{{$car->id}}"
                             data-car-reg-num="{{$car->reg_num}}"
                             data-car-make="{{$car->make}}"
                             data-car-model="{{$car->model}}"
                             data-car-status="{{$car->status}}">
                            <?php
                        }?>

                        <td>
                            <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$car->id}}">
                        </td>
                        <td>
                            {{$car->reg_num}}
                        </td>
                        <td>
                            {{$car->make}}
                        </td>
                        <td>
                            {{$car->model}}
                        </td>
                        <td>
                            {{$car->status}}
                        </td>
                    </tr>
                    <?php $counter+=1;?>
                @endforeach
                <?php $counter=0?>
            </form>
        </table>
    </div>

    <!--add car modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add_car_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dodaj samochód</h4>
                </div>
                <div class="modal-body">
                    <form id="add_car_form" method="POST" action="/carManager/addCar">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="reg_num">Numer rejestracyjny:</label>
                            <input id="reg_num" type="text" class="form-control" name="reg_num" placeholder="1-10 znaków"
                                value="{{ old('reg_num') }}">
                        </div>

                        <div class="form-group">
                            <label for="make">Marka:</label>
                            <input id="make" type="text" class="form-control" name="make" placeholder="1-50 znaków"
                                value="{{ old('make') }}">
                        </div>

                        <div class="form-group">
                            <label for="model">Model:</label>
                            <input id="model" type="text" class="form-control" name="model" placeholder="1-50 znaków"
                                value="{{ old('model') }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="add_car_form" type="submit" class="btn btn_styled btn_safe">Dodaj samochód</button>
                </div>
            </div>
        </div>
    </div>

   <!-- edit car modal-->
   <div class="modal fade" tabindex="-1" role="dialog" id="edit_car_modal">
       <div class="modal-dialog" role="document">
           <div class="modal-content modal_styled">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Edytuj samochód</h4>
               </div>
               <div class="modal-body">
                   <form id="edit_car_form" method="POST" action="/carManager/editCar">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input id="edit_id" type="hidden" name="id">

                       <div class="form-group">
                           <label for="edit_reg_num">Numer rejestracyjny:</label>
                           <input id="edit_reg_num" type="text" class="form-control" name="reg_num" placeholder="1-10 znaków"
                               value="{{ old('reg_num') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_make">Marka:</label>
                           <input id="edit_make" type="text" class="form-control" name="make" placeholder="1-50 znaków"
                               value="{{ old('make') }}">
                       </div>

                       <div class="form-group">
                           <label for="edit_model">Model:</label>
                           <input id="edit_model" type="text" class="form-control" name="model" placeholder="1-50 znaków"
                               value="{{ old('model') }}">
                       </div>
                   </form>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                   <button form="edit_car_form" type="submit" class="btn btn_styled btn_safe">Edytuj samochód</button>
               </div>
           </div>
       </div>
   </div>
@endsection