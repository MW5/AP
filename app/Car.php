<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
  protected $fillable = [
    "reg_num", "make", "model", "status"
  ];
  public function carTasks() {
    return $this->hasMany('App\CarTask');
  }
}
