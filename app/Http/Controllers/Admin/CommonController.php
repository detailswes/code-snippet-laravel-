<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function confirmModal(Request $request)
    {
        $html =  view('admin.common.confirm-modal', [
            'data' => $request->all(),
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}
