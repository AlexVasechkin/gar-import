<?php

namespace App\Services;

use Elastic\Elasticsearch;

class ElasticSearchService
{
    public const INDEX_ADDRESS_OBJECTS = 'address_objects';
    public const INDEX_ADDRESS_OBJECT_TYPES = 'address_object_types';

    protected $client;

    public function getClient(): Elasticsearch\Client
    {
        if ($this->client === null) {
            $protocol = env('ELASTICSEARCH_PROTOCOL', 'http');
            $host = env('ELASTICSEARCH_HOST', 'localhost');
            $port = env('ELASTICSEARCH_PORT', '9200');
            $this->client = Elasticsearch\ClientBuilder::create()
                ->setHosts(["{$protocol}://{$host}:{$port}"])
                ->setBasicAuthentication(
                    env('ELASTICSEARCH_USERNAME', 'elastic'),
                    env('ELASTICSEARCH_PASSWORD', '123456')
                )
                ->build();
        }

        return $this->client;
    }
}
