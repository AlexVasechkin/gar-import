<?php

namespace Database\Seeders;

use App\Models\ParameterType;

class ParamTypesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_PARAM_TYPES_*';
        $this->xmlProperty = 'PARAMTYPE';
        $this->modelClassName = ParameterType::class;
    }

    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'name' => (string) $item['NAME'],
                'desc' => (string) $item['DESC'],
                'code' => (string) $item['CODE'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'], 
                'update_date' => (string) $item['UPDATEDATE'],
                'is_active' => (boolean) (($item['ISACTIVE'] ?? 'true') == 'true'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
