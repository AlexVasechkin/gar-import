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

    public function addNormilization(array &$dataSet): void
    {
        if (count($dataSet) === 0) {
            return;
        }

        $max = ($dataSet[0] ?? [])['_score'];

        foreach ($dataSet as &$item) {
            $item['_score_norm'] = round(($item['_score'] ?? 0) / $max, 5);
        }
    }

    public function analyze(array $tokens): array
    {
        $addressTypes = $this->searchAddressObjectTypes($tokens);

        $addresses = $this->searchAddressObjects($tokens);

        return [
            'addressType' => count($addressTypes),
            'address' => count($addresses)
        ];
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
                $m = $this->filterByScore($score, $response['hits']['hits']);

                usort($m, function ($a, $b) {
                    return ($b['_score'] ?? 0) <=> ($a['_score'] ?? 0);
                });

                $matches[] = [
                    'token' => $token,
                    'data' => $m
                ];
            }
        }

        return array_slice($matches, 0, 10);
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
        ], 5.0);
    }

    public function searchAddressObjectTypes(array $tokens): array
    {
        return $this->searchByTokens($tokens, [
            'index' => ElasticSearchService::INDEX_ADDRESS_OBJECT_TYPES,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => [
                            'name',
                            'shortname'
                        ],
                    ],
                ],
            ],
        ], 1.0);
    }

    /**
     * Поиск составных частей адреса.
     *
     * @param array $tokens
     * @return array
     */
    public function searchCompositeAddressParts(array $tokens): array
    {
        $results = [];

        foreach ($tokens as $index => $token) {
            $addressTypeMatches = $this->searchAddressObjectTypes([$token]);

            if (empty($addressTypeMatches)) {
                continue;
            }

            $bestMatch = $this->getBestMatch($addressTypeMatches);
            if (!$bestMatch) {
                continue;
            }
            dd($bestMatch);

            $combinations = $this->generateTokenCombinations($tokens, $index);

            $addressMatches = [];
            foreach ($combinations as $combination) {
                $matches = $this->searchAddressObjects([$combination]);
                $filteredMatches = $this->filterByScore(1.0, $matches['data'] ?? []);
                if (!empty($filteredMatches)) {
                    $addressMatches[] = [
                        'combination' => $combination,
                        'matches' => $filteredMatches,
                    ];
                }
            }

            $results[] = [
                'token' => $token,
                'best_address_type_match' => $bestMatch,
                'address_matches' => $addressMatches,
            ];
        }

        return $results;
    }

    protected function getBestMatch(array $matches): ?array
    {
        if (empty($matches)) {
            return null;
        }

        usort($matches, function ($a, $b) {
            return ($b['_score'] ?? 0) <=> ($a['_score'] ?? 0);
        });

        return $matches[0];
    }

    protected function generateTokenCombinations(array $tokens, int $startIndex): array
    {
        $combinations = [];
        $maxWords = min(count($tokens) - $startIndex, 3); // Максимум 3 слова

        for ($i = 1; $i <= $maxWords; $i++) {
            $combination = implode(' ', array_slice($tokens, $startIndex + 1, $i));
            $combinations[] = $combination;
        }

        return $combinations;
    }
}
