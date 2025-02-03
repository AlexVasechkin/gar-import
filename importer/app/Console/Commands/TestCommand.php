<?php

namespace App\Console\Commands;

use App\Jobs\IndexAddressObjectJob;
use App\Jobs\UpdateOrCreateJob;
use App\Models\MunHierarchyItem;
use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestCommand extends Command
{
    protected $signature = 'app:test';

    protected $description = 'Command description';

    private function handleFile(string $filePath)
    {
        try {
            $count = 0;
            $hits = 0;
            $xmlReader = new \XMLReader();
            $xmlReader->open($filePath);
            $this->info("Start $filePath");
    
            while ($xmlReader->read()) {
                if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->localName == 'ITEM') {
                    $count++;
                    $item = new \SimpleXMLElement($xmlReader->readOuterXML());
                    $data = MunHierarchyItem::parseData($item);
                    $payload = $data[1] ?? [];
                    $path = $payload['path'] ?? '';
                    if (preg_match('/^(807356\.|1405113\.)/', $path)) {
                        $hits++;
                        UpdateOrCreateJob::dispatch(MunHierarchyItem::class, $data);
                    }
                    $this->info("Обработан элемент: $count"); // Вывод процесса обработки
                }
            }
            if ($hits > 0) {
                $this->info("$hits|$filePath");
            }
        } finally {
            $xmlReader->close();
        }
    }

    public function handle(ElasticSearchService $es)
    {
        $data = "/media/user/ADATA/gar/40/AS_MUN_HIERARCHY_20250120_c512ff6e-2162-4f2a-a14b-acd3cb19f1d7.XML
/media/user/ADATA/gar/50/AS_MUN_HIERARCHY_20250120_39100bc0-3d10-4e42-a8ce-81e99d425157.XML
/media/user/ADATA/gar/77/AS_MUN_HIERARCHY_20250120_5370938b-8048-4f26-a7db-0e4b1703af65.XML";
        $files = explode(PHP_EOL, $data);

        try {
            // $client = $es->getClient();
            // dd($client->info());
            $j = new IndexAddressObjectJob(1);
            $j->handle($es);
            // $id = intval($this->argument('id'));
            // $fileName = $files[$id];
            // $this->handleFile($fileName);

        } catch (Throwable $e) {
            $m = implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
            echo $m;
            Log::error(PHP_EOL, $m);
        }
    }
}
