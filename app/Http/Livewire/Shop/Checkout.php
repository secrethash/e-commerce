<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Http\Livewire\Traits\HasAmounts;
use App\Http\Livewire\Traits\InteractsWithCart;
use App\Mail\OrderConfirmed;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart as CartService;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;
use Mail;
use Shopper\Framework\Facades\Shopper;
use Shopper\Framework\Models\Shop\Carrier;
use Shopper\Framework\Models\Shop\Inventory\Inventory;
use Shopper\Framework\Models\Shop\Order\Order;
use Shopper\Framework\Models\Shop\Order\OrderItem;
use Shopper\Framework\Models\Shop\PaymentMethod;
use Shopper\Framework\Models\System\Country;
use Shopper\Framework\Models\User\Address;

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

    public $store_location;

    protected $listeners = [
        'refresh-cart' => 'refreshCart',
        'refresh-amount' => 'processAmounts',
    ];

    protected $validationAttributes = [
        'address.first_name' => 'First Name',
        'address.last_name' => 'Last Name',
        'address.company_name' => 'Company Name',
        'address.country_id' => 'Country',
        'address.street_address' => 'Address Line 1',
        'address.street_address_plus' => 'Address Line 2',
        'address.city' => 'City',
        'address.zipcode' => 'Zipcode',
        'address.phone_number' => 'Phone Number',
        'store_location' => 'Pickup Location',
    ];

    protected $messages = [
        'user.email.required_with' => 'The :Attribute field is required when create account is active.',
        'password.required_with' => 'The :Attribute field is required when create account is active.',
        'store_location.required_if' => 'The :Attribute field is required when selected shipping method is Store Pickup.'
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
            'createAccount' => [],
            'user' => ['array'],
            'user.email' => ['required_with:createAccount'],
            'password' => ['required_with:createAccount', Password::min(8)->numbers()->symbols()->mixedCase()],
            'selectedPaymentMethod' => ['required', 'exists:payment_methods,slug'],
            'selectedCarrier' => ['required', 'exists:carriers,slug'],
            'store_location' => ['required_if:selectedCarrier,'.$this->storePickup],
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
        $this->selectedCountry = $this->address->country ? Country::find($this->address->country_id) : null;
        $this->locations = Inventory::where('country_id', $this->address->country?->id)->get();
        $this->carriers = Carrier::where('is_enabled', true)->get();
        $this->createAccount = Auth::check() ? null : true;
        $this->selectCarrier();
        $this->calculateShipping();
    }

    public function updatedAddress(): void
    {
        if ($this->address->country) {
            $this->locations = Inventory::where('country_id', $this->address->country_id)->get();
            $this->selectedCountry = Country::find($this->address->country_id);
        }
        $this->selectCarrier();
    }

    protected function selectCarrier(): void
    {
        $carrier = $this->cart->shipping?->slug;
        if ($carrier === $this->storePickup) {
            $notStorePickup = Carrier::where('is_enabled', true)
                ->whereNotIn('slug', [$this->storePickup])->first()?->slug;
            $carrier = ($this->locations->count() <= 0) ? $notStorePickup : $carrier;
        }
        $this->selectedCarrier = $carrier ?? $this->carriers->first()?->slug;
        $this->calculateShipping($carrier !== $this->storePickup);
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
        $this->selectCarrier();
    }

    public function calculateShipping($notify = true): void
    {
        CartService::shippingMethod($this->cart, $this->selectedCarrier);
        $this->needsCartRefresh();
        if ($notify) {
            $this->notify('info', 'Total Updated!', 'Your total has been updated.');
        }
    }

    public function refreshCart()
    {
        $this->baseRefreshCart();
        if (CartService::isEmpty($this->cart)) {
            return redirect()->route('shop.cart')->with('notice', [
                [
                    'type' => 'danger',
                    'heading' => 'Cart is Empty!',
                    'message' => 'No Products in your cart. Please add some products to your cart then proceed to checkout.',
                ]
            ]);
        }
    }

    public function submit()
    {
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
