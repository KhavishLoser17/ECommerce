<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MakeupController;
use App\Models\Request;
// use App\Http\Controllers\TwoFactorController;




Auth::routes();


// Route::middleware('auth')->group(function () {
//     Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('two-factor.index');
//     Route::post('/two-factor', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
// });
// Route::middleware(['auth','twofactor'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

// });

// Route::middleware(['auth','twofactor'])->group(function(){
    Route::get('account-dashboard', [UserController::class, 'index'])->name('user.index');

// });


// Route::middleware(['auth','twofactor',AuthAdmin::class])->group(function(){
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');


    // Route::get('teacher', [TeacherController::class, 'teacher'])->name('admin.teacher');
    Route::post('teacher/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('teacher', [TeacherController::class, 'show'])->name('admin.teacher');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teacher/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');




    // Route::get('staff', [StaffController::class, 'staff'])->name('admin.staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('staff', [StaffController::class, 'show'])->name('admin.staff');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');


    Route::get('schedule', [ScheduleController::class, 'schedule'])->name('admin.schedule');
    Route::get('schedule', [ScheduleController::class, 'create'])->name('admin.schedule');
    Route::post('schedule/store', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/calendar/schedules', [ScheduleController::class, 'getSchedules'])->name('calendar.schedules');
    Route::get('/calendar/schedule/{id}', [ScheduleController::class, 'getSchedule'])->name('calendar.schedule');


    Route::get('faculty-attendance', [FacultyController::class, 'faculty'])->name('admin.faculty-attendance');
    Route::get('faculty-attendance', [FacultyController::class, 'index'])->name('admin.faculty-attendance');


    Route::get('event', [EventController::class, 'event'])->name('admin.event');


    Route::get('make-up-class', [MakeupController::class, 'makeup'])->name('admin.makeup');




// });

    Route::get('shop', [UserController::class, 'shop'])->name('shop');
    Route::get('details', [UserController::class, 'details'])->name('product.details');



