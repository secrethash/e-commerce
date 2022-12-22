<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Http\Livewire\Traits\HasAmounts;
use App\Http\Livewire\Traits\InteractsWithCart;
use App\Mail\OrderConfirmed;
use App\Models\Cart;
use App\Models\CountryState;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart as CartService;
use App\Services\Shipping;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;
use Mail;
use Shopper\Framework\Facades\Shopper;
use App\Models\Carrier;
use Shopper\Framework\Models\Shop\Inventory\Inventory;
use Shopper\Framework\Models\Shop\Order\Order;
use Shopper\Framework\Models\Shop\Order\OrderItem;
use Shopper\Framework\Models\Shop\PaymentMethod;
use Shopper\Framework\Models\System\Country;
use App\Models\Address;
// use Shopper\Framework\Models\User\Address;

class Checkout extends Component
{
    use HasAmounts, CanNotify;
    use InteractsWithCart {
        refreshCart as baseRefreshCart;
    }

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

    protected string $storePickup = 'store-pickup';

    public Collection $locations;

    public string $password = '';

    public bool $createUser = true;
    public $createAccount = true;

    public string $selectedPaymentMethod;
    public $selectedCountry;
    public $states;

    public $store_location;

    protected $listeners = [
        'refresh-cart' => 'refreshCart',
        'refresh-amount' => 'processAmounts',
    ];

    protected $messages = [
        'user.email.required_with' => 'The :Attribute field is required when create account is active.',
        'password.required_with' => 'The :Attribute field is required when create account is active.',
        'store_location.required_if' => 'The :Attribute field is required when selected shipping method is Store Pickup.'
    ];

    protected function addressValidationAttributes($prefix = 'address'): array
    {
        return [
            "{$prefix}.first_name" => "{$prefix} First Name",
            "{$prefix}.last_name" => "{$prefix} Last Name",
            "{$prefix}.company_name" => "{$prefix} Company Name",
            "{$prefix}.country_id" => "{$prefix} Country",
            "{$prefix}.street_address" => "{$prefix} Address Line 1",
            "{$prefix}.street_address_plus" => "{$prefix} Address Line 2",
            "{$prefix}.city" => "{$prefix} City",
            "{$prefix}.zipcode" => "{$prefix} Zipcode",
            "{$prefix}.phone_number" => "{$prefix} Phone Number",
        ];
    }

    protected function validationAttributes()
    {
        return array_merge(
            $this->addressValidationAttributes(),
            $this->addressValidationAttributes('shippingAddress'),
            [
                'store_location' => 'Pickup Location',
            ]
        );
    }

    protected function addressRules($prefix = 'address', bool $required = true): array
    {
        $requiredRule = $required ? 'required' : null;
        return [
            "{$prefix}" => ['array'],
            "{$prefix}.first_name" => [$requiredRule, 'alpha'],
            "{$prefix}.last_name" => ['string', 'nullable'],
            "{$prefix}.company_name" => ['string', 'nullable'],
            "{$prefix}.country_id" => [$requiredRule, 'numeric', 'exists:system_countries,id'],
            "{$prefix}.street_address" => [$requiredRule, 'string'],
            "{$prefix}.street_address_plus" => ['nullable', 'string'],
            "{$prefix}.city" => [$requiredRule, 'string'],
            "{$prefix}.country_state_id" => ['numeric', 'nullable', 'exists:system_countries,id'],
            "{$prefix}.zipcode" => ['string'],
            "{$prefix}.phone_number" => [$requiredRule, 'numeric'],
        ];
    }

    protected function rules(): array
    {
        return array_merge(
            $this->addressRules(),
            $this->addressRules('shippingAddress', false),
            [
                'createAccount' => [],
                'user' => ['array'],
                'user.email' => ['required_with:createAccount'],
                'password' => ['required_with:createAccount', Password::min(8)->numbers()->symbols()->mixedCase()],
                'selectedPaymentMethod' => ['required', 'exists:payment_methods,slug'],
                'selectedCarrier' => ['required', 'exists:carriers,slug'],
                'store_location' => ['required_if:selectedCarrier,'.$this->storePickup],
            ]
        );
    }

    public function mount()
    {
        $this->selectUser();
        $this->paymentMethods = PaymentMethod::enabled()->latest()->get();
        $this->selectedPaymentMethod = $this->paymentMethods->first()?->slug;
        $this->selectAddress();
        $this->shippingToBillingAddress();
        // $this->processAmounts();
        $this->countries = Country::orderBy('name')->get();
        $this->selectedCountry = $this->address->country ? Country::find($this->address->country_id) : null;
        $this->locations = Inventory::where('country_id', $this->address->country?->id)->get();
        // $this->carriers = Carrier::where('is_enabled', true)->get();
        // $this->carriers = Shipping::get($this->address, (new CartService($this->cart)));
        $this->createAccount = Auth::check() ? null : true;
        $this->selectCarrier();
        $this->calculateShipping();
    }

    public function updatedAddress(): void
    {
        if ($this->address->country) {
            $this->locations = Inventory::where('country_id', $this->address->country_id)->get();
            $this->selectedCountry = Country::find($this->address->country_id);
            $states = $this->states = CountryState::where('country_id', $this->selectedCountry->id)->get();
            if ($states->count() <= 0) {
                $this->address->country_state_id = null;
            }
        }
        if ($this->shipToBilling) {
            $this->shippingToBillingAddress();
        }
        $this->carriers = Shipping::get($this->shippingAddress, (new CartService($this->cart)));
        $this->selectCarrier();
    }

    // public function updatedShippingAddress()
    // {
    //     if ($this->shipToBilling) {
    //         $this->shippingToBillingAddress();
    //     }
    // }

    protected function verifyCarrierSelection($carrier)
    {
        $this->carriers = Shipping::get($this->shippingAddress, (new CartService($this->cart)));
        if (is_string($carrier)) {
            $carrier = Carrier::whereSlug($carrier)->first();
        }

        if ($carrier && $carrier->is_store_pickup) {
            $notStorePickup = Carrier::whereIn('id', $this->carriers->pluck('id'))
                ->where('is_store_pickup', false)->first();
            $carrier = ($this->locations->count() <= 0) ? $notStorePickup : $carrier;
        }
        if ($carrier) {
            $shipping = Shipping::make($carrier, $this->shippingAddress, $this->cart);
            $this->selectedCarrier = $shipping->useable() ? $carrier->slug : $this->carriers->first()?->slug;
        } else {
            $carrier = $this->carriers->first();
            $this->selectedCarrier = $carrier?->slug;
        }
    }

    protected function selectCarrier(): void
    {
        // $this->carriers = Shipping::get($this->shippingAddress, (new CartService($this->cart)));
        $carrier = $this->cart->shipping;
        $this->verifyCarrierSelection($carrier);
        $this->calculateShipping(!$carrier?->is_store_pickup);
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
        /** @var \App\Models\Address $address */
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
            $this->states = CountryState::where('country_id', $address->country->id)->get();
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

    public function updatedSelectedCarrier($value): void
    {
        $this->verifyCarrierSelection($value);
        $this->calculateShipping();
    }

    public function calculateShipping($notify = false): void
    {
        CartService::shippingMethod($this->cart, $this->selectedCarrier);
        // $this->processAmounts();
        $this->needsCartRefresh();
        if ($notify) {
            $this->notify('info', 'Shipping Total Updated!', 'Your Shipping total has been updated.');
        }
    }

    public function refreshCart()
    {
        $this->baseRefreshCart();
        if (CartService::isEmpty($this->cart)) {
            return redirect()->route('shop.cart')->with('notice', [
                [
                    'type' => 'error',
                    'heading' => 'Cart is Empty!',
                    'message' => 'No Products in your cart. Please add some products to your cart then proceed to checkout.',
                ]
            ]);
        }
    }

    public function submit()
    {
        //? 0. Check Carrier Availability
        if ($this->carriers->count() <= 0) {
            $this->notify(
                'error',
                'No Shipping Available!',
                'There are currently no Shipping providers available at your selected address.'
            );
        }

        //? 1. Validate
        $this->validate();

        //? 2. Create User
        if ($this->createUser) {
            $this->user->first_name = $this->address->first_name;
            $this->user->last_name = $this->address->last_name;
            $this->user->password = Hash::make($this->password);
            $this->user->save();
            Auth::login($this->user);
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

        //? 5. Send Mails
        Mail::to($this->user)->send(new OrderConfirmed($order, $this->getFluentAmounts()));

        //? 6. Clear Cart
        CartService::empty($this->cart);

        //? 7. Redirect
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
        if ($this->selectedCarrier === $this->storePickup) {
            $store = Inventory::find($this->store_location);
            $order->fill([
                'notes' => $order->notes."\n Customer Pickup Selected Store: {$store->name}",
            ]);
        }
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
        $item = OrderItem::create([
            'name' => $product->name,
            'sku' => $product->sku,
            'product_type' => Product::class,
            'product_id' => $product->id,
            'quantity' => $product->pivot->quantity,
            'unit_price_amount' => $product->price_amount * 100,
        ]);

        return $item;
    }

    public function render()
    {
        // $this->selectAddress();
        // dd($this->address);
        return view('livewire.shop.checkout', [
            'storePickup' => $this->storePickup,
        ]);
    }
}
