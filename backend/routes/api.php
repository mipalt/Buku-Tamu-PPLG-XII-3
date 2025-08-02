<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\GuestCompanyController;

Route::prefix('mobile')->group(function () {
  require __DIR__ . '/mobile.php';
});

// Kalo fungsi auth sudah berfungsi pakaikan middleware ini
// ->middleware('auth:sanctum')

Route::prefix('web')->group(function () {
  // contoh dari mipal
  Route::get('/users', [UserController::class, 'index']);

  // guest companies api
  Route::get('/companies', [GuestCompanyController::class, 'index']);
  Route::post('/companies', [GuestCompanyController::class, 'store']);
});