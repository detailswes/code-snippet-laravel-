<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateStatusRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use View;
use Auth;
use App\Filters\UserFilters;
use App\Services\Admin\UserService;
use App\DataTables\UserDataTable;

class UserController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request, UserFilters $filters)
    {

        if (Auth::user()->can('user_listing')) {
            $roles = Role::all();
            if ($request->ajax()) {
                $data = User::where('id', '!=', auth()->id())->isNotSuperAdmin()->filter($filters);
                return UserDataTable::render($data);
            }

            return view('admin.users.index', [
                'roles' => $roles,
            ]);
        }
        abort(403, 'You are not authorized.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $request->validate(['view' => 'required']);
        return response()->json([
            'success' => true,
            'html' => $this->userService->renderModalHTML($request)
        ]);
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
