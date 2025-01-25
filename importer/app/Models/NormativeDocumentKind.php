<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NormativeDocumentKind extends Model
{
    protected $table = 'normative_docs_kinds';

    protected $fillable = [
        'id',
        'name'
    ];
}
