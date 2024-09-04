<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
});

Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
Route::get('/calendar/{year}/{month}', [CalendarController::class, 'getMonthData']);


Route::get('/calendar/time', [CalendarController::class, 'getAvailableSlots'])->name('calendar.time');
Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
require __DIR__.'/auth.php';
