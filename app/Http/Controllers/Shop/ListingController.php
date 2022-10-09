<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shopper\Framework\Models\Shop\Product\Category;

class ListingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($category = null)
    {
        $category = $category ? Category::findBySlug($category) : $category;
        return view('content.shop.index', compact('category'));
    }
}
