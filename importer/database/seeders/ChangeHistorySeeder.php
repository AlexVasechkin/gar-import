<?php

namespace Database\Seeders;

use App\Models\ChangeHistory;

class ChangeHistorySeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_CHANGE_HISTORY_[0-9]{8}_(.*)';
        $this->xmlProperty = 'ITEM';
        $this->modelClassName = ChangeHistory::class;
    }

    // <ITEM CHANGEID="90863104" OBJECTID="60856341" ADROBJECTID="d4acb1e5-f64b-413d-ac84-68980b6785ed" OPERTYPEID="20" NDOCID="17672823" CHANGEDATE="2017-12-17" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['CHANGEID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'address_object_id' => (string) $item['ADROBJECTID'] ?? '',
                'operation_type_id' => (int) $item['OPERTYPEID'] ?? 0,
                'ndoc_id' => (int) $item['NDOCID'] ?? 0,
                'change_date' => (string) $item['CHANGEDATE'] ?? null,
            ]
        ];
    }
}
