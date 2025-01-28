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

            MunHierarchyCacheItem::query()
                ->where('name', $name)
                ->whereNull('address')
                ->select(['id', 'name'])
                ->chunk(50, function ($items) {
                    /** @var MunHierarchyCacheItem $item */
                    foreach ($items as $item) {
                        ProcessAddressJob::dispatch($item->id, $item->name);
                    }
                });
        } catch (Throwable $e) {
            Log::error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
