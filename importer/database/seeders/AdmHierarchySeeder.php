<?php

namespace Database\Seeders;

use App\Models\AdmHierarchy;

class AdmHierarchySeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_ADM_HIERARCHY_[0-9]{8}_(.*)';
        $this->xmlProperty = 'ITEM';
        $this->modelClassName = AdmHierarchy::class;
    }
}
