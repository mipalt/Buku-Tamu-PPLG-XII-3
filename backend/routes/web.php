<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestAlumniController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/guest-alumni', [GuestAlumniController::class, 'index'])->name('guest-alumni.index');
