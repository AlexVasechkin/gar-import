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

    public function hasAddress(string $message): bool
    {
        if (empty($message)) {
            return false;
        }

        $m = self::matchAddressObjectTypes($message);

        if (count($m) === 0) {
            return false;
        }

        $tokens = $this->getTokens($message);

        $addresses = $this->searchAddressObjects($tokens);

        $r = [];
        foreach ($addresses as $item) {
            $r = array_merge($r, array_filter($item['data'], function(array $el) use ($m) {
                for ($i = 0; $i < count($m); $i++) {
                    if (mb_stripos(($el['_source'] ?? [])['type_name'] ?? '', $m[$i], encoding: 'UTF-8')) {
                        return true;
                    }
                }

                return false;
            }));
        }

        $r = array_values(array_unique(array_column($r, '_id')));

        return count($r) > 0;
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
        ], 4.0);
    }

    public function searchAddressObjectTypes(array $tokens): array
    {
        return $this->searchByTokens($tokens, [
            'index' => ElasticSearchService::INDEX_ADDRESS_OBJECT_TYPES,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => [
                            'name'
                        ],
                    ],
                ],
            ],
        ], 1.0);
    }

    public static function getAddressObjectTypeList(): array
    {
        return [
            'днп' => 'днп',
            'днт' => 'днт',
            'снт' => 'снт',
            'кп' => 'пос',
            'поселок' => 'п',
            'п' => 'п',
            'пос.' => 'п',
            'поселке' => 'п',
            'ул.' => 'ул',
            'улица' => 'ул',
            'улице' => 'ул',
            'дом' => 'д',
            'д' => 'д',
            'доме' => 'д',
            'шоссе' => 'ш',
            'проспект' => 'пр-кт',
            'проспекте' => 'пр-кт',
            'район' => '',
            'районе' => 'р-н',
            'микрорайон' => 'мкр',
            'г.о.' => 'г.о',
            'г. о.' => 'г.о',
            'го' => 'г.о',
            'г.о' => 'г.о',
            'городской округ' => 'г.о',
            'область' => 'обл',
            'обл' => 'обл',
            'село' => 'с',
            'селе' => 'c',
            'с.' => 'с',
            'пгт.' => 'пгт',
        ];
    }

    public static function matchAddressObjectTypes(string $subject): array
    {
        $r = [];

        foreach (array_keys(self::getAddressObjectTypeList()) as $target) {
            $pattern = sprintf('/(?i)(\s|\,){1}%s(\s){1}/', $target);
            preg_match($pattern, $subject, $matches);
            if (count($matches) > 0) {
                $q = array_values(
                    array_map(fn(string $item) => trim($item),
                        array_filter($matches,
                            function(string $val) {
                                return !empty(trim($val));
                            }
                        )
                    )
                );
                if (count($q) > 0) {
                    $r = array_merge($r, $q);
                }
            }
        }

        return array_values(
            array_unique(
                array_filter(
                    array_map(function(string $entry) {
                        return self::getAddressObjectTypeList()[$entry] ?? null;
                    }, $r),
                    fn(?string $item) => !empty($item)
                )
            )
        );
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
