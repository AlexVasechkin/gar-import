<?php

namespace App\Jobs;

use App\Models\AddressObject;
use App\Models\MunHierarchyCacheItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;
use Illuminate\Support\Facades\Log;

class ProcessAddressJob implements ShouldQueue
{
    use Queueable;

    private int $id;

    private string $name;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->onQueue('address');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var MunHierarchyCacheItem $ca */
        $ca = MunHierarchyCacheItem::with("munHierarchyItem")
            ->where('id', $this->id)
            ->where('name', $this->name)
            ->firstOrFail()
        ;

        $e = $ca->getMunHierarchyItem();

        $pc = $e->getPathComponents();

        $ao = AddressObject::query()
            ->whereIn('object_id', array_map(fn(string $item) => intval($item), $pc))
            ->get()
            ->keyBy('object_id')
        ;

        $parts = array_filter(array_map(function ($id) use ($ao) {
            /** @var AddressObject|null $address */
            $address = $ao->get($id);
            return $address ? trim(($address->type_name ?? '') . ' ' . ($address->name ?? '')) : null;
        }, $pc));

        $ca->address = implode(', ', $parts);
        $ca->save();
    }

    public function failed(Throwable $e): void
    {
        Log::error(implode(PHP_EOL, [
            $e->getMessage(),
            $e->getTraceAsString()
        ]));
    }
}
