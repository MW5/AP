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
        @if (Auth::user()->account_type == "administrator")
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
                        <tr class='even'
                            <?php
                        } else {
                            ?>
                            <tr class='odd'
                            <?php
                        }?>

                        <td>
                            <input type="checkbox" class="ap_checkbox" name="ch[]" value="{{$carTask->id}}">
                        </td>
                        <td>
                            {{$carTask->reg_num}}
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
                            <label for="reg_num">Numer rejestracyjny:</label>
                            <select name="reg_num">
                            @foreach($cars as $car)
                              <option>{{$car->reg_num}}</option>
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
@endsection
