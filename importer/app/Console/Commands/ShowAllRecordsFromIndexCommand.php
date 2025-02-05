<?php

namespace App\Console\Commands;

use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ShowAllRecordsFromIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:index:scroll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ElasticSearchService $es)
    {
        try {
            $client = $es->getClient();

            $index = $es::INDEX_ADDRESS_OBJECT_TYPES;
            
            // Получаем общее количество документов в индексе
            $countResponse = $client->count(['index' => $index]);
            $totalDocuments = $countResponse['count'];
            
            // Если документов нет, завершаем выполнение
            if ($totalDocuments === 0) {
                echo "В индексе нет записей.";
                return;
            }
            
            $size = 1000;
            
            $response = $client->search([
                'index' => $index,
                'body' => [
                    'query' => [
                        'match_all' => (object)[]
                    ],
                    'size' => $size, // Количество записей на странице
                ],
            ]);
            
            // Извлекаем записи из ответа
            $hits = $response['hits']['hits'];
            $totalHits = $response['hits']['total']['value'];
            
            echo "Найдено записей: $totalHits\n";
            
            // Если записей больше, чем размер страницы, используем scroll API
            if ($totalHits > $size) {
                $scrollId = $response['_scroll_id'];
                $allHits = $hits;
            
                while (true) {
                    // Продолжаем скроллинг
                    $scrollResponse = $client->scroll([
                        'scroll_id' => $scrollId,
                        'scroll' => '1m', // Время жизни скролла
                    ]);
            
                    $scrollHits = $scrollResponse['hits']['hits'];
                    if (empty($scrollHits)) {
                        break; // Больше нет записей
                    }
            
                    $allHits = array_merge($allHits, $scrollHits);
                    $scrollId = $scrollResponse['_scroll_id'];
                }
            
                // Теперь $allHits содержит все записи
                foreach ($allHits as $hit) {
                    echo print_r($hit['_source']) . PHP_EOL;
                }
            } else {
                // Если записей меньше или равно размеру страницы
                foreach ($hits as $hit) {
                    echo print_r($hit['_source']) . PHP_EOL;
                }
            }
        } catch (Throwable $e) {
            $m = implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
            echo $m;
            Log::error(PHP_EOL, $m);
        }
    }
}
