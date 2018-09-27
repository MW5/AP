<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseOperation extends Model
{
    protected $fillable = [
        'resource_id', 'operation_type', 'old_val', 'quantity_change', 'new_val', 'company_id', 'user_id'
    ];
    public $operationAccept = "przyjęcie";
    public $operationRelease = "wydanie";
}
