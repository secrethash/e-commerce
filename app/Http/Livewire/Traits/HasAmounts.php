<?php

namespace App\Http\Livewire\Traits;

use App\Services\Cart;
use Illuminate\Support\Fluent;
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

    public int $shippingTotal = 0;
    public string $formattedShippingTotal;

    public int $taxed = 0;
    public string $formattedTaxed;

    public string $currency;

    public function processAmounts(): void
    {
        $this->currency = shopper_currency();
        $this->subtotal = Cart::subtotal($this->cart);
        $this->total = Cart::total($this->cart, $this->shippingAddress ?? null);
        $this->shippingTotal = Cart::shippingTotal($this->cart, $this->shippingAddress ?? null);
        $this->taxed = Cart::taxTotal($this->cart, $this->shippingAddress ?? null);
        $this->formattedTotal = $this->formattedPrice($this->total);
        $this->formattedSubtotal = $this->formattedPrice($this->subtotal);
        $this->formattedShippingTotal = $this->formattedPrice($this->shippingTotal);
        $this->formattedTaxed = $this->formattedPrice($this->taxed);
        $this->amountsArray = $this->getAmounts();
    }

    public function getFluentAmounts(): Fluent
    {
        return new Fluent($this->getAmounts());
    }

    public function getAmounts(): array
    {
        return [
            'subtotal' => $this->subtotal,
            'formattedSubtotal' =>$this->formattedSubtotal,
            'total' => $this->total,
            'formattedTotal' =>$this->formattedTotal,
            'shippingTotal' => $this->shippingTotal,
            'formattedShippingTotal' =>$this->formattedShippingTotal,
            'taxed' => $this->taxed,
            'formattedTaxed' => $this->formattedTaxed,
            'currency' =>$this->currency,
        ];
    }
}
