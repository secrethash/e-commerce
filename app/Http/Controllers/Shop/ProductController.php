<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shopper\Framework\Models\Shop\Product\Product;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($product, Request $request)
    {
        $product = Product::whereSlug($product)->firstOrFail();
        return view('content.shop.product', compact('product'));
    }
}
