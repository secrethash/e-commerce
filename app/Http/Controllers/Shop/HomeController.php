<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\Products;
use Illuminate\Http\Request;
// use Shopper\Framework\Models\Shop\Product\Product;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $newArrivals = Products::newArrivals();
        $bestSellers = Products::bestSellers()->chunk(2)->all();
        $brands = Brand::enabled()->notAftermarket()->get();
        $allBrands = Brand::enabled()->get();
        $aftermarket = Brand::enabled()->aftermarket()->get();
        // $featured = Product::publish()->featured()->get();
        $featured = Products::featured();
        // $reviews

        return view('content.home.index', compact(
            'newArrivals',
            'bestSellers',
            'brands',
            'aftermarket',
            'allBrands',
            'featured',
        ));
    }
}
