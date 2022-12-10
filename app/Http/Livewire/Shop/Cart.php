<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Http\Livewire\Traits\HasAmounts;
use App\Http\Livewire\Traits\InteractsWithCart;
use App\Models\Cart as Model;
use App\Services\Cart as CartService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
// use Shopper\Framework\Models\Shop\Product\Product;
use App\Models\Product;
use Shopper\Framework\Models\Shop\Carrier;

class Cart extends Component
{
    use HasAmounts, CanNotify;
    use InteractsWithCart {
        refreshCart as baseRefreshCart;
    }

    public Model $cart;

    public Collection $products;

    public Collection $carriers;

    public $selectedCarrier;

    protected $listeners = [
        'refresh-cart' => 'refreshCart',
        'refresh-amount' => 'processAmounts',
    ];

    protected $rules = [
        'selectedCarrier' => ['required', 'exists:carriers,slug'],
    ];

    public function mount()
    {
        $this->cart = CartService::fetch();
        $this->products = $this->cart->products;
        $this->processAmounts();
        $this->carriers = Carrier::where('is_enabled', true)->get();
        $this->selectedCarrier = $this->cart->shipping?->slug ?? $this->carriers->first()?->slug;
        $this->calculateShipping();
    }

    public function incrementQuantity($productId): void
    {
        CartService::add(Product::find($productId));

        $this->needsCartRefresh();
        $this->notify('success', 'Quantity Updated!', 'Product Quantity has been updated in your cart!');
    }

    public function decrementQuantity($productId, $current): void
    {
        if ($current > 1) {
            $this->cart->products()->updateExistingPivot($productId, [
                'quantity' => $current - 1,
            ]);
        } else {
            CartService::remove([$productId]);
        }

        $this->needsCartRefresh();
        $this->notify('success', 'Quantity Updated!', 'Product Quantity has been updated in your cart!');
    }

    public function removeProduct($productId): void
    {
        CartService::remove([$productId]);

        $this->needsCartRefresh();
        $this->notify('warning', 'Product Removed!', 'Product has been removed from your cart!');
    }

    public function clearCart(): void
    {
        CartService::empty($this->cart);

        $this->needsCartRefresh();
        $this->notify('warning', 'Cart Cleared!', 'All Products have been removed from your cart!');
    }

    public function refreshCart(): void
    {
        $this->baseRefreshCart();
        $this->products = $this->cart->products;
    }

    public function updatedSelectedCarrier(): void
    {
        $this->calculateShipping();
    }

    public function calculateShipping(): void
    {
        CartService::shippingMethod($this->cart, $this->selectedCarrier);
        $this->needsCartRefresh();
        $this->notify('success', 'Shipping Updated!', 'The shipping method has been updated!');
    }

    public function render()
    {
        return view('livewire.shop.cart');
    }
}
