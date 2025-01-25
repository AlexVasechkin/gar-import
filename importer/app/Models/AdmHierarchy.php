<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmHierarchy extends Model
{
    protected $table = 'adm_hierarchy';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_id',
        'parent_object_id',
        'change_id',
        'region_code',
        'area_code',
        'city_code',
        'place_code',
        'plan_code',
        'street_code',
        'prev_id',
        'next_id',
        'update_date',
        'start_date',
        'end_date',
        'is_active',
        'path',
    ];

    protected $casts = [
        'update_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // <ITEM ID="2971585" OBJECTID="33158714" PARENTOBJID="2799" CHANGEID="50569986" REGIONCODE="1" PREVID="0" NEXTID="0" UPDATEDATE="1900-01-01" STARTDATE="1900-01-01" ENDDATE="2079-06-06" ISACTIVE="1" PATH="11.2157.2397.2799.33158714" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'parent_object_id' => (int) $item['PARENTOBJID'] ?? 0,
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'region_code' => (int) $item['REGIONCODE'] ?? 0,
                'area_code' => (int) $item['AREACODE'] ?? 0,
                'city_code' => (int) $item['CITYCODE'] ?? 0,
                'place_code' => (int) $item['PLACECODE'] ?? 0,
                'plan_code' => (int) $item['PLANCODE'] ?? 0,
                'street_code' => (int) $item['STREETCODE'] ?? 0,
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'next_id' => (int) $item['NEXTID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null,
                'is_active' => (($item['ISACTIVE'] ?? '1') == '1'),
                'path' => (string) $item['PATH'] ?? '',
            ]
        ];
    }
}
