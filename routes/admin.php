<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Livewire\Admin\Users;
use App\Http\Livewire\Auth\Login;


Route::controller(LoginController::class)->middleware(['guest'])->group(function () {
  Route::get('/', 'showLoginForm')->name('admin.login');
  Route::post('login', 'login')->name('admin.post.login');
});

/* Forgot Password routes */
Route::controller(ForgotPasswordController::class)->middleware(['guest'])->group(function () {
  Route::get('forget-password', 'forgetPassword')->name('forget.password');
  Route::post('forget/password/request', 'forgetPasswordRequest')->name('forget.password.request');
  Route::get('reset-password/{token}', 'ResetLoginPassword')->name('ResetPassword');
  Route::post('update-password', 'changePassword')->name('change.password');
});

//USER ACCESS ALL ROUTES AFTER LOGGED IN
Route::middleware(['auth', 'account.approved'])->group(function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
  Route::resource('users', UserController::class);
  Route::resource('roles', RoleController::class);
  Route::post('open/user/modal', [UserController::class, 'openModal'])->name('open.user.modal');
  Route::post('update/user/status', [UserController::class, 'updateStatus'])->name('admin.user.update.status');
  Route::post('open/roles/modal', [RoleController::class, 'openModal'])->name('open.role.modal');
  // Account Routes
  Route::controller(AccountController::class)->prefix('account')->group(function () {
    Route::get('/', 'index')->name('admin.account');
    Route::post('update', 'updateProfile')->name('update.admin.profile');
    Route::post('password/reset', 'resetPassword')->name('reset.admin.password');
    Route::post('update/profile/image', 'updateProfileImage')->name('update.admin.profile.image');
  });

  // });

});

//COMMON CONFIRM MODAL ROUTES
Route::post('confirm-modal', [CommonController::class, 'confirmModal'])->name('admin.confirm.modal');

Route::middleware(['auth'])->group(function () {
  Route::post("logout", [LoginController::class, "logout"])->name("logout");
});
