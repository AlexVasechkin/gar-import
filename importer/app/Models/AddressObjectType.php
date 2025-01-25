<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddressObjectType extends Model
{
    use HasFactory;

    protected $table = 'address_object_types';

    protected $fillable = [
        'id',
        'level',
        'name', 
        'shortname',
        'desc',
        'is_active',
        'update_date',
        'start_date',
        'end_date'
    ];

    public $timestamps = true;
}
