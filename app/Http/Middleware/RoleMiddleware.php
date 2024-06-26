<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class RoleMiddleware
{

    public function handle($request, Closure $next, $permissionList = null)
    {
        if ($permissionList !== null && !Auth::user()->can($permissionList)) {
            abort(404);
        }

        return $next($request);
    }
}
