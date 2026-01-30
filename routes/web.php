<?php

use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════════════════════════
// PUBLIC PAGES (No rate limiting needed)
// ═══════════════════════════════════════════════════════════════════════════
Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\Web\ProductController::class, 'index'])->name('products');
Route::get('/product/details/{id}/{title}', [App\Http\Controllers\Web\ProductController::class, 'show'])->name('product.details');
Route::get('/contact', [App\Http\Controllers\Web\ContactController::class, 'index'])->name('contact');

// ═══════════════════════════════════════════════════════════════════════════
// 🔍 SEARCH (Rate Limited: 30/minute) - MUST BE BEFORE /products/{id}
// ═══════════════════════════════════════════════════════════════════════════
Route::get('/products/search', [App\Http\Controllers\Web\ProductController::class, 'indexBySearch'])
    ->middleware('throttle:search')
    ->name('products.search');

// Category route AFTER search (because {id} catches everything)
Route::get('/products/{id}', [App\Http\Controllers\Web\ProductController::class, 'indexByCategory'])->name('products.category');

// ═══════════════════════════════════════════════════════════════════════════
// 📞 CONTACT FORM (Rate Limited: 5/hour)
// ═══════════════════════════════════════════════════════════════════════════
Route::post('/contact/store', [App\Http\Controllers\Web\ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

// ═══════════════════════════════════════════════════════════════════════════
// 📧 NEWSLETTER SUBSCRIPTION (Rate Limited: 3/hour)
// ═══════════════════════════════════════════════════════════════════════════
Route::post('/subscription', [App\Http\Controllers\Web\SubscriptionController::class, 'store'])
    ->middleware('throttle:subscription')
    ->name('subscription');

// ═══════════════════════════════════════════════════════════════════════════
// 🛒 CART OPERATIONS (Rate Limited: 60/minute)
// ═══════════════════════════════════════════════════════════════════════════
Route::get('/cart', [App\Http\Controllers\Web\CartController::class, 'index'])->name('cart.index');

Route::middleware('throttle:cart')->group(function () {
    Route::post('/cart/add/{productId}', [App\Http\Controllers\Web\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{item}', [App\Http\Controllers\Web\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [App\Http\Controllers\Web\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [App\Http\Controllers\Web\CartController::class, 'clear'])->name('cart.clear');
});

// ═══════════════════════════════════════════════════════════════════════════
// 📦 ORDER OPERATIONS (Rate Limited: 5/minute for checkout)
// ═══════════════════════════════════════════════════════════════════════════
Route::get('/order', [App\Http\Controllers\Web\OrderController::class, 'index'])->name('order');
Route::get('/get-city-shipping', [App\Http\Controllers\Web\OrderController::class, 'getShipping'])->name('getCityShipping');
Route::get('/get-areas/{city}', [App\Http\Controllers\Web\OrderController::class, 'getAreas']);
Route::get('/thanks/{orderId}', [App\Http\Controllers\Web\OrderController::class, 'thanks'])->name('thanks');

Route::post('/order/store', [App\Http\Controllers\Web\OrderController::class, 'storeOrder'])
    ->middleware('throttle:order')
    ->name('order.checkout');

// ═══════════════════════════════════════════════════════════════════════════
// 📊 META CAPI (External service)
// ═══════════════════════════════════════════════════════════════════════════
Route::post('/meta-capi', [App\Http\Controllers\MetaCapiController::class, 'handle']);