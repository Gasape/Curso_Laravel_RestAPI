<?php

use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Usuarios
Route::resource('users', UserController::class)->except(['create','edit']);

// Categories
Route::resource('categories', CategoryController::class)->except(['create','edit']);

// Products
Route::resource('products', ProductController::class)->only(['index','show']);

// Buyers
Route::resource('buyers', BuyerController::class)->only(['index','show']);

// Transactions
Route::resource('transactions', TransactionController::class)->only(['index','show']);

// Sellers
Route::resource('sellers', SellerController::class)->only(['index','show']);
// Todo lo siguiente es con respecto a laravel 11 no funciona en laravel 10 

// Entrega 
// Route::resource('user', UserController::class)->only(['index','show']);
// Route::resource('user', UserController::class)->excepty(['index','show']);

/*
 * Route::middleware(['auth', 'verified'])->controller(ProfileController::class)->group(function () {
 *     Route::get('/profile', 'show')->name('profile.show'); 
 *     Route::put('/profile', 'update')->name('profile.update'); 
 * });
 *  
*/ 
