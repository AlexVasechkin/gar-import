<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'id',
        'name',
        'desc',
        'is_active',
        'update_date',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'update_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date'
    ];
}
