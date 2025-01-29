<?php

namespace Database\Seeders;

use App\Jobs\HandleFileJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

abstract class RecursiveImportSeederPrototype extends Seeder
{
    protected string $filePattern;

    protected string $xmlProperty;

    protected string $modelClassName;

    /**
     * @var string $mode Доступные значения: 'recursive', 'single'
     */
    protected string $mode = 'recursive';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataRootPath = env('APP_DATA_ROOT');

        if (!File::exists($dataRootPath)) {
            $this->command->error('Указанный путь в APP_DATA_ROOT не существует!');
            return;
        }

        $files = [];

        if ($this->mode === 'recursive') {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dataRootPath));
            foreach ($iterator as $file) {
                if (preg_match('/' . $this->filePattern . '$/', $file->getPathname())) {
                    $files[] = $file->getPathname();
                }
            }
        } else if ($this->mode === 'single') {
            $files = glob($dataRootPath . '/' . $this->filePattern);
        }

        // Проверяем, если файл не найден
        if (empty($files)) {
            return;
        }
        // $files = [$files[0]];
        foreach ($files as $fn) {
            file_put_contents(storage_path('names.txt'), $fn . PHP_EOL, FILE_APPEND);
        }

        // foreach ($files as $filePath) {
        //     HandleFileJob::dispatch($filePath, $this->modelClassName, $this->xmlProperty);
        // }
    }
}
