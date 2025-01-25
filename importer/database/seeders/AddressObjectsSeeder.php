<?php

namespace Database\Seeders;

use App\Models\AddressObject;

class AddressObjectsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_ADDR_OBJ_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'OBJECT';
        $this->modelClassName = AddressObject::class;
    }
}
