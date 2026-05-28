<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateStatusRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Filters\UserFilters;
use App\Services\Admin\UserService;
use App\DataTables\UserDataTable;
use InvalidArgumentException;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request, UserFilters $filters)
    {
        if (Auth::user()->can('user_listing')) {
            $roles = Role::all();
            if ($request->ajax()) {
                $data = User::with('role')
                    ->where('id', '!=', auth()->id())
                    ->isNotSuperAdmin()
                    ->filter($filters);

                return UserDataTable::render($data);
            }

            return view('admin.users.index', [
                'roles' => $roles,
            ]);
        }

        abort(403, 'You are not authorized.');
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->save($request);

        $resAction = $request->id ? 'Updated' : 'Created';
        $flashMessageText = "User $resAction Successfully!";

        return response()->json([
            'success' => true,
            'message' => $flashMessageText,
        ]);
    }

    public function destroy($id)
    {
        if (Auth::user()->can('user_delete')) {
            $this->userService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully!',
            ]);
        }

        abort(403, 'You are not authorized.');
    }

    public function openModal(Request $request)
    {
        $request->validate(['view' => 'required|string']);

        try {
            return response()->json([
                'success' => true,
                'html' => $this->userService->renderModalHTML($request)
            ]);
        } catch (InvalidArgumentException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function updateStatus(UpdateStatusRequest $request)
    {
        $this->userService->updateStatus($request);

        return response()->json([
            'success' => true,
            'message' => 'Status Changed Successfully!',
        ]);
    }
}
