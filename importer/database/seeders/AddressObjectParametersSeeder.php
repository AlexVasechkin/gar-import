<?php

namespace Database\Seeders;

use App\Models\AddressObjectParameter;

class AddressObjectParametersSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_ADDR_OBJ_PARAMS_[0-9]{8}_(.*)';
        $this->xmlProperty = 'PARAM';
        $this->modelClassName = AddressObjectParameter::class;
    }

    // <PARAM ID="18138" OBJECTID="1228" CHANGEID="3194" CHANGEIDEND="0" TYPEID="15" VALUE="0006" UPDATEDATE="2014-01-05" STARTDATE="1900-01-01" ENDDATE="2079-06-06" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'],
                'change_id' => (int) $item['CHANGEID'],
                'change_id_end' => (int) $item['CHANGEIDEND'],
                'type_id' => (int) $item['TYPEID'],
                'value' => (string) $item['VALUE'],
                'update_date' => (string) $item['UPDATEDATE'],
                'start_date' => (string) $item['STARTDATE'],
                'end_date' => (string) $item['ENDDATE'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
