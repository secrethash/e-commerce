<div>
    <!--Cart info Start -->
    <div class="cart-info d-flex align-self-center">
        <a title="cart" href="#offcanvas-cart-{{$for}}" class="bag offcanvas-toggle" data-number="{{$cart->products->count()}}">
            <i class="icon-shopping-cart"></i>
            <span>{{ $formattedTotal }}</span>
        </a>
    </div>
    <!--Cart info End -->
    <!-- OffCanvas Cart Start -->
    <div id="offcanvas-cart-{{$for}}" class="offcanvas offcanvas-cart">
        <div class="inner">
            <div class="head">
                <span class="title">Cart</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list">
                    @forelse ($products as $product)
                        <li>
                            <a href="{{route('shop.product', $product->slug)}}" class="image"><img
                                    src="{{$product->getMedia('uploads')->first()->getUrl('thumb200x200')}}"
                                    alt="{{ $product->name }}"></a>
                            <div class="content pe-2 pe-md-3">
                                <a href="{{route('shop.product', $product->slug)}}" class="title">{{ $product->name }}</a>
                                <span class="quantity-price">{{$product->pivot->quantity}} x <span class="amount">{{$product->formattedPrice}}</span></span>
                                <a href="#" class="remove" wire:click.prevent='removeProduct({{$product->id}})'>
                                    <x-heroicon-s-x width="18" wire:loading.remove wire:target='removeProduct' />
                                    <div class="spinner-border spinner-border-sm me-2" role="status" wire:loading wire:target='removeProduct'>
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @empty
                        <div class="alert alert-warning text-center" role="alert">
                            <h4 class="alert-heading"><x-heroicon-s-exclamation width="36" /></h4>
                            <h4 class="alert-heading">Cart Empty</h4>
                            <p class="mt-1 lead">It looks lonely here.</p>
                            <hr>
                            <a class="btn btn-dark w-100" href="{{route('shop.index')}}" role="button">
                                <x-heroicon-o-shopping-cart width="18" />
                                Shop
                            </a>
                            <div class="mt-3 d-flex align-items-center">
                                <x-heroicon-s-question-mark-circle width="18" />
                                <p class="mt-3">
                                    Add products to your cart from our shop.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </ul>
            </div>
            @if($products->count() >= 1)
                <div class="foot">
                    <div class="sub-total">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-left">Sub-Total :</td>
                                    <td class="text-right">{{$formattedSubtotal}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Shipping :</td>
                                    <td class="text-right">{{$formattedShippingTotal}}</td>
                                </tr>
                                {{-- <tr>
                                    <td class="text-left">VAT (20%) :</td>
                                    <td class="text-right">£104.66</td>
                                </tr> --}}
                                <tr>
                                    <td class="text-left">Total :</td>
                                    <td class="text-right theme-color">{{$formattedTotal}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="buttons">
                        <a href="{{ route('shop.cart') }}" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
                        <a href="{{ route('shop.checkout') }}" class="btn btn-outline-dark current-btn">checkout</a>
                    </div>
                    {{-- <p class="minicart-message">Free Shipping on All Orders Over $100!</p> --}}
                </div>
            @endif
        </div>
    </div>
    <!-- OffCanvas Cart End -->
</div>
