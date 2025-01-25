<?php

namespace Database\Seeders;

use App\Models\RoomParameter;

class RoomParametersSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_ROOMS_PARAMS_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'PARAM';
        $this->modelClassName = RoomParameter::class;
    }

    // <PARAM ID="596302727" OBJECTID="24942748" CHANGEID="38631541" CHANGEIDEND="0" TYPEID="13" VALUE="796304201010000003140031000000000" UPDATEDATE="2017-01-29" STARTDATE="2015-01-01" ENDDATE="2079-06-06" />
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
