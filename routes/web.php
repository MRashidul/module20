<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Redirect the root URL to the products index
Route::get('/', [ProductController::class, 'index']);

// Resource route for all product-related operations
Route::resource('products', ProductController::class);
