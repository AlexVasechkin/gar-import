<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarplaceParameter extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_id',
        'change_id',
        'change_id_end',
        'type_id',
        'value',
        'update_date',
        'start_date',
        'end_date',
    ];
}
