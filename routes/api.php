<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//*PUBLIC ROUTES
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//*RESET PASSWORD
Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);

//! PROTECTED ROUTES

//TODO: AUTH ROUTES
Route::middleware(['auth:sanctum'])->group(function () {

    //*EMAIL VERIFICATION
    Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('signed');
    Route::get('email/resend', [EmailVerificationController::class, 'resendEmail'])->name('verification.resend');
    // Route::get('/email/verify', fn () => view('auth.verify-email')->name('verification.notice')); <-- Vista

    //*LOGOUT
    Route::get('logout', [AuthController::class, 'logout']);
});

//TODO: AUTH & EMAIL VERIFIED  ROUTES
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    //*USER
    Route::get('user', [AuthController::class, 'user']);

    //*PRODUCTS
    Route::resource('products', ProductController::class);
});
