<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'code', 'name', 'quantity', 'capacity', 'proportions', 'description', 'warehouse'
    ];
}
