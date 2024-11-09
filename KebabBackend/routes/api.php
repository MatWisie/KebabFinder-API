<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/user-login', [AuthController::class, 'userLogin']);

Route::post('/admin-login', [AuthController::class, 'adminLogin']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum','admin'])->get('/users', [UserController::class, 'index']);

Route::middleware(['auth:sanctum'])->get('/first-login', [UserController::class, 'isFirstLogin']);

Route::middleware(['auth:sanctum','admin'])->delete('/delete-user/{id}', [UserController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->put('/user/change-username', [UserController::class, 'changeUsername']);

Route::middleware(['auth:sanctum'])->post('/user/change-password', [UserController::class, 'changePassword']);

Route::middleware(['auth:sanctum', 'admin'])->post('/admin/change-password-first-login', [UserController::class, 'changePasswordForFirstLogin']);
