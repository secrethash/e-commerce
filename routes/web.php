<?php

use App\Http\Controllers\Shop\{
    CheckoutController,
    HomeController,
    ListingController,
    ProductController,
};
use App\Http\Controllers\Shop\Payments\StripeController;
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
    Route::get('/checkout/payment/card/{order}/{token}/{payment}', [StripeController::class, 'process'])->name('checkout.payments.stripe');
    Route::get('/checkout/payment/card/capture/{order}', [StripeController::class, 'capture'])->name('checkout.payments.stripe.capture');
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
// Route::get('test/shipping', function () {
//     $cart = new \App\Services\Cart(App\Models\Cart::find(15));
//     $carrier = \App\Models\Carrier::find(2);
//     $address = \App\Models\Address::first();
//     $subtotal = $cart->subtotal($cart->cart);
//     $charge = null;
//     //
//     if (!$carrier->rule_type->freeable()) {
//         dd($carrier);
//     }
//     dump($carrier->pricing);
//     /** @var \App\Models\CarrierPricing $pricing */
//     $pricing = $carrier->pricing()->whereHasMorph(
//         'calculable',
//         [\Shopper\Framework\Models\System\Country::class],
//         function (\Illuminate\Database\Eloquent\Builder $query) use($address) {
//             $query->where('id', $address->country_id);
//         }
//     );
//     dump($pricing->get());
//     if ($pricing->count() >= 1) {
//         $pricing->where('minimum_order', '<=', $subtotal)
//             ->orWhere('maximum_order', '>=', $subtotal);
//         if ($pricing->count() >= 1) {
//             $price = $pricing->first();
//             if ($price->method === App\Models\Enums\CarrierCalculationMethod::FLAT) {
//                 $charge = $price->amount;
//             } elseif ($price->method === App\Models\Enums\CarrierCalculationMethod::PERCENTAGE) {
//                 $charge = ($price->amount * $subtotal) / 100;
//             }
//         }
//     }
//     dump($carrier, $cart, $address, $subtotal);
//     dd($charge);
// });

//*-> Authentication Routes
require __DIR__.'/auth.php';

Route::get('/{filamentPage}', [FilamentPageController::class, 'show'])->name('pages');
