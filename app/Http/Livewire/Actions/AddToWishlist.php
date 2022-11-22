<?php

namespace App\Http\Livewire\Actions;

use App\Models\Product;
use App\Services\Wishlist;
use Livewire\Component;

class AddToWishlist extends Component
{
    public Product $product;

    public string $buttonType = 'icon';

    public function addToWishlist()
    {
        Wishlist::add($this->product);
        $this->emit('refresh-wishlist');
    }

    public function render()
    {
        return view('livewire.actions.add-to-wishlist');
    }
}
