<?php

use App\Http\Controllers\web\GuestVisitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;


Route::prefix('web')->group(function () {
  Route::get('/users', [UserController::class, 'index']);
});

Route::apiResource('guest-visitors', GuestVisitorController::class);
