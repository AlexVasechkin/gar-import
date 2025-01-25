<?php

namespace Database\Seeders;

use App\Models\OperationType;

class OperationTypesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_OPERATION_TYPES_*';
        $this->xmlProperty = 'OPERATIONTYPE';
        $this->modelClassName = OperationType::class;
    }

    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'name' => (string) $item['NAME'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'], 
                'update_date' => (string) $item['UPDATEDATE'],
                'is_active' => (string) $item['ISACTIVE'] === 'true',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
