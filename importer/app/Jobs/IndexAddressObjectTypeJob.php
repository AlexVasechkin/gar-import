<?php

namespace App\Jobs;

use App\Services\ElasticSearchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use RuntimeException;

class IndexAddressObjectTypeJob implements ShouldQueue
{
    use Queueable;

    public $tries = 1;

    private array $data;

    public function __construct(string $d)
    {
        $this->data = json_decode($d, true);
        $this->onQueue('default');
    }

    public function handle(ElasticSearchService $es): void
    {
        $client = $es->getClient();

        $indexName = $es::INDEX_ADDRESS_OBJECT_TYPES;

        $params = [
            'index' => $indexName,
            'id' => $this->data['id'],
            'body' => $this->data,
        ];

        $response = $client->index($params);

        if (in_array($response->getStatusCode(), [200, 201])) {
            
        } else {
            throw new RuntimeException(implode(PHP_EOL, [
                "Ошибка при добавлении документа с ID {$this->data['id']}",
                $response->getStatusCode(),
                $response->getBody()->getContents()
            ]));
        }
    }
}
