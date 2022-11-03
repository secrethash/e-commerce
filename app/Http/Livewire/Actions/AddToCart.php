<?php

namespace App\Http\Livewire\Actions;

use App\Services\Cart;
use Livewire\Component;
use Shopper\Framework\Models\Shop\Product\Product;

class AddToCart extends Component
{
    public Product $product;

    public int $quantity = 1;

    public string $buttonType = 'icon';

    public function addToCart()
    {
        Cart::add($this->product, $this->quantity);
        $this->emit('refresh-cart');
    }

    public function render()
    {
        return view('livewire.actions.add-to-cart');
    }
}
