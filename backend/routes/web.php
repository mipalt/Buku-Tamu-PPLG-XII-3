<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestAlumniController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/guest_alumni', [GuestAlumniController::class, 'index'])->name('guest');
Route::post('/guest_alumni', [GuestAlumniController::class, 'store'])->name('guest.store');

