<?php

use App\Http\Controllers\Shop\{
    CheckoutController,
    HomeController,
    ListingController,
    ProductController,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//*-> Home Routes
Route::get('/', HomeController::class)->name('home');
Route::get('/home', function() {
    return redirect()->route('home');
})->name('home.home');

//*-> Shop Routes
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', ListingController::class)->name('index');
    Route::get('/category/{category}', ListingController::class)->name('category');
    Route::get('/cart', [CheckoutController::class, 'cart'])->name('cart');
    Route::get('/checkout/{cart?}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/{product}', ProductController::class)->name('product');
});

//!-> Test Routes
Route::get('test/menu', function() {
    // return \App\Services\Menus::shopCategories();
});

//*-> Authentication Routes
require __DIR__.'/auth.php';
