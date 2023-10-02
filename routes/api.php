<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


// Route::get('users', [UserController::class, 'index'])->name('users.list');
// Route::post('users/create', [UserController::class, 'store'])->name('users.create');
// Route::get('users/{user}', [UserController::class, 'show'])->name('users.find');
// Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
// Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.delete');


Route::post('login', AuthenticatedSessionController::class)->name('login');

Route::apiResource('users', UserController::class);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
