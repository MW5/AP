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
        @if (Auth::user()->account_type == 0)
            <div class='ap_action_bar'>
                <button type="button" class="btn_styled" data-toggle="modal" data-target="#add_carTask_modal">Dodaj zlecenie</button>
                <button form="remove_carTasks_form" type="submit" class="btn_styled">Usuń zaznaczone zlecenia</button>
            </div>
        @endif
        <table class='ap_table'>
            <form id="remove_carTasks_form" method="POST" action="/carTaskManager/removeCarTasks">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <th></th>
                    <th>Numer rejestracyjny</th>
                    <th>Typ zlecenia</th>
                    <th>Status</th>
                    <th>Czas rozpoczęcia</th>
                    <th>Użytkownik rozpoczynający</th>
                    <th>Czas zakończenia</th>
                    <th>Użytkownik kończący</th>
                </tr>
                <?php $counter=0?>
                @foreach($carTasks as $carTask)
                    <?php
                        if($counter%2==0) {
                            ?>
                        <tr class='even clickable_row_no_href' data-toggle="modal" data-target="#edit_carTask_modal"
                         data-car-task-id="{{$carTask->id}}"
                         data-car-task-car-id="{{$carTask->car_id}}"
                         data-car-task-task-type="{{$carTask->task_type}}"
                         data-car-task-begin-time="{{$carTask->begin_time}}"
                         data-car-task-begin-user="{{$carTask->begin_user_id}}"
                         data-car-task-end-time="{{$carTask->end_time}}"
                         data-car-task-end-user="{{$carTask->end_user_id}}">
                            <?php
                        } else {
                            ?>
                            <tr class='odd clickable_row_no_href' data-toggle="modal" data-target="#edit_carTask_modal"
                             data-car-task-id="{{$carTask->id}}"
                             data-car-task-car-id="{{$carTask->car_id}}"
                             data-car-task-task-type="{{$carTask->task_type}}"
                             data-car-task-begin-time="{{$carTask->begin_time}}"
                             data-car-task-begin-user="{{$carTask->begin_user_id}}"
                             data-car-task-end-time="{{$carTask->end_time}}"
                             data-car-task-end-user="{{$carTask->end_user_id}}">
                            <?php
                        }?>

                        <td>
                            <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$carTask->id}}">
                        </td>
                        <td>
                          @foreach($cars as $car)
                            @if ($carTask->car_id == $car->id)
                              {{$car->reg_num}}
                            @endif
                          @endforeach
                        </td>
                        <td>
                            {{$carTask->task_type}}
                        </td>
                        <td>
                            {{$carTask->status}}
                        </td>
                        <td>
                            {{$carTask->begin_time}}
                        </td>
                        <td>
                            {{$carTask->begin_user_id}}
                        </td>
                        <td>
                            {{$carTask->end_time}}
                        </td>
                        <td>
                            {{$carTask->end_user_id}}
                        </td>
                    </tr>
                    <?php $counter+=1;?>
                @endforeach
                <?php $counter=0?>
            </form>
        </table>
    </div>

    <!--add carTask modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add_carTask_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dodaj zadanie</h4>
                </div>
                <div class="modal-body">
                    <form id="add_carTask_form" method="POST" action="/carTaskManager/addCarTask">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="car_id">Numer rejestracyjny:</label>
                            <select name="car_id">
                            @foreach($cars as $car)
                              <option value="{{$car->id}}">{{$car->reg_num}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="make">Typ zlecenia:</label>
                            <select name="task_type">
                              <option>0</option>
                              <option>1</option>
                              <option>2</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="add_carTask_form" type="submit" class="btn btn_styled btn_safe">Dodaj zlecenie</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit car task modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit_carTask_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_styled">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edytuj zadanie</h4>
                </div>
                <div class="modal-body">
                    <form id="edit_carTask_form" method="POST" action="/carTaskManager/editCarTask">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input id="edit_id" type="hidden" name="id">

                        <div class="form-group">
                            <label for="edit_car_id">Numer rejestracyjny:</label>
                            <select id="edit_car_id" name="car_id">
                            @foreach($cars as $car)
                              <option value="{{$car->id}}">{{$car->reg_num}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="task_type">Typ zlecenia:</label>
                            <select id="edit_task_type" name="task_type">
                              <option>0</option>
                              <option>1</option>
                              <option>2</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_begin_time">Czas rozpoczęcia:</label>
                            <div class='input-group date' id='edit_begin_time'>
                               <input type='text' class="form-control" name="begin_time"
                                   value="{{ old('begin_time') }}"/>
                               <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                               </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_begin_user">Użytkownik rozpoczynający</label>
                            <select id="edit_begin_user" name="begin_user">
                              @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="edit_begin_time">Czas rozpoczęcia:</label>
                            <input id="edit_begin_time" type="text" class="form-control" name="begin_time" placeholder="1-50 znaków"
                                value="{{ old('begin_time') }}">
                        </div>

                        <div class="form-group">
                            <label for="make">Typ zlecenia:</label>
                            <select name="task_type">
                              <option>0</option>
                              <option>1</option>
                              <option>2</option>
                            </select>
                        </div> -->


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_styled btn_warning" data-dismiss="modal">Zamknij</button>
                    <button form="edit_carTask_form" type="submit" class="btn btn_styled btn_safe">Edytuj zlecenie</button>
                </div>
            </div>
        </div>
    </div>
@endsection
