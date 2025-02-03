<?php

namespace App\Console\Commands;

use App\Jobs\IndexAddressObjectJob;
use App\Models\AddressObject;
use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class IndexAddressObjectsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:address-object:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ElasticSearchService $es)
    {
        try {
            $indexName = 'address_objects';
            $client = $es->getClient();

            // Проверяем, существует ли индекс
            if (!$client->indices()->exists(['index' => $indexName])->asBool()) {
                echo "Индекс '$indexName' не существует. Создайте его.\n";
                return;
            }

            $page = 0;
            do {
                $items = AddressObject::query()
                    ->select(['id'])
                    ->limit(500)
                    ->offset($page * 500)
                    ->get();

                /** @var AddressObject $item */
                foreach ($items as $item) {
                    IndexAddressObjectJob::dispatch($item->id);
                }

                $page++;

                $this->info(sprintf('mem: %s', round(memory_get_usage() / 1024 / 1024, 2)));

            } while (!$items->isEmpty());
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
