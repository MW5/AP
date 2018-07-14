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
          'reg_num'=>'required',
          'task_type'=>'required'
      ]);

      $carTask = new CarTask();

      $car = Car::where('reg_num', '=' ,$request->reg_num)->firstOrFail();

      $carTask->car_id = $car->id;
      $carTask->car_reg_num = $request->reg_num;
      $carTask->task_type = $request->task_type;
      $carTask->status = 0;
      $carTask->save();

      Session::flash('message', 'Pomyślnie dodano zadanie dla samochodu '.$carTask->reg_num);
      Session::flash('alert-class', 'alert-success');
      return back();
  }
}
