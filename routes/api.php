<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Products API routes
Route::apiResource('products', ProductController::class);

// Additional product routes
Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete']);
Route::get('/products/search', [ProductController::class, 'search']);
