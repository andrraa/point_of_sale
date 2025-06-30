<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->user_role_id !== Role::ROLE_ADMIN) {
            abort(403, 'Kamu tidak memiliki akses ke halaman ini!.');
        }

        return $next($request);
    }
}
