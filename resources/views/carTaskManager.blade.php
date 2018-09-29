@extends('layouts.app')

@section('title')
    <title> Moduł zleceń </title>
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
        <div id="tableCarTasks" class="table-list-container">
            <div class='ap_action_bar'>
                <button id="add_car_task_btn" type="button" class="btn_styled" data-toggle="modal" data-target="#add_car_task_modal">Dodaj zlecenie</button>
                <button form="remove_car_tasks_form" type="submit" class="btn_styled">Usuń zaznaczone zlecenia</button>
                <button type="button" class="btn_styled export_list_btn">Eksportuj</button>
                <input class="search" placeholder="Filtruj">
            </div>
            <form id="remove_car_tasks_form" method="POST" action="/carTaskManager/removeCarTasks">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table-list table ap_table" data-currentpage="1" >
                    
                    <thead>
                        <th></th>
                        <th><button type="button" class="sort" data-sort="jSortRegNum">Numer rejestracyjny</button></th>
                        <th><button type="button" class="sort" data-sort="jSortCarTaskType">Typ zlecenia</button></th>
                        <th><button type="button" class="sort" data-sort="jSortStatus">Status</button></th>
                        <th><button type="button" class="sort" data-sort="jSortBeginTime">Czas rozpoczęcia</button></th>
                        <th><button type="button" class="sort" data-sort="jSortBeginUser">Użytkownik rozpoczynający</button></th>
                        <th><button type="button" class="sort" data-sort="jSortEndTime">Czas zakończenia</button></th>
                        <th><button type="button" class="sort" data-sort="jSortEndUser">Użytkownik kończący</button></th>
                    </thead>
                    <tbody class="list">
                    <?php $counter=0?>
                    @foreach($carTasks as $carTask)
                        <?php
                            if($counter%2==0) {
                                ?>
                            <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#edit_car_task_modal"
                             data-car-task-id="{{$carTask->id}}"
                             data-car-task-car-reg-num="{{$carTask->car_reg_num}}"
                             data-car-task-task-type="{{$carTask->task_type}}"
                             data-car-task-begin-time="{{$carTask->begin_time}}"
                             data-car-task-begin-user-name="{{$carTask->begin_user_name}}"
                             data-car-task-end-time="{{$carTask->end_time}}"
                             data-car-task-end-user-name="{{$carTask->end_user_name}}">
                                <?php
                            } else {
                                ?>
                                <tr class='odd clickable_row_no_href' data-toggle="modal" data-target="#edit_car_task_modal"
                                 data-car-task-id="{{$carTask->id}}"
                                 data-car-task-car-reg-num="{{$carTask->car_reg_num}}"
                                 data-car-task-task-type="{{$carTask->task_type}}"
                                 data-car-task-begin-time="{{$carTask->begin_time}}"
                                 data-car-task-begin-user-name="{{$carTask->begin_user_name}}"
                                 data-car-task-end-time="{{$carTask->end_time}}"
                                 data-car-task-end-user-name="{{$carTask->end_user_name}}">
                                <?php
                            }?>

                            <td>
                                @if (Auth::user()->account_type == Auth::user()->manager)
                                <label class="checkbox_container">
                                    <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$carTask->id}}">
                                    <span class="checkmark"></span>
                                </label>
                                @endif
                            </td>
                            <td class="jSortRegNum">
                                {{$carTask->car_reg_num}}
                            </td>
                            <td class="jSortCarTaskType">
                                {{$carTask->task_type}}
                            </td>
                            <td class="jSortStatus">
                                {{$carTask->status}}
                            </td>
                            <td class="jSortBeginTime">
                                {{$carTask->begin_time}}
                            </td>
                            <td class="jSortBeginUser">
                                {{$carTask->begin_user_name}}
                            </td>
                            <td class="jSortEndTime">
                                {{$carTask->end_time}}
                            </td>
                            <td class="jSortEndUser">
                                {{$carTask->end_user_name}}
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
    </div>

    <!--add carTask modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add_car_task_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dodaj zadanie</h4>
                </div>
                <div class="modal-body">
                    <form id="add_car_task_form" method="POST" action="/carTaskManager/addCarTask">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="add_car_reg_num">Numer rejestracyjny:</label>
                            <select id="add_car_reg_num" name="car_reg_num">
                            @foreach($cars as $car)
                              <option value="{{$car->id}}">{{$car->reg_num}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="make">Typ zlecenia:</label>
                            <select id="add_car_task_type" name="task_type">
                              <option>weryfikacja stanu</option>
                              <option>polerowanie</option>
                              <option>autodetailing</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="add_car_task_form" type="submit" class="btn btn_styled btn_safe">Dodaj zlecenie</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit car task modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit_car_task_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edytuj zadanie</h4>
                </div>
                <div class="modal-body">
                    <form id="edit_car_task_form" class="ap_form" method="POST" action="/carTaskManager/editCarTask">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input id="edit_id" type="hidden" name="id">

                        <div class="ap_form_row">
                            <label for="edit_car_reg_num">Numer rejestracyjny:</label>
                            <select id="edit_car_reg_num" name="car_reg_num">
                            @foreach($cars as $car)
                              <option value="{{$car->reg_num}}">{{$car->reg_num}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="ap_form_row">
                            <label for="task_type">Typ zlecenia:</label>
                            <select id="edit_task_type" name="task_type">
                              <option>weryfikacja stanu</option>
                              <option>polerowanie</option>
                              <option>autodetailing</option>
                            </select>
                        </div>

                        <div class="ap_form_row">
                            <label for="edit_begin_time">Czas rozpoczęcia:</label>
                            <div class='input-group date' id="begin_time_datepicker">
                               <input id='edit_begin_time' type='text' class="form-control" name="begin_time"/>
                               <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                               </span>
                            </div>
                        </div>

                        <div class="ap_form_row">
                            <label for="edit_begin_user_name">Użytkownik rozpoczynający</label>
                            <select id="edit_begin_user_name" name="begin_user_name">
                                <option value=""></option>
                              @foreach($users as $user)
                                <option value="{{$user->name}}">{{$user->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="ap_form_row">
                            <label for="edit_end_time">Czas zakończenia:</label>
                            <div class='input-group date' id="end_time_datepicker">
                               <input id='edit_end_time' type='text' class="form-control" name="end_time"/>
                               <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                               </span>
                            </div>
                        </div>

                        <div class="ap_form_row">
                            <label for="edit_end_user_name">Użytkownik kończący</label>
                            <select id="edit_end_user_name" name="end_user_name">
                              <option value=""></option>
                              @foreach($users as $user)
                                <option value="{{$user->name}}">{{$user->name}}</option>
                              @endforeach
                            </select>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="edit_car_task_form" type="submit" class="btn btn_styled btn_safe">Edytuj zlecenie</button>
                </div>
            </div>
        </div>
    </div>
@endsection
