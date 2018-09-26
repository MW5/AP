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
          Session::flash('message', 'Wybierz zlecenia do usunięcia');
          Session::flash('alert-class', 'alert-warning');
      }

      return back();
  }

  function addCarTask(Request $request) {
      $this->validate($request,[
          'car_reg_num'=>'required',
          'task_type'=>'required'
      ]);

      $carTask = new CarTask();
      $car =  Car::find($request->car_reg_num);
      
      $carTask->car_reg_num = $car->reg_num;
      $carTask->task_type = $request->task_type;
      $carTask->status = "nowe";
      $carTask->save();

      Session::flash('message', 'Pomyślnie dodano zadanie dla samochodu '.$car->reg_num.'TUTAJ ZMIANY STANÓW');
      Session::flash('alert-class', 'alert-success');
      return back();
  }

  function editCarTask(Request $request) {
      $carTask =  CarTask::find($request->id);
      $this->validate($request,[
          'car_reg_num'=>'required',
          'task_type'=>'required',
          'begin_time' => 'required_with_all:begin_user_name|date_format:Y-m-d H:i:s|nullable',
          'begin_user_name' => 'required_with_all:begin_time|nullable',
          'end_time' => 'required_with_all:end_user_name|date_format:Y-m-d H:i:s|after:begin_time|nullable',
          'end_user_name' => 'required_with_all:end_time|nullable'
      ]);

      $carTask->car_reg_num = $request->car_reg_num;
      $carTask->task_type = $request->task_type;
      $carTask->begin_time = $request->begin_time;
      $carTask->begin_user_name = $request->begin_user_name;
      $carTask->end_time = $request->end_time;
      $carTask->end_user_name = $request->end_user_name;

      if($request->begin_time!="" && $request->end_time=="") {
        $carTask->status = "realizowane";
      } else if ($request->end_time!="") {
        $carTask->status = "zakończone";
      }
      $carTask->update();

      Session::flash('message', $request->begin_time);
      Session::flash('message', 'Pomyślnie edytowano zlecenie');
      Session::flash('alert-class', 'alert-success');
      return back();
  }
}
