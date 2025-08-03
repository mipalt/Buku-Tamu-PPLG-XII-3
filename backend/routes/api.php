<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Api\GuestAlumniController;

Route::prefix('mobile')->group(function () {
  require __DIR__ . '/mobile.php';
});

// Kalo fungsi auth sudah berfungsi pakaikan middleware ini
// ->middleware('auth:sanctum')

Route::prefix('web')->group(function () {
  Route::get('/users', [UserController::class, 'index']);
});
Route::get('/guest-alumni', [GuestAlumniController::class, 'index']);
Route::post('/guest-alumni', [GuestAlumniController::class, 'store']);
Route::put('/guest-alumni/{id}', [GuestAlumniController::class, 'update']);
Route::delete('/guest-alumni/{id}', [GuestAlumniController::class, 'destroy']);