<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    protected $table = 'change_history';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_id',
        'address_object_id',
        'operation_type_id',
        'ndoc_id',
        'change_date',
    ];
}
