<?php

namespace App\Console\Commands;

use App\Jobs\IndexAddressObjectTypeJob;
use App\Models\AddressObjectType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class IndexAddressObjectTypesCommand extends Command
{
    protected $signature = 'app:address-object-type:index';

    protected $description = 'Command description';

    public function handle()
    {
        try {
            $limit = 500;
            $page = 0;
            do {
                $items = AddressObjectType::query()
                    ->select(['id'])
                    ->orderBy('id')
                    ->limit($limit)
                    ->offset($page * $limit)
                    ->pluck('id')
                    ->each(function (int $id) {
                        IndexAddressObjectTypeJob::dispatch($id);
                    });

                $page++;

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
