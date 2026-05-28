<?php

namespace App\Providers;

use App\Models\PermissionList;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            if (!Schema::hasTable('permission_lists')) {
                return;
            }

            $permissionLists = Cache::remember('permission_list', 3600, function () {
                return PermissionList::all();
            });

            if ($permissionLists->isEmpty()) {
                Cache::forget('permission_list');

                return;
            }

            $permissionLists->each(function ($permissionList) {
                Gate::define($permissionList->slug, function ($user) use ($permissionList) {
                    return $user->hasPermissionTo($permissionList, $user);
                });
            });
        } catch (\Exception $e) {
            report($e);
        }

        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole([$role]);
        });
    }
}
