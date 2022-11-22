<?php

namespace App\Services;

use App\Models\Wishlist as WishlistModel;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Session;
use Shopper\Framework\Models\Shop\Carrier;
use App\Models\Product;

class Wishlist {

    public function __construct(public ?WishlistModel $wishlist = null)
    {
        $this->wishlist = $wishlist ?? Auth::user()->wishlists()->default()->first();
    }

    /**
     * Make Wishlist
     *
     * @return self
     */
    public function make(): self
    {
        if(!$this->wishlist) {
            $this->wishlist = WishlistModel::create([
                'name' => 'Save for Later',
                'user_id' => Auth::id(),
                'is_default' => true,
            ]);
        }
        return $this;
    }

    /**
     * Fetch Cart Object
     *
     * @param \App\Models\User|null $user
     * @return \App\Models\Wishlist
     */
    public static function fetch(?User $user = null): WishlistModel
    {
        $user = Auth::user();
        $wishlist = $user->wishlists()->default()->first();

        if (!$wishlist) {
            $wishlist = (new self())->make()->wishlist;
            $wishlist->user()->associate($user);
        }

        return $wishlist;
    }

    /**
     * Add Items to Cart
     *
     * @param \Shopper\Framework\Models\Shop\Product\Product $product
     * @param integer $quantity
     * @return boolean
     */
    public static function add(Product $product): bool
    {
        $wishlist = self::fetch();

        if (!self::hasItem($product, $wishlist)) {
            $wishlist->products()->attach($product->id);
            return true;
        }

        return false;
    }

    /**
     * Remove an Item from the Wishlist
     *
     * @param \Shopper\Framework\Models\Shop\Product\Product|\Illuminate\Database\Eloquent\Collection|array<int> $products
     * @param \App\Models\Wishlist|null $wishlist
     * @return boolean
     */
    public static function remove(Product|Collection|array $products, ?WishlistModel $wishlist = null): bool
    {
        $wishlist = $wishlist ?? static::fetch();

        if ($products instanceof Product) {
            $wishlist->products()->detach($products->id);
            return true;
        } elseif ($products instanceof Collection) {
            $wishlist->products()->detach($products->pluck('id'));
            return true;
        } elseif (is_array($products)) {
            $wishlist->products()->detach($products);
            return true;
        }

        return false;
    }

    /**
     * Empty Wishlist
     *
     * @param \App\Models\Wishlist|null $wishlist
     * @return boolean
     */
    public static function empty(?WishlistModel $wishlist = null): bool
    {
        $wishlist = $wishlist ?? static::fetch();
        return static::remove($wishlist->products);
    }

    /**
     * Checks if Wishlist has item
     *
     * @param \Shopper\Framework\Models\Shop\Product\Product $product
     * @param \App\Models\Wishlist|null $wishlist
     * @return boolean
     */
    public static function hasItem(Product $product, ?WishlistModel $wishlist = null): bool
    {
        $wishlist = $wishlist ?? self::fetch();
        if ($wishlist->products()->find($product->id)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if a Wishlist is Empty
     *
     * @param \App\Models\Wishlist $wishlist
     * @return boolean
     */
    public static function isEmpty(WishlistModel $wishlist): bool
    {
        return $wishlist->products()->count() < 1;
    }

}
