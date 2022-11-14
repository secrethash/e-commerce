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

    public float $subtotal = 0;
    public string $formattedSubtotal;

    public float $total = 0;
    public string $formattedTotal;

    public float $shippingTotal = 0;
    public string $formattedShippingTotal;

    public string $currency;

    public function processAmounts(): void
    {
        $this->currency = shopper_currency();
        $this->subtotal = Cart::subtotal($this->cart);
        $this->total = Cart::total($this->cart);
        $this->shippingTotal = Cart::shippingTotal($this->cart);
        $this->formattedTotal = $this->formattedPrice($this->total * 100);
        $this->formattedSubtotal = $this->formattedPrice($this->subtotal * 100);
        $this->formattedShippingTotal = $this->formattedPrice($this->shippingTotal * 100);
    }
}
