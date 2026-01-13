<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/products',[ProductController::class,'store']);
Route::get('/products',[ProductController::class,'index']);

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
