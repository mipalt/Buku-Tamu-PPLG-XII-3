<?php

use App\Http\Controllers\Web\ExportDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;

Route::prefix('mobile')->group(function () {
  require __DIR__ . '/mobile.php';
});

// Kalo fungsi auth sudah berfungsi pakaikan middleware ini
// ->middleware('auth:sanctum')

Route::prefix('web')->group(function () {
  Route::get('/users', [UserController::class, 'index']);
  Route::get('/exports/guests', [ExportDataController::class, 'export']);
});


