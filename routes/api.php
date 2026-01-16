<?php

use App\Http\Controllers\AdchargeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MeasureController;

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
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    //Colors Routes

    Route::post('/color', [ColorController::class, 'store']);
    Route::get('/colors', [ColorController::class, 'getColor']);
    Route::get('/color/{color}/edit', [ColorController::class, 'edit']);
    Route::put('/color/{color}', [ColorController::class, 'update']);
    Route::delete('/color/{color}', [ColorController::class, 'destroy']);
    
    //Measure Routes
    Route::post('/measure', [MeasureController::class, 'store']);
    Route::get('/measures', [MeasureController::class, 'getMeasure']);
    Route::get('/measure/{measure}/edit', [MeasureController::class, 'edit']);
    Route::put('/measure/{measure}', [MeasureController::class, 'update']);
    Route::delete('/measure/{measure}', [MeasureController::class, 'destroy']);

    //Location Routes
    Route::post('/location', [LocationController::class, 'store']);
    Route::get('/locations', [LocationController::class, 'getLocation']);
    Route::get('/location/{location}/edit', [LocationController::class, 'edit']);
    Route::put('/location/{location}', [LocationController::class, 'update']);
    Route::delete('/location/{location}', [LocationController::class, 'destroy']);

    //Adcharges Routes
    Route::post('/adcharge', [AdchargeController::class, 'store']);
    Route::get('/adcharges', [AdchargeController::class, 'getAdcharge']);
    Route::get('/adcharge/{adcharge}/edit', [AdchargeController::class, 'edit']);
    Route::put('/adcharge/{adcharge}', [AdchargeController::class, 'update']);
    Route::delete('/adcharge/{adcharge}', [AdchargeController::class, 'destroy']);

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
