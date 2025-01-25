<?php

namespace Database\Seeders;

use App\Models\ApartmentType;

class ApartmentTypesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_APARTMENT_TYPES_*';
        $this->xmlProperty = 'ITEM';
        $this->modelClassName = ApartmentType::class;
    }

    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']],
            [
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
