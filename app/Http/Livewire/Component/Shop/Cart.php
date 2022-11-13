<?php

namespace App\Http\Livewire\Component\Shop;

use App\Http\Livewire\Traits\HasAmounts;
use App\Http\Livewire\Traits\InteractsWithCart;
use App\Models\Cart as CartModel;
use App\Services\Cart as CartService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Cart extends Component
{
    use HasAmounts;
    use InteractsWithCart {
        refreshCart as baseRefreshCart;
    }

    public Collection $products;

    public CartModel $cart;

    public string $for = 'desktop';
    // public string $formattedSubtotal;

    // public int $total = 0;
    // public string $formattedTotal;

    public string $currency;

    protected $listeners = [
        'refresh-cart' => 'refreshCart',
        'refresh-amount' => 'processAmounts',
    ];

    public function mount(): void
    {
        $this->cart = CartService::fetch();
        $this->products = $this->cart->products;
        $this->currency = shopper_currency();
        $this->processAmounts();
    }

    public function removeProduct($productId): void
    {
        CartService::remove([$productId]);
        $this->needsCartRefresh();
    }

    public function refreshCart(): void
    {
        $this->baseRefreshCart();
        $this->products = $this->cart->products;
    }

    public function render()
    {
        return view('livewire.component.shop.cart');
    }
}
