<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAddressJob;
use App\Models\AddressObject;
use App\Models\MunHierarchyCacheItem;
use App\Models\MunHierarchyItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

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
            $name = 'mo';

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
