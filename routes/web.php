<?php

use App\Http\Controllers\Shop\{
    HomeController,
    ListingController,
};
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

Route::get('/', HomeController::class)->name('home');
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', ListingController::class)->name('index');
    Route::get('/category/{category}', ListingController::class)->name('category');
    Route::get('/{product}', function(){})->name('product');
});

Route::get('test/menu', function() {
    return \App\Services\Menus::shopCategories();
});
