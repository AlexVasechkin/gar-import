<?php

namespace Database\Seeders;

use App\Models\ReestrObject;

class ReestrObjectsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_STEADS_PARAMS_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'OBJECT';
        $this->modelClassName = ReestrObject::class;
    }

    // <OBJECT OBJECTID="27926807" OBJECTGUID="7b94dbc4-a6c1-4ef4-a2c3-6dcf132b52ba" CHANGEID="595690408" ISACTIVE="1" LEVELID="10" CREATEDATE="2019-07-10" UPDATEDATE="2024-05-15" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['OBJECTID']],
            [
                'object_guid' => (string) $item['OBJECTGUID'],
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'level_id' => (int) $item['LEVELID'] ?? 0,
                'create_date' => (string) $item['CREATEDATE'] ?? null,
                'update_date' => (string) $item['UPDATEDATE'] ?? null,
                'is_active' => (bool) (($item['ISACTIVE'] ?? '1') == '1'),
            ]
        ];
    }
}
