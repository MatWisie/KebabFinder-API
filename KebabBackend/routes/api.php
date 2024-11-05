<?php

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="This is the API documentation for the admin authentication and other functionalities.",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 */

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum','admin'])->get('/users', [UserController::class, 'index']);

Route::middleware(['auth:sanctum'])->get('/first-login', [UserController::class, 'isFirstLogin']);

Route::middleware(['auth:sanctum','admin'])->delete('/delete-user/{id}', [UserController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->put('/user/change-username', [UserController::class, 'changeUsername']);

Route::middleware(['auth:sanctum'])->post('/user/change-password', [UserController::class, 'changePassword']);

Route::middleware(['auth:sanctum', 'admin'])->post('/admin/change-password-first-login', [UserController::class, 'changePasswordForFirstLogin']);
