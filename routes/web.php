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
use App\Mail\OrderConfirmed;
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
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{cart?}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/{product}', ProductController::class)->name('product');
});

Route::prefix('user')->name('user.')
    ->controller(AccountController::class)
    ->middleware(['auth'])
    ->group(function () {
    Route::get('orders', 'orders')->name('orders');
    Route::get('orders/{order}', 'orders')->name('orders.view');
    Route::get('account', Account::class)->name('account');
});

Route::get(config('shopper.system.dashboard'), function() {
    return redirect()->route('shopper.dashboard');
})->middleware(['auth']);

//!-> Test Routes
// Route::get('test/dynamic-menu', function() {
//     $menu = RyanChandler\FilamentNavigation\Facades\FilamentNavigation::get('main-menu');
//     $item = new Fluent($menu->items[array_key_last($menu->items)]);
//     dd($item->label, $item->children, $item, $item->children ? true : false);
// });
// Route::get('test/mail', function() {
//     $order = Shopper\Framework\Models\Shop\Order\Order::latest()->first();
//     return new OrderConfirmed($order, new \Illuminate\Support\Fluent());
// });
Route::get('test/shipping', function () {
    $cart = new App\Services\Cart(App\Models\Cart::find(15));
    $carrier = App\Models\Carrier::active()->first();
    $address = App\Models\Address::first();
    // Illuminate\Database\Eloquent\Builder
});

//*-> Authentication Routes
require __DIR__.'/auth.php';

Route::get('/{filamentPage}', [FilamentPageController::class, 'show'])->name('pages');
