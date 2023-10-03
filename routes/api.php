<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LogoutSessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('login', AuthenticatedSessionController::class)->name('login');
Route::post('logout', LogoutSessionController::class)->name('logout');
Route::apiResource('users', UserController::class);
