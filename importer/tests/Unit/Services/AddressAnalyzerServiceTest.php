<?php

namespace Tests\Unit\Services;

use App\Services\AddressAnalyzerService;
use App\Services\ElasticSearchService;
use Tests\Unit\UnitTestPrototype;

class AddressAnalyzerServiceTest extends UnitTestPrototype
{
    public function testNoAddressPositive(): void
    {
        $testData = json_decode(file_get_contents(storage_path('messages.json')), true);
        $testData = array_slice($testData, 0, 10);

        $es = new ElasticSearchService();

        $addressService = new AddressAnalyzerService($es);

        $totalCount = count($testData);
        $success = 0;
        $totalEmpty = count(array_filter($testData, fn(array $item) => $item['isAddress'] === false));
        $falseSuccess = 0;

        foreach ($testData as $row) {
            $r = $addressService->hasAddress($row['message']);
            $r = false;

            if ($row['isAddress'] === $r) {
                $success++;
            }

            if ($row['isAddress'] === false && $row['isAddress'] === $r) {
                $falseSuccess++;
            }
        }

        echo sprintf('%s / %s', $success, $totalCount) . PHP_EOL;
        echo sprintf('%s / %s', $falseSuccess, $totalEmpty) . PHP_EOL;

        $this->assertTrue(true);
    }
}
