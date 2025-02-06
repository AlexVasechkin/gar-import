<?php

namespace App\Console\Commands;

use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class ClearIndexCommand extends Command
{
    protected $signature = 'app:index:clear {indexId}';

    protected $description = 'Command description';

    public function handle(ElasticSearchService $es)
    {
        try {
            $indexId = (int)$this->argument('indexId');
            $indexName = match ($indexId) {
                0 => $es::INDEX_ADDRESS_OBJECT_TYPES,
                1 => $es::INDEX_ADDRESS_OBJECTS,
                default => throw new RuntimeException('Index id not found')
            };
            $client = $es->getClient();
            if ($client->indices()->exists(['index' => $indexName])->asBool()) {
                $response = $client->indices()->delete(['index' => $indexName]);
                if (!in_array($response->getStatusCode(), [200, 201])) {
                    throw new RuntimeException(sprintf('%s: ', $response->getStatusCode(), $response->getBody()));
                }
            }

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
