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
// use Shopper\Framework\Models\Shop\Order\Order;
use App\Models\Order;
use Shopper\Framework\Models\Shop\Order\OrderItem;
use Shopper\Framework\Models\Shop\PaymentMethod;
use App\Models\Country;
use App\Models\Address;
use App\Models\Tax;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

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
    public Collection $taxes;

    /** @var null|\App\Models\Carrier $selectedCarrier */
    public $selectedCarrier; // model data
    /** @var null|string $carrierSelected */
    public $carrierSelected; // form data

    public $stripeClientSecret;

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
        'user.email.required_with' => 'The :Attribute field is required.',
        'user.email.unique' => 'This :Attribute is already registered with us. Please Login to your account and try again.',
        'password.required_if' => 'The :Attribute field is required when create account is active.',
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
                'carrierSelected' => 'Shipping Method',
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
            "{$prefix}.zipcode" => ['string', 'nullable'],
            "{$prefix}.phone_number" => [$requiredRule, 'numeric'],
        ];
    }

    protected function shippingAddressRules(): array
    {
        return [
            "shippingAddress" => ['array'],
            "shippingAddress.first_name" => [],
            "shippingAddress.last_name" => [],
            "shippingAddress.company_name" => [],
            "shippingAddress.country_id" => [],
            "shippingAddress.street_address" => [],
            "shippingAddress.street_address_plus" => [],
            "shippingAddress.city" => [],
            "shippingAddress.country_state_id" => [],
            "shippingAddress.zipcode" => [],
            "shippingAddress.phone_number" => [],
        ];
    }

    protected function rules(): array
    {
        $userEmailUnique = null;
        $selectedCarrier = $this->selectedCarrier;

        if (!auth()->check()) {
            $userEmailUnique = 'unique:users,email,'.auth()->user()?->email;
        }
        return array_merge(
            $this->addressRules(),
            // $this->addressRules('shippingAddress', false),
            $this->shippingAddressRules(),
            [
                'createAccount' => [],
                'user' => ['array'],
                'user.email' => ['required_with:createAccount', $userEmailUnique],
                'password' => ['required_if:createAccount,true', Password::min(8)->numbers()->symbols()->mixedCase()],
                'selectedPaymentMethod' => ['required', 'exists:payment_methods,slug'],
                'carrierSelected' => ['required', 'exists:carriers,slug'],
                // 'store_location' => ['required_if:selectedCarrier,'.$this->storePickup],
                'store_location' => [Rule::requiredIf(function() use($selectedCarrier) {
                    return $selectedCarrier?->is_store_pickup ? true : false;
                })],
            ]
        );
    }

    public function mount()
    {
        $this->selectUser();
        $this->paymentMethods = PaymentMethod::enabled()->get();
        $this->selectedPaymentMethod = $this->paymentMethods->first()?->slug;
        $this->selectAddress();
        $this->shippingToBillingAddress();
        // $this->processAmounts();
        $this->countries = Country::active()->orderBy('name')->get();
        $this->selectedCountry = Country::find($this->address->country_id) ?? Country::active()->first();
        $this->locations = Inventory::where('country_id', $this->address->country?->id)->get();
        // $this->carriers = Carrier::where('is_enabled', true)->get();
        // $this->carriers = Shipping::get($this->address, (new CartService($this->cart)));
        $this->createAccount = Auth::check() ? null : true;
        $this->taxes = Tax::active()->get();
        $this->selectCarrier();
        $this->calculateShipping();
    }

    public function validate($rules = null, $messages = [], $attributes = [])
    {
        parent::validate($rules, $messages, $attributes);
        $this->emit('validated');
    }

    protected function setupStripe(): ?PaymentIntent
    {
        $stripePM = PaymentMethod::findBySlug('stripe');

        if ($stripePM && $stripePM->is_enabled) {
            Stripe::setApiKey(config('services.stripe.secret'));
            // Create a PaymentIntent with amount and currency
            $intent = PaymentIntent::create([
                'amount' => $this->total,
                'currency' => shopper_currency(),
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
            return $intent;
            // return $intent->client_secret;
        }
        return null;
    }

    public function updatedAddress(): void
    {
        if ($this->address->country) {
            // $this->selectedCountry = Country::find($this->address->country_id);
        }
        if ($this->shipToBilling) {
            $this->shippingToBillingAddress();
        }

        $this->selectedCountry = Country::find($this->address->country_id) ?? Country::active()->first();
        $states = $this->states = CountryState::where('country_id', $this->selectedCountry->id)->get();
        if ($states->count() <= 0) {
            $this->address->country_state_id = null;
        }

        $this->locations = Inventory::where('country_id', $this->address->country_id)->get();

        $this->carriers = Shipping::get($this->shippingAddress, (new CartService($this->cart)));
        $this->selectCarrier();
    }

    // public function updatedShippingAddress()
    // {
    //     if ($this->shipToBilling) {
    //         $this->shippingToBillingAddress();
    //     }
    // }

    protected function verifyCarrierSelection(?Carrier $carrier = null)
    {
        $this->carriers = Shipping::get($this->shippingAddress, (new CartService($this->cart)));

        if ($carrier && $carrier->is_store_pickup) {
            $notStorePickup = Carrier::whereIn('id', $this->carriers->pluck('id')->toArray())
                ->where('is_store_pickup', false)->first();
            $carrier = ($this->locations->count() <= 0) ? $notStorePickup : $carrier;
        }

        if ($carrier) {
            $shipping = Shipping::make($carrier, $this->shippingAddress, $this->cart);
            $this->selectedCarrier = $shipping->useable() ? $carrier : $this->carriers->first();
        } else {
            $this->selectedCarrier = $carrier = $this->carriers->first();
        }
    }

    protected function selectCarrier(): void
    {
        // $this->carriers = Shipping::get($this->shippingAddress, (new CartService($this->cart)));
        $carrier = $this->cart->shipping;
        $this->verifyCarrierSelection($carrier);
        $this->calculateShipping();
        $this->carrierSelected = $this->selectedCarrier?->slug;
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

    public function updatedCarrierSelected($value): void
    {
        $this->verifyCarrierSelection(Carrier::whereSlug($value)->first());
        $this->calculateShipping();
    }

    public function calculateShipping($notify = false): void
    {
        CartService::shippingMethod($this->cart, $this->selectedCarrier);
        $this->processAmounts();
        // $this->needsCartRefresh();
        // if ($notify) {
        //     $this->notify('info', 'Shipping Total Updated!', 'Your Shipping total has been updated.');
        // }
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
            $this->createAccount ? Auth::login($this->user) : null;
        }

        //? 3. Process Addresses
        $this->address->user_id = $this->user->id;
        $this->address->save();
        if ($this->shipToBilling) {
            $this->shippingToBillingAddress();
        }
        $this->shippingAddress->user_id = $this->user->id;
        $this->shippingAddress->save();

        //? 4. Process Order
        $order = $this->processOrder();

        if (!$order instanceof Order) {
            return $order;
        }

        //? 5. Mark order as Registered & Send Mails
        $order->markAsRegistered();
        Mail::to($this->user)->send(new OrderConfirmed($order, $this->getFluentAmounts()));

        //? 6. Clear Cart
        CartService::empty($this->cart);

        //? 7. Redirect
        return redirect()->route('shop.checkout.success', encrypt($order->number));

    }

    private function processOrder(): Order|RedirectResponse|Redirector
    {
        //? 1. Create Order
        //? 2. Create Order Items & associate them to Order
        $order = $this->processOrderItems($this->createOrder());
        if ($this->selectedPaymentMethod === 'stripe') {
            $stripe = $this->setupStripe();
            $token = $stripe->client_secret;
            if (!is_null($token)) {
                return redirect()->route('shop.checkout.payments.stripe', [
                    'order' => encrypt($order->id),
                    'token' => encrypt($token),
                    'payment' => encrypt($stripe->id),
                ]);
            }
        }
        return $order;
    }

    private function createOrder(): Order
    {
        $paymentMethod = PaymentMethod::findBySlug($this->selectedPaymentMethod);

        $order = (new Order)->fill([
            'number' => order_number(),
            'price_amount' => $this->total,
            'currency' => $this->currency,
            'shipping_total' => $this->shippingTotal,
            'tax_total' => $this->taxed,
            'shipping_method' => "{$this->selectedCarrier->name} ({$this->selectedCarrier->name})",
            'amounts' => $this->getAmounts(),
        ]);
        $order->customer()->associate($this->user);
        $order->paymentMethod()->associate($paymentMethod);
        $order->shippingAddress()->associate($this->shippingAddress);
        if ($this->selectedCarrier->is_store_pickup) {
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
