<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;

class AddressAnalyzerService
{
    protected Client $client;

    public function __construct(ElasticSearchService $es)
    {
        $this->client = $es->getClient();
    }

    public function getTokens(string $message): array
    {
        $stopWords = [
            'в', 'на', 'у', 'с', 'от', 'до', 'из', 'по', 'за', 'к', 'о', 'об', 'про',
            'и', 'а', 'но', 'или', 'что', 'чтобы', 'если', 'при', 'под', 'над', 'между',
            'свет', 'света', 'час', 'часа', 'часов'
        ];

        $tokens = preg_split('/\s+|[.,;!?]/', $message, -1, PREG_SPLIT_NO_EMPTY);

        $filteredTokens = array_filter($tokens, function ($token) use ($stopWords) {
            $token = mb_strtolower($token);
            return !in_array($token, $stopWords);
        });

        $filteredTokens = array_values($filteredTokens);

        $pairedTokens = [];
        for ($i = 0; $i < count($filteredTokens) - 1; $i++) {
            $pairedTokens[] = $filteredTokens[$i] . ' ' . $filteredTokens[$i + 1];
        }

        return array_merge($filteredTokens, $pairedTokens);
    }

    public function analyze(string $message): int
    {
        $tokens = $this->getTokens($message);

        $matches = $this->searchAddressObjects($tokens);

        return $this->calculateScore($matches);
    }

    public function filterByScore(float $score, array $items): array
    {
        return array_filter($items, function (array $item) use ($score) {
            return ($item['_score'] ?? 0) >= $score;
        });
    }

    public function searchByTokens(array $tokens, array $params, float $score = 5.0): array
    {
        $matches = [];

        foreach ($tokens as $token) {
            $params['body']['query']['multi_match']['query'] = $token;
            $response = $this->client->search($params);
            if ($response['hits']['total']['value'] > 0) {
                $matches = array_merge($matches, $this->filterByScore($score, $response['hits']['hits']));
            }
        }

        usort($matches, function ($a, $b) {
            return ($b['_score'] ?? 0) <=> ($a['_score'] ?? 0);
        });
        return array_slice($matches, 0, 20);
    }

    public function searchAddressObjects(array $tokens): array
    {
        return $this->searchByTokens($tokens, [
            'index' => ElasticSearchService::INDEX_ADDRESS_OBJECTS,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['name'],
                    ],
                ],
            ],
        ]);
    }

    public function searchAddressObjectTypes(array $tokens): array
    {
        return $this->searchByTokens($tokens, [
            'index' => ElasticSearchService::INDEX_ADDRESS_OBJECT_TYPES,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['name', 'shortname'],
                    ],
                ],
            ],
        ], 1.0);
    }

    public function calculateScore(array $matches): int
    {
        $score = 0;

        foreach ($matches as $matchGroup) {
            foreach ($matchGroup as $match) {
                $source = $match['_source'];

                // Увеличиваем счет за каждый найденный объект
                $score += 1;

                // Дополнительные баллы за высокий уровень
                if (isset($source['level']) && $source['level'] === 1) {
                    $score += 2;
                }
            }
        }

        return $score;
    }
}
