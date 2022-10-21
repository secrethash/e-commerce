@aware([
    'image', # Default Product Image
    'hover', # Hover Image
    'new' => false, # is a new product?
    'discount' => null, # is discounted
    'name', # Product Name
    'ratings' => 0, # Total Ratings
    'currency', # Product's Currency
    'price', # Product's Price
    'orignal' => null, # Old Price (if price dropped)
    'link', # Link to Product's Page
    'countdown' => null, # has countdown
    'floats' => true, # Display Floating Buttons
    'flags' => true, # Display Flags
    'cart' => true, # Display Add to Cart Button
])

@php
    $stars = (int) round($ratings);
    $blank_stars = 5 - $stars;
@endphp

<article class="list-product text-left">
    <div class="product-inner">
        <div class="img-block">
            <a href="{{$link}}" class="thumbnail">
                <img class="first-img" src="{{$image}}" alt="{{$name}}" />
                @if($hover)
                    <img class="second-img" src="{{$hover}}" alt="{{$name}}" />
                @endif
            </a>
            @if ($floats)
                <div class="add-to-link">
                    <ul>
                        {{-- <li>
                            <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                        </li> --}}
                        {{-- <li>
                            <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                        </li> --}}
                        <li>
                            <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="icon-eye"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            @if ($flags)
                <ul class="product-flag">
                    @if($new)
                        <li class="new">{{ __('New') }}</li>
                    @endif
                    @if ($discount)
                        <li class="discount">-{{$discount}}</li>
                    @endif
                </ul>
            @endif
        </div>
        <div class="product-decs">
            <h2><a href="{{$link}}" class="product-link">{{$name}}</a></h2>
            <div class="rating-product">
                @for ($i = 0; $stars < $i; $i++)
                    <i class="ion-android-star"></i>
                @endfor
                @for ($j = 0; $blank_stars > $j; $j++)
                    <i class="ion-android-star color-gray"></i>
                @endfor
            </div>
            <div class="pricing-meta">
                <ul>
                    @if($orignal)
                        <li class="old-price">{{$currency}}{{$orignal}}</li>
                    @endif
                    <li class="current-price">{{$currency}}{{$price}}</li>
                </ul>
            </div>
        </div>
        @if ($cart)
            <div class="cart-btn">
                <a href="#" class="add-to-cart" title="Add to cart"><i class="icon-shopping-cart"></i></a>
            </div>
        @endif
        @if ($countdown)
            <div class="clockdiv d-flex">
                <p class="text-hurryup align-self-center">Hurry up! <span>Offer ends in:</span></p>
                <div data-countdown="{{ $countdown }}"></div>
            </div>
        @endif
    </div>
</article>
