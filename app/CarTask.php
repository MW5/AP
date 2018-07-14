<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarTask extends Model
{
  public function carTasks() {
      return $this->belongsTo('App\Car');
  }
}
