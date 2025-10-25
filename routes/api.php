<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Products routes
    // Route::apiResource('products', ProductsController::class);
    // This creates:
    // GET /products - index
    // POST /products - store
    // GET /products/{product} - show
    // PUT/PATCH /products/{product} - update
    // DELETE /products/{product} - destroy
});

    Route::apiResource('products', ProductsController::class);


