<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|──────────────────────────────────────────────────────────
|  PUBLIC API ROUTES
|──────────────────────────────────────────────────────────
*/
Route::prefix('auth')->group(function () {
    Route::post('register',          [AuthController::class, 'register']);
    Route::post('verify-otp',        [AuthController::class, 'verifyOtp']);
    Route::post('login',             [AuthController::class, 'login']);

    Route::post('forgot-password',   [AuthController::class, 'forgotPassword']);
    Route::post('verify-reset-otp',  [AuthController::class, 'verifyResetOtp']);
    Route::post('reset-password',    [AuthController::class, 'resetPassword']);
});

/*
|──────────────────────────────────────────────────────────
|  PROTECTED API ROUTES
|──────────────────────────────────────────────────────────
*/
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::post('logout',   [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::get('me',        [AuthController::class, 'me']);
});
