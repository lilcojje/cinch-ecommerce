<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::prefix('orders')->group(function () {
    // POST /api/orders — create order
    Route::post('/', [OrderController::class, 'store']);

    // GET /api/orders/{id} — order details
    Route::get('{id}', [OrderController::class, 'show']);
});
