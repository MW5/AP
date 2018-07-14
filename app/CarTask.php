<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarTask extends Model
{
  protected $fillable = [
    'car_id', 'car_reg_num', 'task_type', 'status', 'begin_time', 'begin_user_id','end_time', 'end_user_id'
];
  public function carTasks() {
      return $this->belongsTo('App\Car');
  }
}
