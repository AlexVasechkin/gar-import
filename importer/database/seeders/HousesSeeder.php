<?php

namespace Database\Seeders;

use App\Models\House;

class HousesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_HOUSES_[0-9]{8}_(.*)';
        $this->xmlProperty = 'HOUSE';
        $this->modelClassName = House::class;
    }

    // <HOUSE ID="11093" OBJECTID="1472973" OBJECTGUID="6143953a-e27d-40d9-88ee-df15b09af1a4" CHANGEID="4082543" HOUSENUM="12" HOUSETYPE="2" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2016-04-01" STARTDATE="2015-02-02" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'object_guid' => (string) $item['OBJECTGUID'] ?? '',
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'house_number' => (int) $item['HOUSENUM'] ?? 0,
                'house_type_id' => (int) $item['HOUSETYPE'] ?? 0,
                'operation_type_id' => (int) $item['OPERTYPEID'] ?? 0,
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'next_id' => (int) $item['NEXTID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null,
                'is_actual' => (bool) $item['ISACTUAL'] ?? true,
                'is_active' => (bool) $item['ISACTIVE'] ?? true,
            ]
        ];
    }
}
