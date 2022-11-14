<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Traits\HasAmounts;
use App\Http\Livewire\Traits\InteractsWithCart;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart as CartService;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Shopper\Framework\Facades\Shopper;
use Shopper\Framework\Models\Shop\Carrier;
use Shopper\Framework\Models\Shop\Order\Order;
use Shopper\Framework\Models\Shop\Order\OrderItem;
use Shopper\Framework\Models\Shop\PaymentMethod;
use Shopper\Framework\Models\System\Country;
use Shopper\Framework\Models\User\Address;

class Checkout extends Component
{
    use HasAmounts, InteractsWithCart;

    public Cart $cart;

    public Collection $paymentMethods;

    public User $user;

    public Address $address;
    public Address $shippingAddress;

    public bool $shipToBilling = true;

    public Collection $addresses;

    public Collection $countries;

    public Collection $carriers;

    public $selectedCarrier;

    public string $password = '';

    public bool $createUser = true;

    public string $selectedPaymentMethod;

    protected $listeners = [
        'refresh-cart' => 'refreshCart',
        'refresh-amount' => 'processAmounts',
    ];

    protected function rules(): array
    {
        return [
            'address' => ['array'],
            'address.first_name' => ['required', 'alpha'],
            'address.last_name' => ['string', 'nullable'],
            'address.company_name' => ['string', 'nullable'],
            'address.country_id' => ['required', 'numeric', 'exists:system_countries,id'],
            'address.street_address' => ['required', 'string'],
            'address.street_address_plus' => ['nullable', 'string'],
            'address.city' => ['required', 'string'],
            'address.zipcode' => ['required', 'string'],
            'address.phone_number' => ['required', 'numeric'],
            'user' => ['array'],
            'user.email' => ['required_if:createUser,1'],
            'password' => ['required_if:createUser,1', Password::min(8)->numbers()->symbols()->mixedCase()],
            'selectedPaymentMethod' => ['required', 'exists:payment_methods,slug'],
            'selectedCarrier' => ['required', 'exists:carriers,slug'],
        ];
    }

    public function mount()
    {
        $this->selectUser();
        $this->processAmounts();
        $this->paymentMethods = PaymentMethod::enabled()->latest()->get();
        $this->selectedPaymentMethod = $this->paymentMethods->first()?->slug;
        $this->selectAddress();
        $this->countries = Country::all();
        $this->carriers = Carrier::where('is_enabled', true)->get();
        $this->selectedCarrier = $this->cart->shipping?->slug ?? $this->carriers->first()?->slug;
        $this->calculateShipping();
    }

    protected function selectUser(): void
    {
        if (Auth::check()) {
            $this->user = Auth::user();
            $this->createUser = false;
        } else {
            $this->user = (new User());
        }
    }

    /**
     * Select the Address
     *
     * @param int $id
     * @return void
     */
    public function selectAddress($id = null): void
    {
        $address = null;
        if (!$id) {
            if (Auth::check()) {
                $address = Auth::user()->addresses()
                    ->where('is_default', true)
                    ->where('type', Address::TYPE_BILLING)
                    ->first();
            }
        } else {
            $address = Auth::user()->addresses()
                ->where('id', $id)
                ->where('type', Address::TYPE_BILLING)
                ->first();
        }

        if (!$address) {
            $this->createNewAddress();
        } else {
            $this->address = $address;
        }
    }

    /**
     * Select the Shipping Address
     *
     * @param int $id
     * @return void
     */
    public function selectShippingAddress($id = null): void
    {
        $address = null;
        if (!$id) {
            if (Auth::check()) {
                $address = Auth::user()->addresses()
                    ->where('is_default', true)
                    ->where('type', Address::TYPE_SHIPPING)
                    ->first();
            }
        } else {
            $address = Auth::user()->addresses()
                ->where('id', $id)
                ->where('type', Address::TYPE_SHIPPING)
                ->first();
        }

        if (!$address) {
            $this->createNewShippingAddress();
        } else {
            $this->shippingAddress = $address;
        }
    }

    public function createNewAddress(): void
    {
        $this->address = (new Address);
        $this->address->type = Address::TYPE_BILLING;
    }

    public function createNewShippingAddress(): void
    {
        $this->shippingAddress = (new Address);
        $this->shippingAddress->type = Address::TYPE_SHIPPING;
    }

    public function shippingToBillingAddress(): void
    {
        $this->shippingAddress = $this->address->replicate()->fill([
            'type' => Address::TYPE_SHIPPING,
        ]);
    }

    public function selectPaymentMethod($method): void
    {
        $this->selectedPaymentMethod = $method;
    }

    public function updatedSelectedCarrier(): void
    {
        $this->calculateShipping();
    }

    public function calculateShipping(): void
    {
        CartService::shippingMethod($this->cart, $this->selectedCarrier);
        $this->processAmounts();
    }

    public function submit()
    {
        //? 1. Validate
        $this->validate();

        //? 2. Create User
        if ($this->createUser) {
            $this->user->password = Hash::make($this->password);
            $this->user->save();
        }

        //? 3. Process Addresses
        $this->address->user_id = $this->address->user_id ?? $this->user->id;
        $this->address->save();
        if ($this->shipToBilling) {
            $this->shippingToBillingAddress();
        }
        $this->shippingAddress->user_id = $this->shippingAddress->user_id ?? $this->user->id;
        $this->shippingAddress->save();

        //? 4. Process Order
        $order = $this->processOrder();

        //? 5. Clear Cart and Redirect
        CartService::empty($this->cart);
        $this->needsCartRefresh();

        return redirect()->route('shop.checkout.success', encrypt($order->number));

    }

    private function processOrder(): Order
    {
        //? 1. Create Order
        //? 2. Create Order Items & associate them to Order
        return $this->processOrderItems($this->createOrder());
    }

    private function createOrder(): Order
    {
        $paymentMethod = PaymentMethod::findBySlug($this->selectedPaymentMethod);

        $order = (new Order)->fill([
            'number' => order_number(),
            'price_amount' => $this->total * 100,
            'currency' => $this->currency,
            'shipping_total' => $this->shippingTotal,
            'shipping_method' => $this->selectedCarrier,
        ]);
        $order->customer()->associate($this->user);
        $order->paymentMethod()->associate($paymentMethod);
        $order->shippingAddress()->associate($this->shippingAddress);
        $order->save();

        return $order;
    }

    private function processOrderItems(Order $order): Order
    {
        foreach ($this->cart->products as $product) {
            $item = $this->createOrderItem($product);
            $item->order()->associate($order);
            $item->save();
        }
        return $order;
    }

    private function createOrderItem($product): OrderItem
    {
        return OrderItem::create([
            'name' => $product->name,
            'sku' => $product->sku,
            'product_type' => Product::class,
            'product_id' => $product->id,
            'quantity' => $product->pivot->quantity,
            'unit_price_amount' => $product->price_amount,
        ]);
    }

    public function render()
    {
        // $this->selectAddress();
        // dd($this->address);
        return view('livewire.shop.checkout');
    }
}
