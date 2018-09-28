<?php

namespace App;

use App\Car;
use App\CarTask;

class CarStatusSetterService {
    private $carStatuses = [
        'brak zleceń',
        'do weryfikacji',
        'weryfikowany',
        'do polerowania',
        'polerowany',
        'do autodetailingu',
        'przeprowadzany autodetailing',
        'ukończony'
    ];
    
    private $carTaskTypes = [
        'weryfikacja stanu',
        'polerowanie',
        'autodetailing'
    ];
    
    private $carTaskStatuses = [
        'nowe',
        'realizowane',
        'zakończone'
    ];
    public static function setCarStatus(CarTask $carTask)
    {
        $carStatus = "";
        $car = Car::where('reg_num', $carTask->car_reg_num)->first();
        $carTasks = CarTask::where('car_reg_num', $car->reg_num)->get();
        $carTasksNumber = count($carTasks);
        $finishedCarTasks = 0;
        if ($carTasksNumber > 0) {
           foreach ($carTasks as $carTask) {
               $carStatus = $carStatus . $carTask->task_type . " (" .
                       $carTask->status . "), ";
               if ($carTask->status == "zakończone") {
                   $finishedCarTasks += 1;
               }
          }
          $car->status = substr($carStatus, 0, strlen($carStatus)-2);
        } else {
            $car->status = "brak zleceń";
        }
//        
        if ($carTasksNumber > 0 && $carTasksNumber == $finishedCarTasks) {
            $car->status = "przygotowany do sprzedaży";
        }
        
        $car->update();
    }
}
