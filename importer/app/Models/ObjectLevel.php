<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectLevel extends Model
{
    protected $fillable = [
        'id',
        'level',
        'name', 
        'start_date',
        'end_date',
        'update_date',
        'is_active'
    ];
}
