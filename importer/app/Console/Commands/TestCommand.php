<?php

namespace App\Console\Commands;

use App\Jobs\UpdateOrCreateJob;
use App\Models\MunHierarchyItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function handleFile(string $filePath)
    {
        try {
            $count = 0;
            $xmlReader = new \XMLReader();
            $xmlReader->open($filePath);
    
            while ($xmlReader->read()) {
                if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->localName == 'ITEM') {
                    $count++;
                    $item = new \SimpleXMLElement($xmlReader->readOuterXML());
                    $data = MunHierarchyItem::parseData($item);
                    UpdateOrCreateJob::dispatch(MunHierarchyItem::class, $data);
                    $this->info("Обрабатывается элемент: $count"); // Вывод процесса обработки
                }
            }
        } finally {
            $xmlReader->close();
            $this->info($filePath);
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = "/media/user/ADATA/gar/16/AS_MUN_HIERARCHY_20250120_abc7a6cc-9917-4bca-85f0-51958e106020.XML
/media/user/ADATA/gar/18/AS_MUN_HIERARCHY_20250120_a76034ae-b437-4678-9051-4d48e810a4b8.XML
/media/user/ADATA/gar/19/AS_MUN_HIERARCHY_20250120_362e312c-5ad3-4c21-8bc3-34a0c9b292b2.XML
/media/user/ADATA/gar/20/AS_MUN_HIERARCHY_20250120_c1a1ffa7-2baf-478d-92a8-23b99c9dc24b.XML
/media/user/ADATA/gar/21/AS_MUN_HIERARCHY_20250120_e00beed2-4bae-42b9-86d7-865533500bc4.XML
/media/user/ADATA/gar/22/AS_MUN_HIERARCHY_20250120_b61616d8-c5c7-4bc1-91e9-73e556c1257a.XML
/media/user/ADATA/gar/23/AS_MUN_HIERARCHY_20250120_9bafcf88-8bf4-4c47-a23d-0054b20a0b7e.XML
/media/user/ADATA/gar/24/AS_MUN_HIERARCHY_20250120_e2cac7b1-552c-461c-8cd1-a7c759ac009b.XML
/media/user/ADATA/gar/25/AS_MUN_HIERARCHY_20250120_3e277be5-757e-4a93-989b-5189c23c22a3.XML
/media/user/ADATA/gar/26/AS_MUN_HIERARCHY_20250120_d42190bc-688e-4447-9b12-6d72b1ac9619.XML
/media/user/ADATA/gar/27/AS_MUN_HIERARCHY_20250120_2e0ff2c4-b17b-45e1-9609-12ed603a31ad.XML
/media/user/ADATA/gar/28/AS_MUN_HIERARCHY_20250120_71783b9f-b821-4cf5-87fe-482781190a17.XML
/media/user/ADATA/gar/29/AS_MUN_HIERARCHY_20250120_1ad0532d-5f1b-4c29-b475-be43c62be536.XML
/media/user/ADATA/gar/30/AS_MUN_HIERARCHY_20250120_d8a9d185-cf76-4f57-becd-21ebaa0b6cf0.XML
/media/user/ADATA/gar/31/AS_MUN_HIERARCHY_20250120_e972ccfb-f409-436c-aaa6-d6375758c8a1.XML
/media/user/ADATA/gar/32/AS_MUN_HIERARCHY_20250120_96d0c9b9-0eed-44ff-af02-6d01366e82c7.XML
/media/user/ADATA/gar/33/AS_MUN_HIERARCHY_20250120_e89361b2-1431-4820-aaa5-c2b1e5b52f05.XML
/media/user/ADATA/gar/34/AS_MUN_HIERARCHY_20250120_a838af10-4f8f-4ddd-ab89-942df516349f.XML
/media/user/ADATA/gar/35/AS_MUN_HIERARCHY_20250120_0c2cdd2d-d0cf-4a3f-880a-0ee9c196f694.XML";
        $files = explode(PHP_EOL, $data);

        try {
            $id = intval($this->argument('id'));
            $fileName = $files[$id];
            $this->handleFile($fileName);

        } catch (Throwable $e) {
            Log::error(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
        }
    }
}
