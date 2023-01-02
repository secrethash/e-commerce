<?php

namespace App\Http\Livewire\Actions;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Services\Cart;
use Livewire\Component;
// use Shopper\Framework\Models\Shop\Product\Product;
use App\Models\Product;

class AddToCart extends Component
{
    use CanNotify;

    public Product $product;

    public int $quantity = 1;

    public string $buttonType = 'icon';

    public function addToCart()
    {
        Cart::add($this->product, $this->quantity);
        $this->emit('refresh-cart');
        $this->notify('success', 'Added to Cart!', 'Product has been added to your cart!');
    }

    public function render()
    {
        return view('livewire.actions.add-to-cart');
    }
}
