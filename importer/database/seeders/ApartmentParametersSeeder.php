<?php

namespace Database\Seeders;

use App\Models\ApartmentParameter;

class ApartmentParametersSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_APARTMENTS_PARAMS_[0-9]{8}_(.*)';
        $this->xmlProperty = 'PARAM';
        $this->modelClassName = ApartmentParameter::class;
    }

    // <PARAM ID="613499604" OBJECTID="77962285" CHANGEID="115909470" CHANGEIDEND="0" TYPEID="13" VALUE="797010000010000018440577000000000" UPDATEDATE="2019-07-19" STARTDATE="2017-04-05" ENDDATE="2079-06-06" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'change_id_end' => (int) $item['CHANGEIDEND'] ?? 0,
                'type_id' => (int) $item['TYPEID'] ?? 0,
                'value' => (string) $item['VALUE'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'],
            ]
        ];
    }
}
