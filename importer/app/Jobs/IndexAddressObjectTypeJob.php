<?php

namespace App\Jobs;

use App\Models\AddressObjectType;
use App\Services\ElasticSearchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use RuntimeException;

class IndexAddressObjectTypeJob implements ShouldQueue
{
    use Queueable;

    public $tries = 1;

    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->onQueue('default');
    }

    public function handle(ElasticSearchService $es): void
    {
        $entity = AddressObjectType::query()
            ->where('id', $this->id)
            ->firstOrFail()
        ;

        $client = $es->getClient();

        $indexName = $es::INDEX_ADDRESS_OBJECT_TYPES;

        $params = [
            'index' => $indexName,
            'id' => $entity->id,
            'body' => [
                'level' => $entity->level,
                'name' => $entity->name,
                'shortname' => $entity->shortname,
            ],
        ];

        $response = $client->index($params);

        if (in_array($response->getStatusCode(), [200, 201])) {
            
        } else {
            throw new RuntimeException(implode(PHP_EOL, [
                "Ошибка при добавлении документа с ID {$this->id}",
                $response->getStatusCode(),
                $response->getBody()->getContents()
            ]));
        }
    }
}
