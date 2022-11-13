<?php

namespace App\Services;

use App\Models\Cart as CartModel;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Session;
use Shopper\Framework\Models\Shop\Product\Product;

class Cart {

    public function __construct(public ?CartModel $cart = null) {}

    /**
     * Make Cart and Add to Session
     *
     * @return self
     */
    public function make(): self
    {
        if(!$this->cart) {
            $this->cart = CartModel::create([
                'user_id' => Auth::id(),
            ]);
            Session::put('current_cart', $this->cart->uuid);
        }
        return $this;
    }

    /**
     * Fetch Cart Object
     *
     * @param \App\Models\User|null $user
     * @return \App\Models\Cart
     */
    public static function fetch(?User $user = null): CartModel
    {
        $session = Session::get('current_cart');
        $cart = CartModel::whereUuid($session)->first();

        if (Auth::check() && !$user) {
            $user = Auth::user();
        }

        if ($user) {
            if (!$user->carts->first()) {
                if (!$cart) {
                    $cart = (new self())->make()->cart;
                }
                $cart->user()->associate($user);
                // $user->carts()->associate($cart);
            } elseif ($cart && $user->carts->count() >= 1 && $cart->isNot($user->carts->first())) {
                $cart->delete();
                $cart = $user->carts->first();
                Session::forget('current_cart');
                Session::put('current_cart', $cart->uuid);
            }
        }

        if (!$cart) {
            $cart = (new self())->make()->cart;
        }

        return $cart;
    }

    /**
     * Add Items to Cart
     *
     * @param \Shopper\Framework\Models\Shop\Product\Product $product
     * @param integer $quantity
     * @return boolean
     */
    public static function add(Product $product, int $quantity = 1): bool
    {
        $cart = self::fetch();

        if (self::hasItem($product, $cart)) {
            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $cart->products()->find($product->id)->pivot->quantity + 1,
            ]);
            return true;
        } else {
            $cart->products()->attach($product->id, [
                'quantity' => $quantity,
            ]);
            return true;
        }

        return false;
    }

    /**
     * Remove an Item from the cart
     *
     * @param \Shopper\Framework\Models\Shop\Product\Product|\Illuminate\Database\Eloquent\Collection|array $products
     * @param \App\Models\Cart|null $cart
     * @return boolean
     */
    public static function remove(Product|Collection|array $products, ?CartModel $cart = null): bool
    {
        $cart = $cart ?? static::fetch();

        if ($products instanceof Product) {
            $cart->products()->detach($products->id);
            return true;
        } elseif ($products instanceof Collection) {
            $cart->products()->detach($products->pluck('id'));
            return true;
        } elseif (is_array($products)) {
            $cart->products()->detach($products);
            return true;
        }

        return false;
    }

    /**
     * Empty Cart
     *
     * @param \App\Models\Cart|null $cart
     * @return boolean
     */
    public static function empty(?CartModel $cart = null): bool
    {
        $cart = $cart ?? static::fetch();
        return static::remove($cart->products);
    }

    /**
     * Checks if cart has item
     *
     * @param \Shopper\Framework\Models\Shop\Product\Product $product
     * @param \App\Models\Cart|null $cart
     * @return boolean
     */
    public static function hasItem(Product $product, ?CartModel $cart = null): bool
    {
        $cart = $cart ?? self::fetch();
        if ($cart->products()->find($product->id)) {
            return true;
        }

        return false;
    }

    public static function subtotal(CartModel $cart): int
    {
        $subtotal = 0;

        foreach ($cart->products as $product) {
            $subtotal += price_quantity($product->price_amount, $product->pivot->quantity);
        }

        return $subtotal;
    }

    public static function total(CartModel $cart): int
    {
        return static::subtotal($cart);
    }

    public static function isEmpty(CartModel $cart): bool
    {
        return $cart->products()->count() < 1;
    }

}
