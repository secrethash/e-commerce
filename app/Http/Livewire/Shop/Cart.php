<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Traits\HasAmounts;
use App\Http\Livewire\Traits\InteractsWithCart;
use App\Models\Cart as Model;
use App\Services\Cart as CartService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
// use Shopper\Framework\Models\Shop\Product\Product;
use App\Models\Product;

class Cart extends Component
{
    use HasAmounts;
    use InteractsWithCart {
        refreshCart as baseRefreshCart;
    }

    public Model $cart;

    public Collection $products;

    protected $listeners = [
        'refresh-cart' => 'refreshCart',
        'refresh-amount' => 'processAmounts',
    ];

    public function mount()
    {
        $this->cart = CartService::fetch();
        $this->products = $this->cart->products;
        $this->processAmounts();
    }

    public function incrementQuantity($productId): void
    {
        CartService::add(Product::find($productId));

        $this->needsCartRefresh();
    }

    public function decrementQuantity($productId, $current): void
    {
        if ($current > 1) {
            $this->cart->products()->updateExistingPivot($productId, [
                'quantity' => $current - 1,
            ]);
        } else {
            CartService::remove([$productId]);
        }

        $this->needsCartRefresh();
    }

    public function removeProduct($productId): void
    {
        CartService::remove([$productId]);

        $this->needsCartRefresh();
    }

    public function clearCart(): void
    {
        CartService::empty($this->cart);

        $this->needsCartRefresh();
    }

    public function refreshCart(): void
    {
        $this->baseRefreshCart();
        $this->products = $this->cart->products;
    }

    public function render()
    {
        return view('livewire.shop.cart');
    }
}
