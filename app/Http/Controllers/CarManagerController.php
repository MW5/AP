<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\CarTask;
use Session;

class CarManagerController extends Controller
{
  function removeCars(Request $request) {
      if(!empty($request->get('ch')) != 0) {
          foreach($request->get('ch') as $c) {
              $car = Car::find($c);
              if($car->delete()) {
                $carTasks = CarTask::where('car_reg_num',$car->reg_num)->get();
                foreach($carTasks as $cT) {
                  $cT->delete();
                }
              };
          }
          Session::flash('message', 'Pomyślnie usunięto samochody +TUTAJ USUWAJ TEŻ ZLECENIA POWIĄZANE');
          Session::flash('alert-class', 'alert-success');
      } else {
          Session::flash('message', 'Wybierz samochody do usunięcia');
          Session::flash('alert-class', 'alert-warning');
      }

      return back();
  }

  function addCar(Request $request) {
      $this->validate($request,[
          'reg_num'=>'required|min:1|max:10|unique:cars',
          'make'=>'required|min:1|max:50',
          'model'=>'required|min:1|max:50'
      ]);
      $car = new Car();
      $car->reg_num = $request->reg_num;
      $car->make = $request->make;
      $car->model = $request->model;
      $car->status = "do weryfikacji";
      if($car->save()) {
        $carTask = new CarTask();
        $carTask->car_reg_num = $car->reg_num;
        $carTask->task_type = "weryfikacja stanu";
        $carTask->status = "nowe";
        $carTask->save();
      }

      Session::flash('message', 'Pomyślnie dodano samochód '.$car->reg_num.'oraz zlecenie weryfikacji');
      Session::flash('alert-class', 'alert-success');
      return back();
  }

  function editCar(Request $request) {
    $car =  Car::find($request->id);
    $carTasks = CarTask::where('car_reg_num',$car->reg_num)->get();

      $this->validate($request,[
          'reg_num'=>'required|min:1|max:10|unique:cars,reg_num,'.$car->id,
          'make'=>'required|min:1|max:50',
          'model'=>'required|min:1|max:50'
      ]);

      $car->reg_num = $request->reg_num;
      $car->make = $request->make;
      $car->model = $request->model;
      
      if($car->update()) {
                foreach($carTasks as $cT) {
                  $cT->car_reg_num = $request->reg_num;
                  $cT->update();
                }
              };

      Session::flash('message', 'Pomyślnie edytowano samochód '.$car->reg_num);
      Session::flash('alert-class', 'alert-success');
      return back();
  }
}
