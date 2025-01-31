<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAddressJob;
use App\Models\MunHierarchyCacheItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessAddressesCommand extends Command
{
    protected $signature = 'app:addresses:fill {name}';

    protected $description = 'Command to fill addresses';

    public function handle()
    {
        try {
            $name = $this->argument('name');

            $page = 0;
            do {
                $items = MunHierarchyCacheItem::query()
                    ->where('name', $name)
                    ->whereNull('address')
                    ->select(['id'])
                    ->limit(500)
                    ->offset($page * 500)
                    ->get();

                /** @var MunHierarchyCacheItem $item */
                foreach ($items as $item) {
                    ProcessAddressJob::dispatch($item->id, $name);
                }

                $page++;
            } while (!$items->isEmpty());
        } catch (Throwable $e) {
            Log::error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
