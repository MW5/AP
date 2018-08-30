<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\CarTask;
use Session;

class CarTaskManagerController extends Controller
{
  function removeCarTasks(Request $request) {
      if(!empty($request->get('ch')) != 0) {
          foreach($request->get('ch') as $c) {
              $carTask = CarTask::find($c);
              $carTask->delete();
          }
          Session::flash('message', 'Pomyślnie usunięto zlecenia +TUTAJ ZMIANY STANÓW SAMOCHODU');
          Session::flash('alert-class', 'alert-success');
      } else {
          Session::flash('message', 'Wybierz samochody do usunięcia');
          Session::flash('alert-class', 'alert-warning');
      }

      return back();
  }

  function addCarTask(Request $request) {
      $this->validate($request,[
          'car_id'=>'required',
          'task_type'=>'required'
      ]);

      $carTask = new CarTask();
      $car =  Car::find($request->car_id);

      $carTask->car_id = $car->id;
      $carTask->task_type = $request->task_type;
      $carTask->status = 0;
      $carTask->save();

      Session::flash('message', 'Pomyślnie dodano zadanie dla samochodu '.$carTask->reg_num.'TUTAJ ZMIANY STANÓW');
      Session::flash('alert-class', 'alert-success');
      return back();
  }

  function editCarTask(Request $request) {
      $carTask =  CarTask::find($request->id);
      $this->validate($request,[
          'car_id'=>'required',
          'task_type'=>'required',
          'begin_time' => 'required_with_all:begin_user_id|date_format:Y-m-d H:i:s|nullable',
          'begin_user_id' => 'required_with_all:begin_time|nullable',
          'end_time' => 'required_with_all:end_user_id_time|date_format:Y-m-d H:i:s|after:begin_time|nullable',
          'end_user_id' => 'required_with_all:end_time|nullable'
      ]);

      $carTask->car_id = $request->car_id;
      $carTask->task_type = $request->task_type;
      $carTask->begin_time = $request->begin_time;
      $carTask->begin_user_id = $request->begin_user_id;
      $carTask->end_time = $request->end_time;
      $carTask->end_user_id = $request->end_user_id;

      if($request->begin_time!="" && $request->end_time=="") {
        $carTask->status = 1;
      } else if ($request->end_time!="") {
        $carTask->status = 2;
      }
      $carTask->update();

      Session::flash('message', $request->begin_time);
      //Session::flash('message', 'Pomyślnie edytowano zlecenie');
      Session::flash('alert-class', 'alert-success');
      return back();
  }
}
