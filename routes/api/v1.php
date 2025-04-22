<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\OrderController;


Route::prefix('v1')->group(
    function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });

        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']); 
            Route::post('/create', [OrderController::class, 'create']); // Create an order
            Route::post('/update/{order}', [OrderController::class, 'update']); 
            Route::get('/{order}', [OrderController::class, 'view']); // View an order
            Route::get('/approve/{order}', [OrderController::class, 'approve']); // Approve an order
            Route::get('/history/{order}', [OrderController::class, 'history']); // View order history
        });
    });