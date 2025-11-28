<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/generate-schedule', [ScheduleController::class, 'generate']);
    Route::post('/publish-schedule', [ScheduleController::class, 'publish'])->name('schedule.publish');
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    
    Route::get('/lecturer/dashboard', [LecturerController::class, 'index'])->name('lecturer.dashboard');
    Route::post('/lecturer/preferences', [LecturerController::class, 'updatePreferences'])->name('lecturer.preferences.update');
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
