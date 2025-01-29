<?php

namespace App\Console\Commands;

use App\Models\MunHierarchyCacheItem;
use App\Models\MunHierarchyItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class DestroyDoublesCommand extends Command
{
    protected $signature = 'app:destroy-doubles';

    protected $description = 'Command description';

    public function handle()
    {
        try {
            MunHierarchyCacheItem::query()
                ->whereNotNull('last_address_object_id')
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

                    if ($hItems->count() > 1) {
                        $hItems->shift();
                        MunHierarchyCacheItem::destroy($hItems->pluck('id')->toArray());
                    }
                });
        } catch (Throwable $e) {
            $m = implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
            echo $m . PHP_EOL;
            Log::error($m);
        }
    }
}
