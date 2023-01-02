<?php

namespace App\Http\Livewire\Actions;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Models\Product;
use App\Services\Wishlist;
use Livewire\Component;

class AddToWishlist extends Component
{
    use CanNotify;

    public Product $product;

    public string $buttonType = 'icon';

    public function addToWishlist()
    {
        Wishlist::add($this->product);
        $this->emit('refresh-wishlist');
        $this->notify('success', 'Added to Wishlist!', 'Product has been added to your Wishlist!');
    }

    public function render()
    {
        return view('livewire.actions.add-to-wishlist');
    }
}
