<?php

namespace App\Services;

use Elastic\Elasticsearch;

class ElasticSearchService
{
    public const INDEX_ADDRESS_OBJECTS = 'address_objects';

    protected $client;

    public function getClient(): Elasticsearch\Client
    {
        if ($this->client === null) {
            $this->client = Elasticsearch\ClientBuilder::create()
                ->setHosts(['http://localhost:9200'])
                ->setBasicAuthentication('elastic', '123456') // Добавлено имя пользователя и пароль
                ->build();
        }

        return $this->client;
    }
}
