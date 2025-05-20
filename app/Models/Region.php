<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Region extends Model
{
    public const REGION_CACHE = 'region_cache';
    public const REGION_DROPDOWN_CACHE = 'region_dropdown_cache';

    protected $table = 'tbl_regions';

    protected $primaryKey = 'region_id';

    protected $fillable = [
        'region_code',
        'region_name'
    ];

    public static function getRegionDropdown(): Collection
    {
        return Cache::remember(
            self::REGION_DROPDOWN_CACHE,
            now()->addHours(2),
            fn() =>
            self::query()
                ->select(['region_id', 'region_name'])
                ->pluck('region_name', 'region_id')
        );
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'supplier_region_id', 'region_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'purchase_region_id', 'region_id');
    }
}
