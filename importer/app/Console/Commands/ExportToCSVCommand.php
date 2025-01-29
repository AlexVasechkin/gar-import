<?php

namespace App\Console\Commands;

use App\Models\MunHierarchyCacheItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExportToCSVCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-to-csv {name} {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function addToCSV(array $data, string $fileName): void
    {
        $file = fopen(storage_path($fileName), 'a');
        foreach ($data as $row) {
            fputcsv($file, $row, ';'); // Указываем кавычки для обработки
        }
        fclose($file);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $fileName = $this->argument('fileName');

            if (file_exists(storage_path($fileName))) {
                throw new \RuntimeException("Файл уже существует: $fileName");
            }
            $header = ['type_name', 'name', 'address'];
            $this->addToCSV([$header], $fileName);

            MunHierarchyCacheItem::with('lastAddressObject')
                ->chunk(50, function ($items) use ($fileName) {
                    $csvData = [];
                    foreach ($items as $item) {
                        if ($item->lastAddressObject) {
                            $csvData[] = [
                                'type_name' => $item->getLastAddressObject()?->type_name ?? '',
                                'name' => $item->getLastAddressObject()?->name ?? '',
                                'address' => $item?->address ?? '',
                            ];
                        }
                    }
                    $this->addToCSV($csvData, $fileName);
                });
        } catch (Throwable $e) {
            Log::error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
