<?php

use App\Http\Controllers\admin\AppSettingController;
use App\Http\Controllers\admin\PatientController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use App\Http\Controllers\ProfileController;

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
    Route::get('/getPatients', [PatientController::class, 'getPatients']);
    Route::get('/patient-select', function () {
        return view('components.patient-select');
    })->name('patient.select');
    Route::post('/doctor-select', function (\Illuminate\Http\Request $request) {
        $patientId = $request->patient;
        return redirect()->route('doctor.select.index', ['patientId' => $patientId]);
    })->name('doctor.select');
    Route::get('/doctor-select', function (\Illuminate\Http\Request $request) {
        $doctors = User::where('role', 'spesialis')->get();
        return view('components.doctor-select', compact('doctors'));
    })->name('doctor.select.index');
    Route::get('/video-container', function () {
        return view('profile');
    })->name('video.container');
    Route::get('/getPatient/{id}', [PatientController::class, 'show']);
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
    Route::post('/admin/patients/{id}/toggle', [PatientController::class, 'toggle'])->name('admin.patients.toggle');
    Route::post('/admin/users/{id}/toggle', [UsersController::class, 'toggle'])->name('admin.users.toggle');
    Route::get('/account/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/account/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/consultation/{id}', [App\Http\Controllers\ConsultationController::class, 'show'])->name('consultation.show');
    Route::put('/consultation/{id}', [App\Http\Controllers\ConsultationController::class, 'update'])->name('consultation.update');
    Route::post('/consultation', [App\Http\Controllers\ConsultationController::class, 'store'])->name('consultation.store');
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
