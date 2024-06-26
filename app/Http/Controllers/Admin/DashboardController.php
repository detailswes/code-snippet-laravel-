<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('dashboard_listing')) {
      $data = [
        'users' => Auth::user()->can('user_listing') ? User::isNotSuperAdmin()->get()->except(Auth::id())->count() : 0,
        /* Displaying users count if the Logged in user has the permission to access users listing else 0 returns */
      ];

      return view('admin.dashboard', ['data' => $data]);
    }

    abort(403, 'You are not authorized.');
  }
}
