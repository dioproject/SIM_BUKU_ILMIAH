<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRole
{
    public function handle(Request $request, Closure $next, ...$userRoles)
    {
        $user = Auth::user();

        foreach ($userRoles as $role) {
            if ($user && $user->user_role === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
