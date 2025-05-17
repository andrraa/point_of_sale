<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    public const CATEGORY_CUSTOMER = 0;
    public const ITEM_CATEGORY = 1;

    public const ITEM_CACHE_KEY = 'item_category_cache';
    public const CUSTOMER_CACHE_KEY = 'customer_category_cache';

    protected $table = 'tbl_categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_code',
        'category_name',
        'category_type'
    ];

    public static function getItemCategories(): Collection
    {
        return Cache::remember(
            self::ITEM_CACHE_KEY,
            now()->addHours(2),
            fn() =>
            self::where('category_type', self::ITEM_CATEGORY)
                ->select(['category_id', 'category_name'])
                ->pluck('category_name', 'category_id')
        );
    }

}
