@props([
    'image', # Default Product Image
    'hover', # Hover Image
    'new' => false, # is a new product?
    'discount' => null, # is discounted
    'name', # Product Name
    'description' => '', # Product Description
    'ratings' => 0, # Total Ratings
    'currency', # Product's Currency
    'price', # Product's Price
    'orignal' => null, # Old Price (if price dropped)
    'link', # Link to Product's Page
    'flags' => true, # Display Flags
    'product',
    'key' => null,
])

@php
    $stars = (int) round($ratings);
    $blank_stars = 5 - $stars;
@endphp

    <div class="shop-list-wrap scroll-zoom">
        <div class="slider-single-item" @if ($key) wire:key='{{$key}}' @endif>
            <div class="row list-product m-0px">
                <div class="col-md-12 padding-0px product-inner">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                            <div class="left-img">
                                <div class="img-block">
                                    <a href="{{$link}}" class="thumbnail">
                                        <img class="first-img" src="{{$image}}" alt="{{$name}}" />
                                        @if($hover)
                                            <img class="second-img" src="{{$hover}}" alt="{{$name}}" />
                                        @endif
                                    </a>
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
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                            <div class="product-desc-wrap">
                                <div class="product-decs">
                                    <h2><a href="{{$link}}" class="product-link">{{$name}}</a></h2>
                                    <div class="rating-product">
                                        @for ($i = 0; $stars < $i; $i++)
                                            <i class="ion-android-star"></i>
                                        @endfor
                                        @for ($j = 0; $blank_stars < $j; $j++)
                                            <i class="ion-android-star color-gray"></i>
                                        @endfor
                                    </div>
                                    <div class="product-intro-info">
                                        {{-- <p>{!! $description !!}</p> --}}
                                    </div>
                                </div>
                                <div class="box-inner d-flex">
                                    <div class="align-self-center">
                                        <div class="pricing-meta">
                                            <ul>
                                                @if($orignal)
                                                    <li class="old-price">{{$currency}}{{$orignal}}</li>
                                                @endif
                                                <li class="current-price">{{$currency}}{{$price}}</li>
                                            </ul>
                                        </div>
                                        {{-- <div class="in-stock">Availability: <span>299 In Stock</span></div> --}}
                                        {{-- <div class="cart-btn">
                                            <a href="#" class="add-to-curt" title="Add to cart">{{ __('Add to cart') }}</a>
                                        </div> --}}
                                        @livewire('actions.add-to-cart', [
                                            'product' => $product,
                                            'buttonType' => 'curt',
                                        ])
                                        <div class="add-to-link">
                                            <ul>
                                                <li>
                                                    <a href="#" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                </li>
                                                {{-- <li>
                                                    <a href="#" title="Add to compare"><i class="icon-repeat"></i></a>
                                                </li> --}}
                                                {{-- <li>
                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="icon-eye"></i>
                                                    </a>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
