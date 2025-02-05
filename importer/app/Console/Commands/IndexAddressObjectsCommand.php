<?php

namespace App\Console\Commands;

use App\Jobs\IndexAddressObjectJob;
use App\Models\AddressObject;
use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class IndexAddressObjectsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:address-object:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $limit = 500;
            do {
                $items = AddressObject::query()
                    ->select(['id'])
                    ->where('index_sent_at', '1970-01-01 00:00:00')
                    ->limit($limit)
                    ->pluck('id')
                    ->each(function(int $id) {
                        IndexAddressObjectJob::dispatch($id);
                    });

                AddressObject::whereIn('id', $items)->update(['index_sent_at' => Carbon::now()]);

                $this->info(sprintf('mem: %s', round(memory_get_usage() / 1024 / 1024, 2)));

            } while (!$items->isEmpty());
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
