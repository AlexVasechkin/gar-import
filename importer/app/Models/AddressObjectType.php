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

    public static function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']],
            [
                'level' => (int) $item['LEVEL'],
                'name' => (string) $item['NAME'],
                'shortname' => (string) $item['SHORTNAME'], 
                'desc' => (string) $item['DESC'],
                'is_active' => (string) $item['ISACTIVE'] === 'true',
                'update_date' => (string) $item['UPDATEDATE'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }

    public static function isDataSuccess(): bool
    {
        return true;
    }
}
