<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    use SoftDeletes;

    protected $table = 'tbl_users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'full_name',
        'username',
        'password',
        'active',
        'user_role_id'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'user_role_id', 'role_id');
    }
}
