<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/generate-schedule', [ScheduleController::class, 'generate']);
    Route::post('/publish-schedule', [ScheduleController::class, 'publish'])->name('schedule.publish');
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    
    // Schedule Generation
    Route::get('/schedule/generate', [ScheduleController::class, 'showGenerate'])->name('schedule.generate');
    Route::post('/schedule/run', [ScheduleController::class, 'runGeneration'])->name('schedule.run');
    
    Route::resource('assignments', \App\Http\Controllers\TeachingAssignmentController::class);
    Route::resource('courses', \App\Http\Controllers\CourseController::class);
    Route::resource('rooms', \App\Http\Controllers\RoomController::class);
    Route::resource('timeslots', \App\Http\Controllers\TimeslotController::class);
    Route::resource('lecturers', \App\Http\Controllers\LecturerController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/lecturer/dashboard', [LecturerController::class, 'index'])->name('lecturer.dashboard');
    Route::post('/lecturer/preferences', [LecturerController::class, 'updatePreferences'])->name('lecturer.preferences.update');
    
    // Student Routes
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/schedule', [StudentController::class, 'schedule'])->name('student.schedule');
    Route::get('/student/replacement-schedule', [StudentController::class, 'replacementSchedule'])->name('student.replacement-schedule');
    Route::get('/student/notifications', [StudentController::class, 'notifications'])->name('student.notifications');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
