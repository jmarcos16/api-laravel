<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('users', [UserController::class, 'index'])->name('users.list');
Route::post('users/create', [UserController::class, 'store'])->name('users.create');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.find');
Route::put('users/{user}/update', [UserController::class, 'update'])->name('users.update');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
