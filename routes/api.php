<?php

use App\Http\Controllers\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/calendar/services', [CalendarController::class, 'getServices'])->name('calendar.services');
Route::get('/calendar/bookedSlots', [CalendarController::class, 'getBookedSlots'])->name('calendar.booked');
