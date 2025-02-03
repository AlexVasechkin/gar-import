<?php

namespace App\Console\Commands;

use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateIndicesCommand extends Command
{
    protected $signature = 'app:es:indices:create';

    protected $description = 'Command description';

    public function handle(ElasticSearchService $es)
    {
        try {
            $client = $es->getClient();

            // Индекс для address_objects
            $indexName = $es::INDEX_ADDRESS_OBJECTS;
            if (!$client->indices()->exists(['index' => $indexName])->asBool()) {
                $params = [
                    'index' => $indexName,
                    'body' => [
                        'mappings' => [
                            'properties' => [
                                'name' => ['type' => 'text'],
                                'type_name' => ['type' => 'text'],
                                'level' => ['type' => 'integer'],
                            ],
                        ],
                    ],
                ];
                $client->indices()->create($params);
            } else {
                $this->info("Index $indexName уже существует");
            }

            $indexName = 'address_object_types';
            if (!$client->indices()->exists(['index' => $indexName])->asBool()) {
                $params = [
                    'index' => $indexName,
                    'body' => [
                        'mappings' => [
                            'properties' => [
                                'name' => ['type' => 'text'],
                                'shortname' => ['type' => 'text'],
                                'level' => ['type' => 'integer'],
                            ],
                        ],
                    ],
                ];
                $client->indices()->create($params);
            } else {
                $this->info("Index $indexName уже существует");
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
