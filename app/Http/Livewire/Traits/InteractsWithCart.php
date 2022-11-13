<?php

namespace App\Http\Livewire\Traits;

use App\Services\Cart;

/**
 * Has Amounts
 */
trait InteractsWithCart
{
    use HasAmounts;

    /**
     * Starts the process to refresh all cart Components
     *
     * @return void
     */
    public function needsCartRefresh(): void
    {
        $this->refreshCart();
        $this->emit('refresh-cart');
    }

    /**
     * Refresh on-page Cart & Amounts
     *
     * @return void
     */
    public function refreshCart(): void
    {
        $this->cart = $this->cart->fresh(['products']);
        $this->processAmounts();
    }

}
