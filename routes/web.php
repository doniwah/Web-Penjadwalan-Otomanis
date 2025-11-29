<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ReplacementScheduleController;
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
    
    // Replacement Schedules (Admin)
    Route::get('/replacement-schedules', [ReplacementScheduleController::class, 'adminIndex'])->name('admin.replacement-schedules.index');
    Route::post('/replacement-schedules/{replacement}/approve', [ReplacementScheduleController::class, 'approve'])->name('admin.replacement-schedules.approve');
    Route::post('/replacement-schedules/{replacement}/reject', [ReplacementScheduleController::class, 'reject'])->name('admin.replacement-schedules.reject');
});

Route::middleware('auth')->group(function () {
    // Dosen Routes
    Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
    Route::get('/dosen/schedule', [DosenController::class, 'schedule'])->name('dosen.schedule');
    Route::get('/dosen/notifications', [DosenController::class, 'notifications'])->name('dosen.notifications');
    
    // Replacement Schedule (Dosen)
    Route::get('/dosen/replacement-schedule', [ReplacementScheduleController::class, 'index'])->name('dosen.replacement-schedule');
    Route::get('/dosen/replacement-schedule/create', [ReplacementScheduleController::class, 'create'])->name('dosen.replacement-schedule.create');
    Route::post('/dosen/replacement-schedule', [ReplacementScheduleController::class, 'store'])->name('dosen.replacement-schedule.store');
    
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
