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
                                    <input class="checkout-toggle2 form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="create-account-toggle"
                                        checked
                                        wire:model='createUser'>
                                    <label class="form-check-label" for="create-account-toggle">Create an Account</label>
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
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-floating mb-20px">
                                        <input type="text" class="form-control @error('address.first_name'){{'is-invalid'}}@enderror"
                                            name="first_name"
                                            id="first_name"
                                            wire:model.defer='address.first_name'
                                            autocomplete="name" />
                                        <label for="first_name">First Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-floating mb-20px">
                                        <input type="text" class="form-control @error('address.last_name'){{'is-invalid'}}@enderror"
                                            name="last_name"
                                            id="last_name"
                                            wire:model.defer='address.last_name'
                                            autocomplete="family-name" />
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating mb-20px">
                                        <input type="text" class="form-control @error('address.company_name'){{'is-invalid'}}@enderror"
                                            name="company_name"
                                            id="company_name"
                                            wire:model.defer='address.company_name'
                                            autocomplete="organization" />
                                        <label for="company_name">Company Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating mb-20px">
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
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-20px">
                                        <input class="form-control @error('address.street_address'){{'is-invalid'}}@enderror"
                                            placeholder="House number and street name"
                                            type="text"
                                            name="street_address"
                                            id="street_address"
                                            wire:model.defer='address.street_address'
                                            autocomplete="address-line1" />
                                        <label for="street_address">Address Line 1</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-20px">
                                        <input name="street_address_plus" class="form-control @error('address.street_address_plus'){{'is-invalid'}}@enderror"
                                            placeholder="Apartment, suite, unit etc."
                                            type="text"
                                            id="street_address_plus"
                                            wire:model.defer='address.street_address_plus'
                                            autocomplete="address-line2" />
                                        <label for="street_address_plus">Address Line 2</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-20px">
                                        <input type="text" class="form-control @error('address.city'){{'is-invalid'}}@enderror"
                                            name="city"
                                            id="city"
                                            wire:model.defer='address.city' />
                                        <label for="city">Town / City / State</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-20px">
                                        <input type="text" name="zipcode"
                                            class="form-control @error('address.zipcode'){{'is-invalid'}}@enderror"
                                            id="zipcode"
                                            wire:model.defer='address.zipcode'
                                            autocomplete="postal-code" />
                                        <label for="zipcode">Postcode / ZIP</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-20px">
                                    {{-- <div class="form-floating"> --}}
                                        {{-- <label for="phone_number">Phone</label> --}}
                                        <div class="input-group">
                                            @if($address->country)
                                                <div class="input-group-text bg-transparent">{{$address->country?->flag}}</div>
                                            @endif
                                            <input type="tel"
                                                name="phone_number"
                                                id="phone_number"
                                                placeholder="Phone Number"
                                                class="form-control py-3 @error('address.phone_number'){{'is-invalid'}}@enderror"
                                                wire:model.defer='address.phone_number'
                                                autocomplete="mobile" />
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            @guest
                                <div class="checkout-account-toggle open-toggle2 mb-30 mt-20px" style="display: block;">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <h5 class="text-dark text-uppercase">
                                                <x-heroicon-s-plus-circle width="26" />
                                                New Account
                                            </h5>
                                        </div>
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
                                        </div>
                                        <div class="col-12 col-md-6 form-floating">
                                            <div class="form-floating">
                                                <input placeholder="Password"
                                                    type="password"
                                                    class="form-control @error('user.password'){{'is-invalid'}}@enderror"
                                                    name="password"
                                                    id="password"
                                                    wire:model.defer='password'
                                                    autocomplete="new-password" />
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <button class="btn-hover checkout-btn" type="submit">
                                        register
                                    </button> --}}
                                </div>
                            @endguest
                            {{-- <div class="additional-info-wrap">
                                <h4>Additional information</h4>
                                <div class="additional-info">
                                    <label>Order notes</label>
                                    <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="message"></textarea>
                                </div>
                            </div> --}}
                            {{-- <div class="checkout-account mt-25">
                                <input class="checkout-toggle" type="checkbox" />
                                <label>Ship to a different address?</label>
                            </div>
                            <div class="different-address open-toggle mt-30px">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-floating mb-20px">
                                            <label>First Name</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-floating mb-20px">
                                            <label>Last Name</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-20px">
                                            <label>Company Name</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-select mb-20px">
                                            <label>Country</label>
                                            <select>
                                                <option>Select a country</option>
                                                <option>Azerbaijan</option>
                                                <option>Bahamas</option>
                                                <option>Bahrain</option>
                                                <option>Bangladesh</option>
                                                <option>Barbados</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-20px">
                                            <label>Street Address</label>
                                            <input class="billing-address" placeholder="House number and street name"
                                                type="text" />
                                            <input placeholder="Apartment, suite, unit etc." type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-20px">
                                            <label>Town / City</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-floating mb-20px">
                                            <label>State / County</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-floating mb-20px">
                                            <label>Postcode / ZIP</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-floating mb-20px">
                                            <label>Phone</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-floating mb-20px">
                                            <label>Email Address</label>
                                            <input type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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
                                            {{-- <li><span class="order-middle-left">Product Name X 1</span> <span
                                                    class="order-price">$329 </span></li> --}}
                                        </ul>
                                    </div>
                                    <div class="your-order-bottom">
                                        <ul>
                                            <li class="your-order-shipping">Shipping</li>
                                            <li>Free shipping</li>
                                        </ul>
                                    </div>
                                    <div class="your-order-total">
                                        <ul>
                                            <li class="order-total">Total</li>
                                            <li>{{ $formattedTotal }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="payment-method">
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
                            </div>
                            <div class="Place-order mt-25">
                                <button class="btn btn-lg btn-danger w-100 d-inline-flex justify-content-center align-items-center"
                                    wire:loading.attr='disabled'
                                    wire:click='submit'>
                                    <x-heroicon-s-check-circle class="me-2" width="22" wire:loading.remove wire:target='submit' />
                                    <div class="spinner-grow spinner-grow-sm me-2" role="status" wire:loading wire:target='submit'>
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Place Order
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
