<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressObjectDivision extends Model
{
    protected $table = 'address_object_division';

    protected $fillable = [
        'parent_id',
        'child_id',
        'change_id',
    ];
}
