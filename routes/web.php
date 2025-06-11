<?php

use App\Http\Controllers\admin\AppSettingController;
use App\Http\Controllers\admin\PatientController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'showHomePage'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile/{username}', [HomeController::class, 'showProfilePage'])->name('profile');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/getUser', [HomeController::class, 'getUser'])->name('getUser');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {
    // Dashboard route for admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.index');

    // User management routes
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('admin.users.update');

    // patient management routes
    Route::get('/patients', [PatientController::class, 'index'])->name('admin.patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('admin.patients.store');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');

    // Settings routes
    Route::get('/setting', [AppSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/setting', [AppSettingController::class, 'update'])->name('admin.settings.update');
});
