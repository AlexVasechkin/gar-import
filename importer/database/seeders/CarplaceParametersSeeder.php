<?php

namespace Database\Seeders;

use App\Models\CarplaceParameter;

class CarplaceParametersSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_CARPLACES_PARAMS_[0-9]{8}_(.*)';
        $this->xmlProperty = 'PARAM';
        $this->modelClassName = CarplaceParameter::class;
    }

    // <PARAM ID="1537509370" OBJECTID="164762950" CHANGEID="605331476" CHANGEIDEND="0" TYPEID="8" VALUE="01:05:2900013:35175" UPDATEDATE="2024-10-23" STARTDATE="2024-10-23" ENDDATE="2079-06-06" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'change_id_end' => (int) $item['CHANGEIDEND'] ?? 0,
                'type_id' => (int) $item['TYPEID'] ?? 0,
                'value' => (string) $item['VALUE'] ?? '',
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null,
            ]
        ];
    }
}
