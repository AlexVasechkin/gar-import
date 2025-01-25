<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReestrObject extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_guid',
        'change_id',
        'level_id',
        'create_date',
        'update_date',
        'is_active',
    ];
}
