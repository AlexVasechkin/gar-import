<?php

namespace App\Console\Commands;

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
            MunHierarchyCacheItem::query()
                ->select(['id', 'last_address_object_id'])
                ->get()
                ->groupBy('last_address_object_id')
                ->map(function ($items) {
                    return $items->pluck('id');
                })
                ->each(function ($idList) {
                    $hItems = MunHierarchyItem::query()
                        ->whereIn('id', $idList->toArray())
                        ->orderByDesc('is_active')
                        ->orderByDesc('update_date')
                        ->get();

                    if ($hItems->count() > 0) {
                        $hItems->shift();
                        MunHierarchyCacheItem::destroy($hItems->pluck('id')->toArray());
                    }
                });
        } catch (Throwable $e) {
            Log::error(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
        }
    }
}
