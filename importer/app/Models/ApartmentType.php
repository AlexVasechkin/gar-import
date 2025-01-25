<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'shortname', 
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
