<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Shopper\Framework\Models\Shop\Order\OrderItem;
// use Shopper\Framework\Models\Shop\Product\Product;
use App\Models\Product;

class Products {

    public static function newArrivals(int $limit = 10): Collection
    {
        return Product::publish()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function featured(int $limit = 10): Collection
    {
        return Product::publish()
            ->featured()
            ->limit($limit)
            ->get();
    }

    public static function bestSellers(int $limit = 10, int $days = 15, bool $definite = true): Collection
    {
        return Cache::remember('shop.bestsellers', 24*60*60, function () use($days, $limit, $definite) {
            $orderItems = OrderItem::where('created_at', '>', now()->subDays($days))->get();
            $orderItems->filter(function($item) {
                return $item->order->isCompleted();
            });
            if ($orderItems->count() >= 1) {
                $orderItems->groupBy('product_id');
                $productIds = $orderItems->keys();
                $products = new Collection;
                $productIds->each(function ($value) use($products) {
                    $prod = Product::find($value);
                    if ($prod) {
                        $products->push($prod);
                    }
                });
                return $products->slice(0, $limit);
            } elseif ($definite) {
                $products = Product::publish()->limit($limit)->get();
                return $products;
            }

            return new Collection([]);
        });
    }
}
