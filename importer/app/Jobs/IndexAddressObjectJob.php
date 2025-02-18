<?php

namespace App\Jobs;

use App\Models\AddressObject;
use App\Services\ElasticSearchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use RuntimeException;

class IndexAddressObjectJob implements ShouldQueue
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
        $addressObject = AddressObject::query()
            ->where('id', $this->id)
            ->firstOrFail()
        ;

        $client = $es->getClient();

        $params = [
            'index' => $es::INDEX_ADDRESS_OBJECTS,
            'id' => $addressObject->id,
            'body' => [
                'guid' => $addressObject->object_guid,
                'objectId' => $addressObject->object_id,
                'name' => $addressObject->name,
                'type_name' => $addressObject->type_name,
                'level' => $addressObject->level,
            ],
        ];

        $response = $client->index($params);

        if (in_array($response->getStatusCode(), [200, 201])) {
            $addressObject->index_completed_at = Carbon::now();
            $addressObject->save();
        } else {
            throw new RuntimeException(implode(PHP_EOL, [
                "Ошибка при добавлении документа с ID {$this->id}",
                $response->getStatusCode(),
                $response->getBody()->getContents()
            ]));
        }
    }
}
