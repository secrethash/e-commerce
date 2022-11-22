<?php

use App\Http\Controllers\Shop\{
    CheckoutController,
    HomeController,
    ListingController,
    ProductController,
};
use App\Http\Livewire\Shop\Wishlist;
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
    Route::get('/wishlist', Wishlist::class)->name('wishlist')->middleware(['auth']);
    // Route::get('/wishlist', [CheckoutController::class, 'wishlist'])->name('wishlist')->middleware(['auth']);
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{cart?}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/{product}', ProductController::class)->name('product');
});

//!-> Test Routes
// Route::get('test/order-success', function() {
//     return view('content.shop.order.success');
// });

//*-> Authentication Routes
require __DIR__.'/auth.php';
