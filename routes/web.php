<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::middleware('auth')->group(function () {
    Route::post('/follow/{Id}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{Id}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/{id}/edit', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/report', [ReportController::class, "showReportForm"])->name('report');
    Route::post('/report', [ReportController::class, 'storeReport'])->name('report.store');

    Route::get('/mycars', [CarController::class, 'index'])->name('mycars');
    Route::get('/mycars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/mycars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/mycars/{id}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/mycars/{id}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/mycars/{id}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::get('/car-details/{id}', [CarController::class, 'show'])->name('car-details');

    Route::get('/chat', [ChatController::class, 'myChats'])->name('chat.my');
    Route::get('/chat/{userId}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');
    Route::delete('/chat/delete/{id}', [ChatController::class, 'destroy'])->name('chat.delete');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');
