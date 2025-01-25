<?php

namespace Database\Seeders;

use App\Models\Room;

class RoomsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_ROOMS_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'ROOM';
        $this->modelClassName = Room::class;
    }

    // <ROOM ID="481198" OBJECTID="45894603" OBJECTGUID="0f55f9cd-5295-46e6-89a8-0097c46e10d9" CHANGEID="152201901" NUMBER="2" ROOMTYPE="0" OPERTYPEID="30" PREVID="249089" UPDATEDATE="2020-06-18" STARTDATE="2020-06-18" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="0" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']],
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'object_guid' => (string) $item['OBJECTGUID'],
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'number' => (int) $item['NUMBER'] ?? 0,
                'room_type_id' => (int) $item['ROOMTYPE'] ?? 0,
                'operation_type_id' => (int) $item['OPERTYPEID'] ?? 0,
                'prev_id' => (int) $item['PREVID'] ?? 0,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'start_date' => (string) $item['STARTDATE'] ?? null,
                'end_date' => (string) $item['ENDDATE'] ?? null,
                'is_actual' => (bool) (($item['ISACTUAL'] ?? '1') == '1'),
                'is_active' => (bool) (($item['ISACTIVE'] ?? '1') == '1'),
            ]
        ];
    }
}
