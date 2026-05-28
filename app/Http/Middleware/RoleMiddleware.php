<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $permissionList = null)
    {
        if ($permissionList !== null && !Auth::user()->can($permissionList)) {
            abort(403, 'You are not authorized.');
        }

        return $next($request);
    }
}
