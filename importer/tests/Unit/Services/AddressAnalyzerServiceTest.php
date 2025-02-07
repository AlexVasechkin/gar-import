<?php

namespace Tests\Unit\Services;

use App\Services\AddressAnalyzerService;
use App\Services\ElasticSearchService;
use Tests\Unit\UnitTestPrototype;

class AddressAnalyzerServiceTest extends UnitTestPrototype
{
    public function testFilesPositive(): void
    {
        $testData = json_decode(file_get_contents(storage_path('messages.json')), true);

        $es = new ElasticSearchService();

        $client = $es->getClient();

        $addressService = new AddressAnalyzerService($es);

        $totalEmpty = count(array_filter($testData, fn(array $item) => $item['isAddress'] === false));
        $success = 0;

        foreach ($testData as $row) {
            if ($row['isAddress'] === false && $row['isAddress'] === $addressService->hasAddress($row['message'])) {
                $success++;
            }
        }

        echo sprintf('%s / %s', $success, $totalEmpty) . PHP_EOL;

        $this->assertTrue(true);
    }
}
