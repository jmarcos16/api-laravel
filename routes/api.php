<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('users', [UserController::class, 'index'])->name('users.list');
Route::post('users/create', [UserController::class, 'store'])->name('users.create');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
