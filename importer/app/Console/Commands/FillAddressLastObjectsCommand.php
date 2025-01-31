<?php

namespace App\Console\Commands;

use App\Jobs\FillAddressLastObjectJob;
use App\Models\MunHierarchyCacheItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class FillAddressLastObjectsCommand extends Command
{
    protected $signature = 'app:address:last-object:fill {name}';

    protected $description = 'Command description';

    public function handle()
    {
        try {
            $name = $this->argument('name');

            $idList = MunHierarchyCacheItem::query()
                ->where('name', $name)
                ->whereNull('last_address_object_id')
                ->select(['id'])
                ->pluck('id')
                ->toArray()
            ;

            foreach ($idList as $id) {
                FillAddressLastObjectJob::dispatch($id, $name);
            }

        } catch (Throwable $e) {
            Log::error(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
        }
    }
}
