<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    public const ROLE_ADMIN = 1;
    public const ROLE_CASHIER = 2;

    protected $table = 'tbl_roles';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_name'
    ];

    public static function getRoles(): Collection
    {
        return Cache::rememberForever(
            'role_dropdown',
            fn() =>
            self::query()
                ->select(['role_id', 'role_name'])
                ->pluck('role_name', 'role_id')
        );
    }
}
