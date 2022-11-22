<?php

namespace App\Http\Livewire\Traits;

/**
 * Has Amounts
 */
trait InteractsWithWishlist
{

    /**
     * Starts the process to refresh all wishlist Components
     *
     * @return void
     */
    public function needsWishlistRefresh(): void
    {
        $this->refreshWishlist();
        $this->emit('refresh-wishlist');
    }

    /**
     * Refresh on-page Wishlist & Amounts
     *
     * @return void
     */
    public function refreshWishlist(): void
    {
        $this->wishlist = $this->wishlist->fresh(['products']);
    }

}
