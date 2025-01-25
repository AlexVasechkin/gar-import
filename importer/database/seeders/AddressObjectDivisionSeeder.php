<?php

namespace Database\Seeders;

use App\Models\AddressObjectDivision;

class AddressObjectDivisionSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_ADDR_OBJ_DIVISION_[0-9]{8}_(.*)';
        $this->xmlProperty = 'ITEM';
        $this->modelClassName = AddressObjectDivision::class;
    }

    // <ITEM ID="1" PARENTID="1811" CHILDID="1887" CHANGEID="4870" />
    protected function parseData($item): array
    {
        return [
                ['id' => (int) $item['ID']], 
                [
                    'parent_id' => (int) $item['PARENTID'],
                    'child_id' => (int) $item['CHILDID'],
                    'change_id' => (int) $item['CHANGEID'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];
    }
}
