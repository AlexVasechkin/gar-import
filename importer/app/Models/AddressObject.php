<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressObject extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_id',
        'object_guid',
        'change_id',
        'name',
        'type_name',
        'level',
        'operation_type_id',
        'prev_id',
        'next_id',
        'update_date',
        'start_date',
        'end_date',
        'is_actual',
        'is_active',
    ];

    protected $casts = [
        'is_actual' => 'boolean',
        'is_active' => 'boolean',
        'update_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // <OBJECT ID="1954863" OBJECTID="104741782" OBJECTGUID="7eb3b86b-00ca-4108-9e35-4e13837a4f5f" CHANGEID="283914940" NAME="Восточная" TYPENAME="тер." LEVEL="7" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2022-06-16" STARTDATE="2022-06-16" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    public static function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'object_guid' => (string) $item['OBJECTGUID'] ?? 0,
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'name' => (string) $item['NAME'] ?? '',
                'type_name' => (string) $item['TYPENAME'] ?? '',
                'level' => (int) $item['LEVEL'] ?? 0,
                'operation_type_id' => (int) $item['OPERTYPEID'] ?? 0,
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'next_id' => (int) $item['NEXTID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null, 
                'is_actual' => ($item['ISACTUAL'] ?? '1') == '1',
                'is_active' => ($item['ISACTIVE'] ?? '1') == '1',
            ]
        ];
    }
}
