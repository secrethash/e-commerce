<?php

namespace App\Http\Livewire\Traits;

use App\Services\Cart;
use Shopper\Framework\Models\Traits\HasPrice;

/**
 * Has Amounts
 */
trait HasAmounts
{
    use HasPrice;

    public int $subtotal = 0;
    public string $formattedSubtotal;

    public int $total = 0;
    public string $formattedTotal;

    public function processAmounts(): void
    {
        $this->subtotal = Cart::subtotal($this->cart);
        $this->total = Cart::total($this->cart);
        $this->formattedTotal = $this->formattedPrice($this->total);
        $this->formattedSubtotal = $this->formattedPrice($this->subtotal);
    }
}
