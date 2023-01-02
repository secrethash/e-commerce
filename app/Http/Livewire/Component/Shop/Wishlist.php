<?php

namespace App\Http\Livewire\Component\Shop;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Http\Livewire\Traits\InteractsWithWishlist;
use App\Models\Wishlist as WishlistModel;
use App\Services\Wishlist as WishlistService;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Component
{
    use CanNotify;
    use InteractsWithWishlist {
        refreshWishlist as baseRefreshWishlist;
    }

    public Collection $products;

    public WishlistModel $wishlist;

    public string $for = 'desktop';

    public string $currency;

    protected $listeners = [
        'refresh-wishlist' => 'refreshWishlist',
        // 'refresh-amount' => 'processAmounts',
    ];

    public function mount(): void
    {
        $auth = Auth::check();
        $this->wishlist = $auth ? WishlistService::fetch() : new WishlistModel;
        $this->products = $this->wishlist->products;
        $this->currency = shopper_currency();
        // $this->processAmounts();
    }

    public function removeProduct($productId): void
    {
        WishlistService::remove([$productId]);
        $this->needsWishlistRefresh();
        $this->notify('warning', 'Product Removed!', 'Product has been removed from your Wishlist!');
    }

    public function refreshWishlist(): void
    {
        $this->baseRefreshWishlist();
        $this->products = $this->wishlist->products;
    }

    public function render()
    {
        return view('livewire.component.shop.wishlist');
    }
}
