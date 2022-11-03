<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Traits\HasAmounts;
use App\Models\Cart as Model;
use App\Services\Cart as CartService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Shopper\Framework\Models\Shop\Product\Product;

class Cart extends Component
{
    use HasAmounts;

    public Model $cart;

    public Collection $products;

    public function mount()
    {
        $this->cart = CartService::fetch();
        $this->products = $this->cart->products;
        $this->processAmounts();
    }

    public function incrementQuantity($productId): void
    {
        CartService::add(Product::find($productId));
        $this->cart = $this->cart->fresh(['products']);
        $this->processAmounts();
    }

    public function decrementQuantity($productId, $current): void
    {
        $this->cart->products()->updateExistingPivot($productId, [
            'quantity' => $current - 1,
        ]);
        $this->processAmounts();
    }

    public function render()
    {
        return view('livewire.shop.cart');
    }
}
