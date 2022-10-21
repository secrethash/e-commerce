<?php

use App\Http\Controllers\Shop\{
    HomeController,
    ListingController,
    ProductController,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//*-> Home Routes
Route::get('/', HomeController::class)->name('home');
Route::get('/home', function() {
    return redirect()->route('home');
})->name('home.home');

//*-> Shop Routes
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', ListingController::class)->name('index');
    Route::get('/category/{category}', ListingController::class)->name('category');
    Route::get('/{product}', ProductController::class)->name('product');
});

//!-> Test Routes
Route::get('test/menu', function() {
    // return \App\Services\Menus::shopCategories();
});

//*-> Authentication Routes
require __DIR__.'/auth.php';
