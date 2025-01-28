<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class MunHierarchyCacheItem extends Model
{
    protected $table = 'mun_hierarchy_cache';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'address',
        'last_address_object_id'
    ];

    public function munHierarchyItem(): BelongsTo
    {
        return $this->belongsTo(MunHierarchyItem::class, 'id', 'id');
    }

    public function getMunHierarchyItem(): ?MunHierarchyItem
    {
        return $this->munHierarchyItem;
    }

    public function lastAddressObject(): BelongsTo
    {
        return $this->belongsTo(AddressObject::class, 'last_address_object_id', 'id');
    }

    public function getLastAddressObject(): ?AddressObject
    {
        return $this->lastAddressObject;
    }
}
