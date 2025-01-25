<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressObjectParameter extends Model
{
    protected $table = 'address_object_parameters';

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

    protected $casts = [
        'change_id_end' => 'integer',
        'type_id' => 'integer',
        'update_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
