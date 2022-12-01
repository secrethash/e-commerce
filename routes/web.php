<?php

use App\Http\Controllers\Shop\{
    CheckoutController,
    HomeController,
    ListingController,
    ProductController,
};
use App\Http\Controllers\User\AccountController;
use App\Http\Livewire\Shop\Wishlist;
use App\Http\Livewire\User\Account;
use Beier\FilamentPages\Http\Controllers\FilamentPageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Fluent;

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

Route::prefix('user')->name('user.')
    ->controller(AccountController::class)
    ->middleware(['auth'])
    ->group(function () {
    Route::get('orders', 'orders')->name('orders');
    Route::get('account', Account::class)->name('account');
});

//!-> Test Routes
// Route::get('test/dynamic-menu', function() {
//     $menu = RyanChandler\FilamentNavigation\Facades\FilamentNavigation::get('main-menu');
//     $item = new Fluent($menu->items[array_key_last($menu->items)]);
//     dd($item->label, $item->children, $item, $item->children ? true : false);
// });

//*-> Authentication Routes
require __DIR__.'/auth.php';

Route::get('/{filamentPage}', [FilamentPageController::class, 'show']);
