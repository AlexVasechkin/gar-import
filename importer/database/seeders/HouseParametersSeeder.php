<?php

namespace Database\Seeders;

use App\Models\HouseParameter;

class HouseParametersSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_HOUSES_PARAMS_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'PARAM';
        $this->modelClassName = HouseParameter::class;
    }

    // <PARAM ID="1393321241" OBJECTID="158993688" CHANGEID="504212995" CHANGEIDEND="0" TYPEID="8" VALUE="01:05:2900013:26183" UPDATEDATE="2023-05-29" STARTDATE="2023-05-29" ENDDATE="2079-06-06" />
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
