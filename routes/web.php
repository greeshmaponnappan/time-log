<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/user-register', [AuthController::class, 'registerUser'])->name('user.register');
Route::post('/user-login', [AuthController::class, 'login'])->name('user.login');

Route::middleware(['auth'])->group(
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/project-time', [TimeLogController::class, 'index'])->name('time');
        Route::post('/project-time', [TimeLogController::class, 'store'])->name('time.store');
        Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves');
        Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);
