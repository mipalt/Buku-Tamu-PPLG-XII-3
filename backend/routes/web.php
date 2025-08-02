<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestAlumniController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/guest-alumni', [GuestAlumniController::class, 'index'])->name('guest');
Route::post('/guest-alumni', [GuestAlumniController::class, 'store'])->name('guest-alumni.store');