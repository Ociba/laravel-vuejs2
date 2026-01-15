<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    // For sellers
    Route::prefix('seller')->group(function () {
        Route::get('/products/count', [ProductController::class, 'countSellerProducts']);
        Route::get('/products', [ProductController::class, 'getSellerProducts']);
    });
    
    // Products with seller_id
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/my-products', [ProductController::class, 'getMyProducts']);
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::get('/products/{product}', [ProductController::class, 'update']);
});
// Route::post('/products',[ProductController::class,'store']);
// Route::get('/products',[ProductController::class,'index']);

Route::post('/categories',[CategoryController::class,'create']);
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/categories/{id}/edit',[CategoryController::class,'edit']);
Route::put('/categories/{id}',[CategoryController::class,'update']);
Route::delete('/categories/{id}',[CategoryController::class,'destroy']);

Route::prefix('types')->group(function () {
    Route::get('/', [TypeController::class, 'index']);          // GET all types
    Route::get('/{id}/edit', [TypeController::class, 'edit']); // GET a single type for edit
    Route::post('/', [TypeController::class, 'store']);        // CREATE type
    Route::put('/{id}', [TypeController::class, 'update']);    // UPDATE type
    Route::delete('/{id}', [TypeController::class, 'destroy']); // DELETE type
});
