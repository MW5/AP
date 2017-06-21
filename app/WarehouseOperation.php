<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseOperation extends Model
{
    protected $fillable = [
        'resource_name', 'operation_type', 'quantity', 'company_name', 'user_name'
    ];
}
