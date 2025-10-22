<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::prefix('products')->group(function () {
    // GET /api/products?page=&per_page=
    Route::get('/', [ProductController::class, 'index']);

    // GET /api/products/{id}
    Route::get('{id}', [ProductController::class, 'show']);
});


Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});