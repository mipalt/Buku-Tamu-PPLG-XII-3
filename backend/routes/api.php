<?php

use App\Http\Controllers\Web\GuestCompanyController;
use App\Http\Controllers\Web\ParentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\GuestAlumniController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/users', [UserController::class, 'index']);
  Route::apiResource('guest-alumni', GuestAlumniController::class);
  Route::apiResource('guest-companies', GuestCompanyController::class);
  Route::apiResource('guest-parents', ParentController::class);
});
