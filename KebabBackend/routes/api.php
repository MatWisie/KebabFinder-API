<?php

use App\Http\Controllers\Api\KebabController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/user-login', [AuthController::class, 'userLogin']);

Route::post('/admin-login', [AuthController::class, 'adminLogin']);

Route::post('/logout-from-all', [AuthController::class, 'logoutFromAll']);

Route::middleware(['auth:sanctum'])->get('/first-login', [UserController::class, 'isFirstLogin']);

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {

    Route::get('/', [UserController::class, 'getUser']);

    Route::put('change-username', [UserController::class, 'changeUsername']);

    Route::post('change-password', [UserController::class, 'changePassword']);

    Route::prefix('Comments')->group(function () {

        Route::get('/', [CommentController::class, 'getUserComments']);

        Route::put('{comment}', [CommentController::class, 'editComment']);

        Route::delete('{comment}', [CommentController::class, 'removeComment']);
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::get('users', [UserController::class, 'index']);

    Route::delete('delete-user/{id}', [UserController::class, 'destroy']);

    Route::post('change-password-first-login', [UserController::class, 'changePasswordForFirstLogin']);
});

Route::prefix('kebabs')->group(function () {

    Route::get('{kebab}', [KebabController::class, 'show']);

    Route::get('/', [KebabController::class, 'index']);

    Route::post('{kebab}/comments', [CommentController::class, 'addComment']);

    Route::get('{kebab}/comments', [CommentController::class, 'getCommentsByKebabId']);

    Route::middleware(['auth:sanctum', 'admin'])->post('/', [KebabController::class, 'store']);

    Route::middleware(['auth:sanctum', 'admin'])->put('{kebab}', [KebabController::class, 'update']);

    Route::middleware(['auth:sanctum', 'admin'])->delete('{kebab}', [KebabController::class, 'destroy']);
});

