<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $table = 'tbl_categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_code',
        'category_name',
        'category_parent_id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_parent_id', 'category_id');
    }
}
