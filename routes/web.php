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
    Route::post('/services', [ServiceController::class, 'store'])->name(name: 'service.store');
    Route::get('/appointments', [CalendarController::class, 'index'])->name('appointment.index');

    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointment.store');

});

Route::get('/appointment', [AppointmentController::class, 'index'])->name('calendar.index');
Route::get('/calendar/{year}/{month}', [CalendarController::class, 'getMonthData']);


Route::get('/getAvailableSlots', [CalendarController::class, 'getAvailableSlots'])->name('appointments.available');


Route::get('/calendar/time', [CalendarController::class, 'getAvailableSlots'])->name('calendar.time');

require __DIR__.'/auth.php';
