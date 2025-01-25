<?php

namespace Database\Seeders;

use App\Models\Carplace;

class CarplacesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_CARPLACES_[0-9]{8}_(.*)';
        $this->xmlProperty = 'CARPLACE';
        $this->modelClassName = Carplace::class;
    }

    // <CARPLACE ID="56904" OBJECTID="99545200" OBJECTGUID="8ea90872-9026-4a58-ab77-3248f2571a0c" CHANGEID="162848915" NUMBER="1" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2020-12-10" STARTDATE="2020-12-10" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'object_guid' => (string) $item['OBJECTGUID'],
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'number' => (int) $item['NUMBER'] ?? 0,
                'operation_type_id' => (int) $item['OPERTYPEID'] ?? 0,
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'next_id' => (int) $item['NEXTID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'],
                'is_actual' => (bool) ($item['ISACTUAL'] ?? '0'),
                'is_active' => (bool) ($item['ISACTIVE'] ?? '0'),
            ]
        ];
    }
}
