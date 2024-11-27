<?php

use App\Http\Controllers\Api\KebabController;
use App\Http\Controllers\Api\MeatTypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/user-login', [AuthController::class, 'userLogin']);

Route::post('/admin-login', [AuthController::class, 'adminLogin']);

Route::post('/logout-from-all', [AuthController::class, 'logoutFromAll']);

Route::prefix('user')->group(function () {

    Route::middleware(['auth:sanctum'])->get('/', [UserController::class, 'getUser']);

    Route::middleware(['auth:sanctum'])->get('first-login', [UserController::class, 'isFirstLogin']);

    Route::middleware(['auth:sanctum'])->put('change-username', [UserController::class, 'changeUsername']);

    Route::middleware(['auth:sanctum'])->post('change-password', [UserController::class, 'changePassword']);
});

Route::prefix('admin')->group(function () {

    Route::middleware(['auth:sanctum', 'admin'])->get('users', [UserController::class, 'index']);

    Route::middleware(['auth:sanctum', 'admin'])->delete('delete-user/{id}', [UserController::class, 'destroy']);

    Route::middleware(['auth:sanctum', 'admin'])->post('change-password-first-login', [UserController::class, 'changePasswordForFirstLogin']);
});

Route::prefix('kebabs')->group(function () {

    Route::get('{kebab}', [KebabController::class, 'show']);

    Route::get('/', [KebabController::class, 'index']);

    Route::middleware(['auth:sanctum', 'admin'])->post('/', [KebabController::class, 'store']);

    Route::middleware(['auth:sanctum', 'admin'])->put('{kebab}', [KebabController::class, 'update']);

    Route::middleware(['auth:sanctum', 'admin'])->delete('{kebab}', [KebabController::class, 'destroy']);
});

Route::prefix('meattypes')->group(function () {
    Route::get('/', [MeatTypeController::class, 'index']);

    Route::middleware(['auth:sanctum', 'admin'])->post('/', [MeatTypeController::class, 'store']);

    Route::middleware(['auth:sanctum', 'admin'])->put('{kebab}', [MeatTypeController::class, 'update']);

    Route::middleware(['auth:sanctum', 'admin'])->delete('{kebab}', [MeatTypeController::class, 'destroy']);
});

