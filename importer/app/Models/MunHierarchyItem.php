<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MunHierarchyItem extends Model
{
    protected $table = 'mun_hierarchy';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'object_id',
        'parent_object_id',
        'change_id',
        'oktmo',
        'prev_id',
        'next_id',
        'update_date',
        'start_date',
        'end_date',
        'is_active',
        'path',
    ];

    // <ITEM ID="23353" OBJECTID="27798556" PARENTOBJID="390" CHANGEID="42820268" OKTMO="79703000106" PREVID="0" NEXTID="0" UPDATEDATE="1900-01-01" STARTDATE="1900-01-01" ENDDATE="2079-06-06" ISACTIVE="1" PATH="11.95230407.3.390.27798556" />
    public static function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID'] ?? 0],
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'parent_object_id' => (int) $item['PARENTOBJID'] ?? 0,
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'oktmo' => (string) $item['OKTMO'] ?? '',
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'next_id' => (int) $item['NEXTID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null,
                'is_active' => ($item['ISACTIVE'] ?? '1') == '1',
                'path' => (string) $item['PATH'] ?? '',
            ]
        ];
    }
}
