<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->get('/users', [UserController::class, 'index']);

Route::middleware(['auth:sanctum'])->get('/first-login', [UserController::class, 'isFirstLogin']);

Route::middleware(['auth:sanctum','admin'])->delete('/delete-user', [UserController::class, 'destroy']);
