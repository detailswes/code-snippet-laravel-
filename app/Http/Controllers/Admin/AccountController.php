<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Requests\Admin\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File as FileModel;

class AccountController extends Controller
{
    private const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif'];

    public function index()
    {
        $user = Auth::user();
        $user['original_path'] = $user->originalImagePath();

        return view('admin.account.index', [
            'user' => $user
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only(['first_name', 'last_name']));
        $user['original_path'] = $user->originalImagePath();

        $html = view('admin.account.basic-info', [
            'user' => $user ?? null,
        ])->render();

        $userDetails = [
            'full_name' => $user->full_name,
            'profile_image_path' => $user->profile_image_path,
            'original_path' => $user->originalImagePath()
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Account updated successfully',
            'html' => $html,
            'user' => $userDetails
        ]);
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $user = Auth::user();
        $folderPath = 'Admin/uploads/users';

        $base64Image = explode(';base64,', $request->image);
        if (count($base64Image) !== 2) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image data.',
            ], 422);
        }

        $explodeImage = explode('image/', $base64Image[0]);
        if (count($explodeImage) !== 2) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image format.',
            ], 422);
        }

        $imageType = strtolower($explodeImage[1]);
        if (!in_array($imageType, self::ALLOWED_IMAGE_TYPES, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported image type. Allowed types: jpg, jpeg, png, gif.',
            ], 422);
        }

        $imageBase64 = base64_decode($base64Image[1], true);
        if ($imageBase64 === false) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid base64 image data.',
            ], 422);
        }

        $imageName = Str::random(10) . time() . '_' . random_int(100, 999) . '.' . $imageType;

        if ($user->profile_image_path) {
            Storage::disk('public')->delete($user->profile_image_path);
        }

        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath, 0777, true, true);
        }

        $userIdPath = $folderPath . '/' . $user->id;
        $file = $userIdPath . '/' . $imageName;

        if (!Storage::disk('public')->exists($userIdPath)) {
            Storage::disk('public')->makeDirectory($userIdPath, 0777, true, true);
        }

        Storage::disk('public')->put($file, $imageBase64);

        $originalPath = null;
        if ($request->hasFile('original_image')) {
            $originalPath = $request->file('original_image')->store(
                $folderPath . '/' . $request->user()->id,
                'public'
            );
            if ($user->originalImagePath()) {
                Storage::disk('public')->delete($user->originalImagePath());
            }
        }

        FileModel::updateOrCreate([
            'type' => 'profile_image',
            'user_id' => Auth::id(),
        ], [
            'name' => $imageName,
            'path' => $file,
            'original_path' => $originalPath ?? $user->originalImagePath(),
            'extension' => $imageType
        ]);

        $user['original_path'] = $user->originalImagePath();

        $html = view('admin.account.picture-container', [
            'user' => $user ?? null,
        ])->render();

        $userDetails = [
            'full_name' => $user->full_name,
            'profile_image_path' => $user->profile_image_path,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Profile Photo Uploaded Successfully',
            'html' => $html,
            'user' => $userDetails
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Password Successfully Changed'
            ]);
        }

        return response()->json([
            'success' => 'false',
            'message' => 'Old password does not match!',
        ], 404);
    }
}
