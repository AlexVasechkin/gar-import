<?php

namespace Database\Seeders;

use App\Models\ObjectLevel;

class ObjectLevelsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_OBJECT_LEVELS_*';
        $this->xmlProperty = 'OBJECTLEVEL';
        $this->modelClassName = ObjectLevel::class;
    }

    protected function parseData($item): array
    {
        return [
            ['level' => (int) $item['LEVEL']], 
            [
                'name' => (string) $item['NAME'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'], 
                'update_date' => (string) $item['UPDATEDATE'],
                'is_active' => (($item['ISACTIVE'] ?? 'true') == 'true'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
