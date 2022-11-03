<?php

namespace App\Http\Livewire\Component\Shop;

use App\Http\Livewire\Traits\HasAmounts;
use App\Models\Cart as CartModel;
use App\Services\Cart as CartService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Cart extends Component
{
    use HasAmounts;

    public Collection $products;

    public CartModel $cart;

    // public int $subtotal = 0;
    // public string $formattedSubtotal;

    // public int $total = 0;
    // public string $formattedTotal;

    public string $currency;

    protected $listeners = ['refresh-cart' => 'refreshCart'];

    public function mount(): void
    {
        $this->cart = CartService::fetch();
        $this->products = $this->cart->products;
        $this->currency = shopper_currency();
        $this->processAmounts();
    }

    public function refreshCart(): void
    {
        $this->products = $this->cart->fresh()->products;
        $this->processAmounts();
    }

    public function render()
    {
        return view('livewire.component.shop.cart');
    }
}
