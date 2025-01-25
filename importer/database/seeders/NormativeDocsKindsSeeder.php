<?php

namespace Database\Seeders;

use App\Models\NormativeDocumentKind;

class NormativeDocsKindsSeeder extends RecursiveImportSeederPrototype
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    public function __construct()
    {
        $this->mode = 'single';
        $this->filePattern = 'AS_NORMATIVE_DOCS_KINDS_*';
        $this->xmlProperty = 'NDOCKIND';
        $this->modelClassName = NormativeDocumentKind::class;
    }

    protected function parseData($item): array
    {
        return [
            ['id' => (int) $item['ID']], 
            [
                'name' => (string) $item['NAME'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
