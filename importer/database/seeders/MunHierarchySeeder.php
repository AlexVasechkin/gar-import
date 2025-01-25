<?php

namespace Database\Seeders;

use App\Models\MunHierarchyItem;

class MunHierarchySeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->filePattern = 'AS_MUN_HIERARCHY_[0-9]{8}_(.*)'; // добавлено что-то еще - дополнительный комментарий
        $this->xmlProperty = 'ITEM';
        $this->modelClassName = MunHierarchyItem::class;
    }
}
