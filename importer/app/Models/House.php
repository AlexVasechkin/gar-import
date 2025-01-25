<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_id',
        'object_guid',
        'change_id',
        'house_number',
        'house_type_id',
        'operation_type_id',
        'prev_id',
        'next_id',
        'update_date',
        'start_date',
        'end_date',
        'is_actual',
        'is_active',
    ];
}
