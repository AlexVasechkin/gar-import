<?php

namespace Database\Seeders;

use App\Models\Stead;

class SteadsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_STEADS_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'STEAD';
        $this->modelClassName = Stead::class;
    }

    // <STEAD ID="66505390" OBJECTID="158590397" OBJECTGUID="c2bba243-ac93-4662-aae3-e4534f8a7e1b" CHANGEID="499226907" NUMBER="58" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2023-04-13" STARTDATE="2023-04-13" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID'] ?? 0],
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'object_guid' => (string) $item['OBJECTGUID'],
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'number' => (int) $item['NUMBER'] ?? 0,
                'operation_type_id' => (int) $item['OPERTYPEID'] ?? 0,
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'next_id' => (int) $item['NEXTID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null,
                'is_actual' => (bool) (($item['ISACTUAL'] ?? '1') == '1'),
                'is_active' => (bool) (($item['ISACTIVE'] ?? '1') == '1'),
            ]
        ];
    }
}
