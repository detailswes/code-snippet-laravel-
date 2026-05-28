<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function confirmModal(Request $request)
    {
        $validated = $request->validate([
            'body_text' => 'required|string|max:1000',
            'left_button_class' => 'nullable|string|max:100',
            'id' => 'nullable|integer',
            'left_button_id' => 'nullable|string|max:100',
            'left_button_name' => 'required|string|max:100',
        ]);

        $html = view('admin.common.confirm-modal', [
            'data' => $validated,
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}
