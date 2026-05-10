<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|──────────────────────────────────────────────────────────
|  ADMIN AUTH ROUTES
|──────────────────────────────────────────────────────────
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login',  [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('dashboard',       [DashboardController::class, 'index'])->name('dashboard');
        Route::get('users',           [DashboardController::class, 'users'])->name('users');
        Route::delete('users/{user}', [DashboardController::class, 'deleteUser'])->name('users.delete');

        // Mail Settings
        Route::get('mail-settings', [\App\Http\Controllers\Admin\MailSettingController::class, 'index'])->name('mail-settings');
        Route::post('mail-settings', [\App\Http\Controllers\Admin\MailSettingController::class, 'update'])->name('mail-settings.update');
    });

});

// Redirect /admin to dashboard
Route::get('/admin', fn() => redirect()->route('admin.dashboard'));
