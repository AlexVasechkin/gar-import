<?php

namespace Database\Seeders;

use App\Models\AddressObjectType;

class AddressObjectTypesSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_ADDR_OBJ_TYPES_*';
        $this->xmlProperty = 'ADDRESSOBJECTTYPE';
        $this->modelClassName = AddressObjectType::class;
    }
}
