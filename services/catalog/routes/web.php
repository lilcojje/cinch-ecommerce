<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/yagit', function () {
   Route::get('/', [ProductController::class, 'index']);
});