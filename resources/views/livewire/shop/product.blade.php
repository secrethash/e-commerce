<div>
    <!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>{{$product->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End-->
<!-- Shop details Area start -->
<section class="product-details-area ">
    <div class="container">
        <div class="container-inner">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-img product-details-tab">
                        <div class="zoompro-wrap zoompro-2">
                            @if($thumbs)
                                @foreach ($thumbs as $tmbIndex => $thumb)
                                    <div class="zoompro-border zoompro-span">
                                        <img class="zoompro" {{--src="{{ asset($thumb) }}"--}} src="{{ asset($images[$tmbIndex]) }}"
                                            data-zoom-image="{{ asset($images[$tmbIndex]) }}" alt="" width="400px" />
                                    </div>
                                @endforeach
                            @else
                                <div class="zoompro-border zoompro-span">
                                    <img class="zoompro" src="{{ asset('frontend/assets/images/product-image/placeholder-images-image_large.webp') }}"
                                        data-zoom-image="{{ asset('frontend/assets/images/product-image/placeholder-images-image_large.webp') }}" alt="" width="400px" />
                                </div>
                            @endif
                            {{-- <div class="zoompro-border zoompro-span">
                                <img class="zoompro" src="{{ asset('frontend/assets/images/product-image/6.jpg') }}"
                                    data-zoom-image="assets/images/product-image/zoom/5.jpg')}}" alt="" />
                            </div>
                            <div class="zoompro-border zoompro-span">
                                <img class="zoompro" src="{{ asset('frontend/assets/images/product-image/7.jpg') }}"
                                    data-zoom-image="assets/images/product-image/zoom/2.jpg')}}" alt="" />
                            </div> --}}
                        </div>
                        <div id="gallery" class="product-dec-slider-2">
                            @if($thumbs)
                                @foreach ($thumbs as $tmbIndex => $thumb)
                                    <div class="single-slide-item">
                                        <img class="img-responsive" data-image="{{ asset($thumb) }}"
                                            data-zoom-image="{{ asset($images[$tmbIndex]) }}"
                                            src="{{ asset($thumb) }}" alt="" />
                                    </div>
                                @endforeach
                            @else
                                <div class="single-slide-item">
                                    <img class="img-responsive" src="{{ asset('frontend/assets/images/product-image/placeholder-images-image_large.webp') }}"
                                        data-image="{{ asset('frontend/assets/images/product-image/placeholder-images-image_large.webp') }}"
                                        data-zoom-image="{{ asset('frontend/assets/images/product-image/placeholder-images-image_large.webp') }}" alt="" width="400px" />
                                </div>
                            @endif
                            {{-- <div class="single-slide-item">
                                <img class="img-responsive" data-image="assets/images/product-image/6.jpg')}}"
                                    data-zoom-image="assets/images/product-image/zoom/5.jpg')}}"
                                    src="{{ asset('frontend/assets/images/product-image/6.jpg') }}" alt="" />
                            </div>
                            <div class="single-slide-item">
                                <img class="img-responsive" data-image="assets/images/product-image/7.jpg')}}"
                                    data-zoom-image="assets/images/product-image/zoom/2.jpg')}}"
                                    src="{{ asset('frontend/assets/images/product-image/7.jpg') }}" alt="" />
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <h2>{{ $product->name }}</h2>
                        <div class="pro-details-rating-wrap">
                            <div class="rating-product">
                                @for ($i = 0; $product->stars < $i; $i++)
                                    <i class="ion-android-star"></i>
                                @endfor
                                @for ($j = 0; $product->starsEmpty > $j; $j++)
                                    <i class="ion-android-star text-secondary"></i>
                                @endfor
                                {{--
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                --}}
                            </div>
                            {{-- <span class="read-review"><a class="reviews" href="#">Read reviews (1)</a></span> --}}
                        </div>
                        <div class="pricing-meta">
                            <ul>
                                <li class="cuttent-price">{!! $product->formattedPrice !!}</li>
                                @if (
                                    $product->price_amount !== $product->old_price_amount AND
                                    $product->price_amount < $product->old_price_amount
                                )
                                    <li class="old-price">{{$product->formattedPrice($product->old_price_amount * 100)}}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="product-classify">
                            <ul>
                                {{-- <li>Ex Tax:<span> £48.94</span></li> --}}
                                <li>Brand
                                    @if ($product->brand)
                                        <a href="{{route('shop.index', ['brands' => $product->brand->slug])}}">
                                            {{$product->brand->name}}
                                        </a>
                                    @else
                                        <span>N/A</span>
                                    @endif
                                </li>
                                <li>SKU:<span> {{$product->sku}}</span></li>
                                <li>Availability:<span>In Stock</span></li>
                            </ul>
                        </div>
                        <div class="pro-details-list">
                            <p>{{Str::of($product->description)->inlineMarkdown(['html_input' => 'strip'])->words(20)}}</p>
                        </div>
                        {{-- <div class="pro-details-quality mt-0px">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                            </div>
                            <div class="pro-details-cart btn-hover">
                                <a href="#"> Add To Cart</a>
                            </div>
                        </div> --}}
                        @livewire('actions.add-to-cart', [
                            'product' => $product,
                            'buttonType' => 'product',
                        ])
                        <div class="pro-details-wish-com">
                            <div class="pro-details-wishlist">
                                <a href="#"><i class="icon-heart"></i>Add to wishlist</a>
                            </div>
                            <div class="pro-details-compare">
                                <a href="#"><i class="icon-repeat"></i>Add to compare</a>
                            </div>
                        </div>
                        <div class="pro-details-social-info">
                            <span>Share</span>
                            <div class="social-info">
                                <ul>
                                    <li>
                                        <a title="Facebook" href="#"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a title="Twitter" href="#"><i class="ion-social-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a title="Google+" href="#"><i class="ion-social-google"></i></a>
                                    </li>
                                    <li>
                                        <a title="Instagram" href="#"><i class="ion-social-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="pro-details-policy">
                            <ul>
                                <li><img src="{{ asset('frontend/assets/images/icons/policy.png') }}"
                                        alt="" /><span>Free Shipping Ships Today</span></li>
                                <li><img src="{{ asset('frontend/assets/images/icons/policy-2.png') }}"
                                        alt="" /><span>Easy Returns</span></li>
                                <li><img src="{{ asset('frontend/assets/images/icons/policy-3.png') }}"
                                        alt="" /><span>Lowest Price Guarantee</span></li>
                            </ul>
                        </div>
                        <div class="product-tags">
                            <ul>
                                <li class="mx-0"><span class="badge bg-danger text-white rounded-0">Categories</span></li>
                                @foreach ($product->categories as $category)
                                    <li class="mx-0"><a href="{{ route('shop.category', $category->slug) }}" class="badge bg-dark rounded-0 text-light shadow">{{ $category->name }}{{-- @if(!$loop->last){{','}}@endif --}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop details Area End -->
<!-- product details description area start -->
<div class="description-review-area ptb-60px">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav">
                <a data-bs-toggle="tab" href="#des-details1">Description</a>
                <a class="active" data-bs-toggle="tab" href="#des-details2">Product Details</a>
                {{-- <a data-bs-toggle="tab" href="#des-details3">Reviews (2)</a> --}}
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details2" class="tab-pane active">
                    <div class="product-anotherinfo-wrapper">
                        <ul>
                            @if ($product->weight_value > 0)
                                <li><span>{{__('Weight')}}</span> {{round($product->weight_value, 2)}} {{$product->weight_unit}}</li>
                            @endif
                            @if (
                                $product->height_value > 0 OR
                                $product->width_value > 0 OR
                                $product->depth_value > 0
                            )
                                <li>
                                    <span>{{__('Dimensions (LxBxH)')}}</span>
                                    {!! ($product->depth_value > 0) ? round($product->depth_value, 2).$product->depth_unit : '&mdash;' !!} x
                                    {!! ($product->width_value > 0) ? round($product->width_value, 2).$product->width_unit : '&mdash;' !!} x
                                    {!! ($product->height_value > 0) ? round($product->height_value, 2).$product->height_unit : '&mdash;' !!}
                                </li>
                            @endif
                            <li><span>{{__('Product Code (SKU)')}}</span> {{$product->sku}}</li>
                            @foreach ($product->attributes as $attribute)
                                <li>
                                    <span>{{$attribute->attribute->name}}</span>
                                    @foreach ($attribute->values as $value)
                                        <strong class="badge bg-dark">{{$value->product_custom_value}}</strong>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div id="des-details1" class="tab-pane">
                    <div class="product-description-wrapper">
                        {!! $product->description !!}
                    </div>
                </div>
                {{-- <div id="des-details3" class="tab-pane">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="review-wrapper">
                                <div class="single-review">
                                    <div class="review-img">
                                        <img src="{{ asset('frontend/assets/images/review-image/1.png') }}"
                                            alt="" />
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4>White Lewis</h4>
                                                </div>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                        <div class="review-bottom">
                                            <p>
                                                Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia
                                                Curae Suspendisse viverra ed viverra. Mauris ullarper euismod vehicula.
                                                Phasellus quam nisi, congue id nulla.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-review child-review">
                                    <div class="review-img">
                                        <img src="{{ asset('frontend/assets/images/review-image/2.png') }}"
                                            alt="" />
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4>White Lewis</h4>
                                                </div>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                        <div class="review-bottom">
                                            <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia
                                                Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod
                                                vehicula.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="ratting-form-wrapper pl-50">
                                <h3>Add a Review</h3>
                                <div class="ratting-form">
                                    <form action="#">
                                        <div class="star-box">
                                            <span>Your rating:</span>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="rating-form-style mb-10">
                                                    <input placeholder="Name" type="text" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="rating-form-style mb-10">
                                                    <input placeholder="Email" type="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="rating-form-style form-submit">
                                                    <textarea name="Your Review" placeholder="Message"></textarea>
                                                    <input type="submit" value="Submit" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<!-- product details description area end -->
<!-- Arrivel Area Start -->
{{-- <div class="arrival-area mb-60px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2> <span>RELATED </span>PRODUCTS</h2>
                </div>
            </div>
        </div>
        <div class="arrival-wrapper">
            <div class="arrival-slider slider-nav-style-1">
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/1.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/1.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Koss KPH7 Lightweight Portable
                                        Headphone 2</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star color-gray"></i>
                                    <i class="ion-android-star color-gray"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£69.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Kodak PIXPRO Astro Zoom AZ421
                                        16 MP 2</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£87.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">JBL Flip 3 Splashproof Portable
                                        Bluetooth 2</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£469.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/4.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Bose SoundLink Micro Bluetooth
                                        Speaker 2</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£91.86</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/5.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/5.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Beats Solo3 Wireless On-Ear
                                        Headphones 2</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£905.05</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/6.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/6.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Nokia Steel HR Hybrid
                                        Smartwatch</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£87.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/7.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/7.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                    <li class="new discount">-7%</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Marshall Portable Bluetooth
                                        Speaker</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£69.27</li>
                                        <li class="old-price">£89.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">JBL Flip 3 Splashproof Portable
                                        Bluetooth</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£469.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Beats EP Wired On-Ear
                                        Headphone-Black</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£91.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/10.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/10.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="new">New</li>
                                    <li class=" new discount">-2%</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Sony KD55X72 55-Inch 4k Ultra
                                        HD</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£59.27</li>
                                        <li class="old-price">£60.12</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/11.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/11.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Roush Performance Front Brake
                                        Rotor</a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£69.27</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="arrval-slider-item">
                    <article class="list-product text-left">
                        <div class="product-inner">
                            <div class="img-block">
                                <a href="single-product.html" class="thumbnail">
                                    <img class="first-img"
                                        src="{{ asset('frontend/assets/images/product-image/12.jpg') }}"
                                        alt="" />
                                    <img class="second-img"
                                        src="{{ asset('frontend/assets/images/product-image/12.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="add-to-link">
                                    <ul>
                                        <li>
                                            <a href="wishlist.html" title="Add to Wishlist"><i
                                                    class="icon-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="compare.html" title="Add to compare"><i
                                                    class="icon-repeat"></i></a>
                                        </li>
                                        <li>
                                            <a class="quick_view" href="#" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="product-flag">
                                    <li class="discount">-7%</li>
                                </ul>
                            </div>
                            <div class="product-decs">
                                <h2><a href="single-product.html" class="product-link">Koss Porta Pro On Ear
                                        Headphones </a></h2>
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">£69.27</li>
                                        <li class="old-price">£60.72</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="add-to-curt" title="Add to cart"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@if ($relatedProducts->count() >= 1)
    <x-sliders.products.new-arrivals title="<span>RELATED </span> PRODUCTS">
        @foreach ($relatedProducts as $related)
            @php
                $productImages = $related->getMedia('uploads');
                $imageHover = null;
            @endphp
            @foreach ($productImages as $productImage)
                @if ($loop->first)
                    @php
                        $mainImage = $productImage->getUrl('thumb200x200');
                    @endphp
                @elseif($loop->index === 1)
                    @php
                        $imageHover = $productImage->getUrl('thumb200x200');
                    @endphp
                @endif
            @endforeach
            <x-sliders.products.new-arrivals.slide :image="$mainImage" :hover="$imageHover"
                :new="true" :name="$related->name" :ratings="$related->ratingPercent()"
                currency="" :price="$related->formattedPrice" :product="$related"
                :link="route('shop.product', $related->slug)" />
        @endforeach
    </x-sliders.products.new-arrivals>
@endif
<!-- Arrivel Area End -->

</div>
