<?php

namespace Database\Seeders;

use App\Models\AddressObjectType;

class AddressObjectTypesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_ADDR_OBJ_TYPES_*';
        $this->xmlProperty = 'ADDRESSOBJECTTYPE';
        $this->modelClassName = AddressObjectType::class;
    }

    protected function parseData($item): array
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
}
