<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Http\Livewire\Traits\InteractsWithWishlist;
use Livewire\Component;
use App\Services\Wishlist as WishlistService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Component
{
    use InteractsWithWishlist {
        refreshWishlist as baseRefreshWishlist;
    }
    use CanNotify;

    public Model $wishlist;

    public Collection $products;

    protected $listeners = [
        'refresh-wishlist' => 'refreshWishlist',
        // 'refresh-amount' => 'processAmounts',
    ];

    public function mount()
    {
        $this->wishlist = WishlistService::fetch();
        $this->products = $this->wishlist->products;
    }

    public function removeProduct($productId): void
    {
        WishlistService::remove([$productId]);

        $this->needsWishlistRefresh();
        $this->notify('warning', 'Product Removed!', 'Product has been removed from your Wishlist!');
    }

    public function clearWishlist(): void
    {
        WishlistService::empty($this->wishlist);

        $this->needsWishlistRefresh();
        $this->notify('warning', 'Wishlist Cleared!', 'All Products have been removed from your Wishlist!');
    }

    public function refreshWishlist(): void
    {
        $this->baseRefreshWishlist();
        $this->products = $this->wishlist->products;
    }

    public function render()
    {
        return view('livewire.shop.wishlist')
            ->extends('layouts.app');
    }
}
