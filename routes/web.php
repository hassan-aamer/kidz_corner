<?php

use Illuminate\Support\Facades\Route;


Route::get('/',                     [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/services',             [App\Http\Controllers\Web\ServiceController::class, 'index'])->name('services');
Route::get('/services/details/{id}',[App\Http\Controllers\Web\ServiceController::class, 'show'])->name('services.details');
Route::get('/products',             [App\Http\Controllers\Web\ProductController::class, 'index'])->name('products');
Route::post('/products/search',      [App\Http\Controllers\Web\ProductController::class, 'indexBySearch'])->name('products.search');
Route::get('/products/{id}',        [App\Http\Controllers\Web\ProductController::class, 'indexByCategory'])->name('products.category');
Route::get('/product/details/{id}', [App\Http\Controllers\Web\ProductController::class, 'show'])->name('product.details');
Route::get('/contact',              [App\Http\Controllers\Web\ContactController::class, 'index'])->name('contact');
Route::post('/contact/store',       [App\Http\Controllers\Web\ContactController::class, 'store'])->name('contact.store');
Route::post('/subscription',        [App\Http\Controllers\Web\SubscriptionController::class, 'store'])->name('subscription');
Route::get('/cart',                 [App\Http\Controllers\Web\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}',[App\Http\Controllers\Web\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{item}', [App\Http\Controllers\Web\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{item}',[App\Http\Controllers\Web\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear',          [App\Http\Controllers\Web\CartController::class, 'clear'])->name('cart.clear');
Route::get('/order',                [App\Http\Controllers\Web\OrderController::class, 'index'])->name('order');
