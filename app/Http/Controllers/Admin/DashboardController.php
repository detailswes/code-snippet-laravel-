<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('dashboard_listing')) {
            $data = [
                'users' => Auth::user()->can('user_listing')
                    ? User::isNotSuperAdmin()->where('id', '!=', Auth::id())->count()
                    : 0,
            ];

            return view('admin.dashboard', ['data' => $data]);
        }

        abort(403, 'You are not authorized.');
    }
}
