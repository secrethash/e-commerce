<div>
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- checkout area start -->
    <div class="checkout-area mb-60px">
        <div class="container">
            <div class="container-inner">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="d-block mb-4">
                            <h3>Billing Details</h3>
                            @guest
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="createAccount"
                                        role="switch"
                                        id="create-account"
                                        checked
                                        wire:model='createAccount'>
                                    <label class="form-check-label" for="create-account">
                                        Create an Account
                                        <div class="spinner-border spinner-border-sm text-danger ms-2" role="status" wire:loading>
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="me-1"><x-heroicon-s-question-mark-circle width="18" /> Already have an account? </span>
                                    <a href="{{route('login')}}" class="text-danger">
                                        Login to your account
                                    </a>
                                </div>
                            @endguest
                        </div>
                        <div class="">
                            <div class="row">
                                @if ($errors->any())
                                    <div class="col-12 mb-40px">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            Please Fix these <strong>Validation Errors</strong>:
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="d-block"><strong>{{$loop->index + 1}}.</strong> {{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-6 col-md-6 mb-20px">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('address.first_name'){{'is-invalid'}}@enderror"
                                            name="first_name"
                                            id="first_name"
                                            wire:model.defer='address.first_name'
                                            autocomplete="name" />
                                        <label for="first_name">First Name</label>
                                    </div>
                                    @error('address.first_name')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 mb-20px">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('address.last_name'){{'is-invalid'}}@enderror"
                                            name="last_name"
                                            id="last_name"
                                            wire:model.defer='address.last_name'
                                            autocomplete="family-name" />
                                        <label for="last_name">Last Name</label>
                                    </div>
                                    @error('address.last_name')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @guest
                                    @if($createAccount)
                                        <div class="col-12 mb-20px animate__animated animate__fadeIn" style="display: block;">
                                            <fieldset class="custom-fieldset">
                                                <legend class="custom-fieldset ms-0">
                                                    <x-heroicon-s-plus-circle width="20" />
                                                    Account
                                                </legend>
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-floating">
                                                            <input placeholder="Email address"
                                                                type="email"
                                                                class="form-control @error('user.email'){{'is-invalid'}}@enderror"
                                                                name="email"
                                                                id="email"
                                                                wire:model.defer='user.email'
                                                                autocomplete="email" />
                                                            <label for="email">Email</label>
                                                        </div>
                                                        @error('user.email')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 col-md-6 form-floating">
                                                        <div class="form-floating">
                                                            <input placeholder="Password"
                                                                type="password"
                                                                class="form-control @error('password'){{'is-invalid'}}@enderror"
                                                                name="password"
                                                                id="password"
                                                                wire:model.defer='password'
                                                                autocomplete="new-password" />
                                                            <label for="password">Password</label>
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    @else
                                        <div class="col-12 mb-20px animate__animated animate__fadeIn">
                                            <div class="form-floating">
                                                <input placeholder="Email address"
                                                    type="email"
                                                    class="form-control @error('user.email'){{'is-invalid'}}@enderror"
                                                    name="email"
                                                    id="email"
                                                    wire:model.defer='user.email'
                                                    autocomplete="email" />
                                                <label for="email">Email</label>
                                            </div>
                                            @error('user.email')
                                                <span class="invalid-feedback show" role="alert">
                                                    <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
                                @endguest
                                <div class="col-lg-12 mb-20px">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('address.company_name'){{'is-invalid'}}@enderror"
                                            name="company_name"
                                            id="company_name"
                                            wire:model.defer='address.company_name'
                                            autocomplete="organization" />
                                        <label for="company_name">Company Name</label>
                                    </div>
                                    @error('address.company_name')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div @class([
                                    "col-12",
                                    "col-md-6" => $states?->count() >= 1,
                                    "mb-20px",
                                ])>
                                    <div class="form-floating">
                                        <select class="form-select @error('address.country_id'){{'is-invalid'}}@enderror"
                                            wire:model='address.country_id'
                                            name="country"
                                            id="country">
                                            <option>Select a country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}">{{$country->flag}} {{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="country">Country</label>
                                    </div>
                                    @error('address.country_id')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if ($states?->count() >= 1)
                                    <div class="col-12 col-md-6 mb-20px">
                                        <div class="form-floating">
                                            <select class="form-select @error('address.country_state_id'){{'is-invalid'}}@enderror"
                                                wire:model='address.country_state_id'
                                                name="state"
                                                id="state">
                                                <option>Select a State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{$state->id}}">{{$state->flag}} {{$state->name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="state">State</label>
                                        </div>
                                        @error('address.country_state_id')
                                            <span class="invalid-feedback show" role="alert">
                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-12 col-md-6 mb-20px">
                                    <div class="form-floating">
                                        <input class="form-control @error('address.street_address'){{'is-invalid'}}@enderror"
                                            placeholder="House number and street name"
                                            type="text"
                                            name="street_address"
                                            id="street_address"
                                            wire:model.defer='address.street_address'
                                            autocomplete="address-line1" />
                                        <label for="street_address">Address Line 1</label>
                                    </div>
                                    @error('address.street_address')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-20px">
                                    <div class="form-floating">
                                        <input name="street_address_plus" class="form-control @error('address.street_address_plus'){{'is-invalid'}}@enderror"
                                            placeholder="Apartment, suite, unit etc."
                                            type="text"
                                            id="street_address_plus"
                                            wire:model.defer='address.street_address_plus'
                                            autocomplete="address-line2" />
                                        <label for="street_address_plus">Address Line 2</label>
                                    </div>
                                    @error('address.street_address_plus')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-20px">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('address.city'){{'is-invalid'}}@enderror"
                                            name="city"
                                            id="city"
                                            wire:model.defer='address.city' />
                                        <label for="city">Town / City / State</label>
                                    </div>
                                    @error('address.city')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-20px">
                                    <div class="form-floating">
                                        <input type="text" name="zipcode"
                                            class="form-control @error('address.zipcode'){{'is-invalid'}}@enderror"
                                            id="zipcode"
                                            wire:model.defer='address.zipcode'
                                            autocomplete="postal-code" />
                                        <label for="zipcode">Postcode / ZIP</label>
                                    </div>
                                    @error('address.zipcode')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20px">
                                    <div class="input-group">
                                        <div class="input-group-text bg-transparent placeholder-glow">
                                            @if($address->country)
                                                {{$selectedCountry?->flag}}
                                            @else
                                                <span class="placeholder px-2"></span>
                                            @endif
                                        </div>
                                        <input type="tel"
                                            name="phone_number"
                                            id="phone_number"
                                            placeholder="Phone Number"
                                            class="form-control py-3 @error('address.phone_number'){{'is-invalid'}}@enderror"
                                            wire:model.defer='address.phone_number'
                                            autocomplete="mobile" />
                                    </div>
                                    @error('address.phone_number')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-md-30px mt-lm-30px ">
                        <div class="your-order-area">
                            <h3>Your order</h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-product-info">
                                    <div class="your-order-top">
                                        <ul>
                                            <li>Product</li>
                                            <li>Total</li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            @foreach ($cart->products as $product)
                                                <li>
                                                    <span class="order-middle-left pe-3">
                                                        {{$product->name}} X {{ $product->pivot->quantity }}
                                                    </span>
                                                    <span class="order-price fw-bold">
                                                        {{ $product->formatted_price }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="your-order-bottom">
                                        <ul>
                                            <li class="your-order-shipping">
                                                <div class="d-block">
                                                    Shipping
                                                </div>
                                                <div class="d-block text-center">
                                                    @if ($carriers->count() >= 1 && $shippingTotal <= 0)
                                                        <small class="badge bg-success rounded-0">
                                                            {{'Free'}}
                                                        </small>
                                                    @endif
                                                </div>
                                            </li>
                                            <li>
                                                @forelse ($carriers as $carrier)
                                                    <div class="d-block form-check">
                                                        @php
                                                            $shipping = App\Services\Shipping::make($carrier, $shippingAddress, $cart);
                                                            $shipping->process();
                                                        @endphp
                                                        <label for="carrier-{{$carrier->slug}}" class="form-check-label">
                                                            {{$carrier->name}}
                                                            @if($shipping->getCharge() > 0)
                                                                <span class="fw-bolder">
                                                                    {{-- @dump($shipping->getCharge()) --}}
                                                                    {{price_formatted($shipping->getCharge())}}
                                                                </span>
                                                            @elseif ($carrier->is_store_pickup && $locations->count() <= 0)
                                                                <span class="badge bg-secondary rounded-0">
                                                                    {{'Not Available'}}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-success rounded-0">
                                                                    {{'Free'}}
                                                                </span>
                                                            @endif
                                                        </label>
                                                        <input type="radio"
                                                            class="form-check-input"
                                                            name="shipping_method"
                                                            value="{{$carrier->slug}}"
                                                            wire:model='carrierSelected'
                                                            @disabled($carrier->slug === $storePickup && $locations->count() <= 0)
                                                            id="carrier-{{$carrier->slug}}" />
                                                    </div>
                                                @empty
                                                    <div class="d-block p-2" style="border: dashed 2px var(--bs-gray-300);">
                                                        <span>No Shipping Available</span>
                                                    </div>
                                                @endforelse
                                                <div class="d-block mt-2 text-danger fw-bolder text-end">
                                                    @if ($shippingTotal > 0)
                                                        {{$formattedShippingTotal}}
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="your-order-bottom mt-2">
                                        <ul>
                                            <li class="your-order-shipping">
                                                <div class="d-block">
                                                    Tax
                                                </div>
                                            </li>
                                            <li>
                                                @forelse ($taxes as $tax)
                                                    <div class="d-block form-check">
                                                        <span for="carrier-{{$tax->slug}}" class="form-check-label">
                                                            <span class="fw-bolder">{{$tax->short_name}}</span>
                                                            <span class="">
                                                                {{price_formatted($taxation($tax, $subtotal / 100))}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                @empty
                                                    <div class="d-block p-2" style="border: dashed 2px var(--bs-gray-300);">
                                                        <span>No Tax Added</span>
                                                    </div>
                                                @endforelse
                                                <div class="d-block mt-2 text-danger fw-bolder text-end">
                                                    @if ($taxed > 0)
                                                        {{$formattedTaxed}}
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-total">
                                        <ul>
                                            <li class="order-total">Total</li>
                                            <li>
                                                <div class="spinner-border spinner-border-sm text-danger me-2" role="status" wire:loading>
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <span wire:loading.remove>{{ $formattedTotal }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="payment-method mb-3">
                                    <div class="mb-3">
                                        <h3>Choose a Payment Mode</h3>
                                    </div>
                                    <div class="payment-accordion element-mrg">
                                        <div class="panel-group" id="accordion">
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <div class="panel payment-accordion">
                                                    <div class="panel-heading" id="{{$paymentMethod->slug}}-heading">
                                                        <h4 class="panel-title">
                                                            <a data-bs-toggle="collapse" data-parent="#accordion"
                                                                href="#{{$paymentMethod->slug}}-accordion" @class([
                                                                    'collapsed' => $selectedPaymentMethod !== $paymentMethod->slug,
                                                                    'd-flex align-items-center justify-content-between'
                                                                ]) wire:click="selectPaymentMethod('{{$paymentMethod->slug}}')">
                                                                <div>
                                                                    <span class="badge bg-primary rounded me-2">{{$loop->index + 1}}</span>
                                                                    <span>{{$paymentMethod->title}}</span>
                                                                </div>
                                                                <div>
                                                                    <div class="spinner-border spinner-border-sm text-success me-2" role="status" wire:loading wire:target="selectPaymentMethod">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                    @if($selectedPaymentMethod === $paymentMethod->slug)
                                                                        <span class="badge bg-success" style="opacity: .85;" wire:loading.remove wire:target='selectPaymentMethod'>selected</span>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="{{$paymentMethod->slug}}-accordion" @class([
                                                        "panel-collapse collapse",
                                                        "show" => $selectedPaymentMethod === $paymentMethod->slug,
                                                    ])>
                                                        <div class="panel-body">
                                                            <div class="mt-2 form-check d-none">
                                                                <input type="radio" class="form-check-input" name="payment_method" id="payment_method_{{$paymentMethod->slug}}" value="{{$paymentMethod->slug}}" wire:model='selectedPaymentMethod'>
                                                                <label for="payment_method_{{$paymentMethod->slug}}" class="form-check-label"> Select {{$paymentMethod->title}}</label>
                                                            </div>
                                                            <p>{{$paymentMethod->description}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @if ($selectedCarrier?->is_store_pickup && $address->country_id !== null)
                                    <hr class="my-4" />
                                    <div class="my-3">
                                        <h3>Choose a Pickup Point</h3>
                                        <label for="store_location">Select Pickup Location</label>
                                        <select name="store_location"
                                            id="store_location"
                                            class="form-select @error('store_location'){{'is-invalid'}}@enderror"
                                            wire:model="store_location">
                                            <option value="Select an option"></option>
                                            @foreach ($locations as $location)
                                                <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('store_location')
                                            <span class="invalid-feedback show" role="alert">
                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                            <div class="Place-order mt-25">
                                <button class="btn btn-lg btn-danger w-100 d-inline-flex justify-content-center align-items-center"
                                    wire:loading.attr='disabled'
                                    wire:click='submit'
                                    @disabled($carriers->count() <= 0)>
                                    <x-heroicon-s-check-circle class="me-2" width="22" wire:loading.remove wire:target='submit' />
                                    <div class="spinner-grow spinner-grow-sm me-2" role="status" wire:loading wire:target='submit'>
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Pay & Place Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout area end -->
</div>

