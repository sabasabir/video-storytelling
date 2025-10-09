<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\VideoController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard'); // or wherever you want logged-in users to go
    }
    return redirect()->route('login.form');
});



Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');



Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [VideoController::class, 'index'])->name('dashboard');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('/videos/{video}/stream', [VideoController::class, 'stream'])->name('videos.stream');
    Route::post('/videos/chunks', [VideoController::class, 'uploadChunk'])->name('videos.chunks');
    Route::post('/videos/{video}/thumbnail', [VideoController::class, 'storeThumbnail']);

    Route::match(['get', 'post'], '/change-password', [AuthController::class, 'changePassword'])->name('password.change');
});




Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
