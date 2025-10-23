<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\EmailController;

Route::post('/email-user', [EmailController::class, 'sendOrderSummary']);
