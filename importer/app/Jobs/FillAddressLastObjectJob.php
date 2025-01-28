<?php

namespace App\Jobs;

use App\Models\AddressObject;
use App\Models\MunHierarchyCacheItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class FillAddressLastObjectJob implements ShouldQueue
{
    use Queueable;

    private int $id;

    private string $name;

    private ?int $addressObjectId = null;

    public $tries = 2;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->onQueue('address');
    }

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

        if (count($pc) > 0) {
            foreach (array_reverse($pc) as $component) {
                $this->addressObjectId = $component;

                $address = AddressObject::query()
                    ->where('object_id', $this->addressObjectId)
                    ->orderByDesc('update_date')
                    ->first();

                if (!is_null($address)) {
                    $ca->last_address_object_id = intval($address->id);
                    $ca->save();
                    break;
                }
            }
        }
    }

    public function failed(Throwable $e): void
    {
        Log::error(implode(PHP_EOL, [
            sprintf('%s', $this->addressObjectId)
            // $e->getMessage(),
            // $e->getTraceAsString()
        ]));
    }
}
