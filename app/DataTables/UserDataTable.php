<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use DataTables;

class UserDataTable
{
    public static function render($data)
    {
        return DataTables::of($data)
          ->addIndexColumn()
          ->addColumn('roles', function (User $user) {
            return $user->role->name;
          })->addColumn('created_at', function ($data) {
            return $data->created_at->format('Y-m-d');
          })
          ->addColumn('status','admin.common.toggle-button')
          ->addColumn('action', function (User $model) {
            return view('admin.common.actions', ['model' => $model, 'iconTitle' => 'User','prefix' => 'user']);
          })
          ->rawColumns(['action', 'status'])
          ->make(true);
    }
}
