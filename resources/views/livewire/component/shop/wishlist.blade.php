<div>
    <div class="cart-info d-flex align-self-center me-3">
        <a title="wishlist" href="#offcanvas-wishlist-{{$for}}" class="heart offcanvas-toggle me-0" data-number="{{$wishlist->products->count()}}">
            <i class="icon-heart"></i>
        </a>
    </div>
    <!-- OffCanvas Wishlist Start -->
    <div id="offcanvas-wishlist-{{$for}}" class="offcanvas offcanvas-wishlist">
        <div class="inner">
            <div class="head">
                <span class="title">Wishlist</span>
                <span class="title text-danger">{{$wishlist->name}}</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list">
                    @auth
                        @forelse ($products as $product)
                            <li>
                                <a href="{{route('shop.product', $product->slug)}}" class="image"><img
                                        src="{{$product->getMedia('uploads')->first()->getUrl('thumb200x200')}}"
                                        alt="{{ $product->name }}"></a>
                                <div class="content pe-2 pe-md-3">
                                    <a href="{{route('shop.product', $product->slug)}}" class="title">{{ $product->name }}</a>
                                    <span class="quantity-price"><span class="amount">{{$product->formattedPrice}}</span></span>
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
                                <h4 class="alert-heading">Wishlist Empty</h4>
                                <p class="mt-1 lead">It looks lonely here.</p>
                                <hr>
                                <a class="btn btn-dark w-100" href="{{route('shop.index')}}" role="button">
                                    <x-heroicon-o-shopping-cart width="18" />
                                    Shop
                                </a>
                                <p class="mt-3"><x-heroicon-s-question-mark-circle width="18" /> Add products in your wishlist from our shop.</p>
                            </div>
                        @endforelse
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            <h4 class="alert-heading"><x-heroicon-s-exclamation width="36" /></h4>
                            <h4 class="alert-heading">Sign-in to view</h4>
                            <p class="mt-1 lead">Login at {{config('app.name')}} to view your wishlist.</p>
                            <hr>
                            <a class="btn btn-dark w-100" href="{{route('login')}}" role="button">
                                <x-ri-login-circle-fill width="18" />
                                Login
                            </a>
                            <p class="mt-3"><x-heroicon-s-question-mark-circle width="18" /> Don't Have an account yet? <a href="{{route('register')}}">Signup here</a>.</p>
                        </div>
                    @endauth
                </ul>
            </div>
            @auth
                @if($products->count() >= 1)
                    <div class="foot">
                        <div class="buttons">
                            <a href="{{route('shop.wishlist')}}" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
    <!-- OffCanvas Wishlist End -->
</div>
