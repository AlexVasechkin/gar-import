<?php

namespace Database\Seeders;

use App\Models\Apartment;

class ApartmentsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_APARTMENTS_[0-9]{8}_(.*)';
        $this->xmlProperty = 'APARTMENT';
        $this->modelClassName = Apartment::class;
    }

    // <APARTMENT ID="29244" OBJECTID="1521782" OBJECTGUID="5798bf0b-5f4f-4731-91a2-440a1c6385fd" CHANGEID="4155266" NUMBER="0" APARTTYPE="2" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2017-11-14" STARTDATE="2017-11-14" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'object_id' => (int) $item['OBJECTID'] ?? 0,
                'object_guid' => (string) $item['OBJECTGUID'] ?? '',
                'change_id' => (int) $item['CHANGEID'] ?? 0,
                'number' => (int) $item['NUMBER'] ?? 0,
                'apartment_type_id' => (int) $item['APARTTYPE'] ?? 0,
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
