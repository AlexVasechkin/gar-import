<?php

namespace Database\Seeders;

use App\Models\SteadParameter;

class SteadParametersSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_STEADS_PARAMS_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'PARAM';
        $this->modelClassName = SteadParameter::class;
    }

    // <PARAM ID="1339809819" OBJECTID="157075796" CHANGEID="469924894" CHANGEIDEND="0" TYPEID="8" VALUE="01:08:0202012:6" UPDATEDATE="2022-11-15" STARTDATE="2022-11-15" ENDDATE="2079-06-06" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID'] ?? 0],
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
