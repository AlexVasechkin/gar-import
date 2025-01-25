<?php

namespace Database\Seeders;

use App\Models\RoomType;

class RoomTypesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_ROOM_TYPES_*';
        $this->xmlProperty = 'ROOMTYPE';
        $this->modelClassName = RoomType::class;
    }

    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'name' => (string) $item['NAME'] ?: 'Не определено',
                'desc' => (string) $item['DESC'] ?: 'Не определено',
                'is_active' => (string) (($item['ISACTIVE'] ?? 'true') == 'true'),
                'start_date' => (string) $item['STARTDATE'] ?: '1900-01-01',
                'end_date' => (string) $item['ENDDATE'] ?: '2015-11-05',
                'update_date' => (string) $item['UPDATEDATE'] ?: '2011-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
