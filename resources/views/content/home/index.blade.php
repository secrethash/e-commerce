@extends('layouts.app')

@section('content')
    @if(banner_exists($usedForEnum('slider')))
        <x-sliders.home>
            @foreach (banners($usedForEnum('slider')) as $slider)
                <x-sliders.home.slide image="{{$slider->getFirstMediaUrl()}}"
                    animation="{{Arr::random([1, 2, 3])}}"
                    :subtitle="$slider->subtitle"
                    :title="$slider->title"
                    :content="$slider->content"
                    :action="$slider->link"
                    :button="$slider->link_text" />
            @endforeach
        </x-sliders.home>
    @endif

    <!-- Static Area Start -->
    <div class="static-area mtb-60px">
        <div class="container">
            <div class="static-area-wrap">
                <div class="row">
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img src="{{ asset('frontend/assets/images/icons/static-icons-1.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Free Shipping</h4>
                                <p>Free shipping on all US orde</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-static">
                            <img src="{{ asset('frontend/assets/images/icons/static-icons-2.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Support 24/7</h4>
                                <p>Contact us 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6 mb-sm-30px">
                        <div class="single-static">
                            <img src="{{ asset('frontend/assets/images/icons/static-icons-3.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>100% Money Back</h4>
                                <p>You have 30 days to Return</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                        <div class="single-static">
                            <img src="{{ asset('frontend/assets/images/icons/static-icons-4.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Payment Secure</h4>
                                <p>We ensure secure payment</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Static Area End -->


    <!-- Brands Slider Area Start -->
    <x-sliders.brands.text title="Car <span>Brands</span>">
        @foreach ($brands as $brand)
            <x-sliders.brands.text.slide :name="$brand->name" :link="route('shop.index', ['brands'=>$brand->slug])" />
        @endforeach
    </x-sliders.brands.text>
    <!-- Brands Slider Area End -->

    <!-- Brands Slider Area Start -->
    <x-sliders.brands.text title="Aftermarket <span>Brands</span>">
        @foreach ($aftermarket as $afb)
            <x-sliders.brands.text.slide :name="$afb->name" :link="route('shop.index', ['brands'=>$afb->slug])" />
        @endforeach
    </x-sliders.brands.text>
    <!-- Brands Slider Area End -->

    <!-- New Arrival Area Start -->
    <x-sliders.products.new-arrivals title="<span>NEW</span> ARRIVALS">
        @foreach ($newArrivals as $newArrival)
            @php
                $newArrivalImages = product_images($newArrival);
            @endphp
            <x-sliders.products.new-arrivals.slide :image="$newArrivalImages->thumb" :hover="$newArrivalImages->hover" :new="true" :name="$newArrival->name"
                :ratings="$newArrival->ratingPercent()" currency="" :price="$newArrival->formattedPrice"
                :link="route('shop.product', $newArrival->slug)" :product="$newArrival" />
        @endforeach
    </x-sliders.products.new-arrivals>
    <!-- New Arrival Area End -->

    <!-- Banner Area Start -->
    @if (banner_exists($usedForEnum('offer_homepage_duo'), 2))
        <div class="banner-area mtb-60px">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-lm-30px">
                        @php
                            $banner1 = banner_single($usedForEnum('offer_homepage_duo'), true);
                        @endphp
                        <div class="banner-wrapper">
                            <a href="{{ $banner1->link }}">
                                <img src="{{ $banner1->getFirstMediaUrl() }}"
                                    alt="{{ $banner1->link_text }}" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="banner-wrapper">
                            @php
                                $banner2 = banner_single($usedForEnum('offer_homepage_duo'), true, $banner1);
                            @endphp
                            <a href="{{ $banner2->link }}">
                                <img src="{{ $banner2->getFirstMediaUrl() }}"
                                    alt="{{ $banner2->link_text }}" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Banner Area End -->
    <!-- Custom Block Area Start -->
    <div class="custom-block-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-md-60px">
                    {{-- <x-sliders.products.hot-deals title="<span>THIS WEEK’S</span> HOT DEALS">
                        <x-sliders.products.hot-deals.slide />
                    </x-sliders.products.hot-deals> --}}
                    <!-- Banner Area Start -->

                    @if (banner_exists($usedForEnum('offer_homepage_solo')))
                        @php
                            $bannerSolo = banner_single($usedForEnum('offer_homepage_solo'), true);
                        @endphp
                        <div class="banner-area banner-style-2 mtb-60px">
                            <div class="banner-wrapper">
                                <a href="{{ $bannerSolo->link }}">
                                    <img src="{{ $bannerSolo->getFirstMediaUrl() }}"
                                        alt="{{ $bannerSolo->link_text }}" />
                                </a>
                                <div class="text">
                                    <h3>{!! $bannerSolo->title !!}</h3>
                                    <h4 class="color-yellow">{!! $bannerSolo->subtitle !!}</h4>
                                    <p>{!! $bannerSolo->content !!}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Banner Area End -->
                    @endif
                    @if ($featured->count() >= 1)
                        <x-sliders.products.featured title="<span>FEATURED </span> PRODUCTS">
                            @foreach ($featured as $feat)
                                @php
                                    $featImages = product_images($feat);
                                @endphp
                                <x-sliders.products.featured.slide :image="$featImages->thumb" :hover="$featImages->hover" :new="$feat->published_at > now()->subDays(15)" :name="$feat->name"
                                    :ratings="$feat->ratingPercent()" currency="" :price="$feat->formattedPrice" :link="route('shop.product', $feat->slug)" :product="$feat" />
                            @endforeach
                        </x-sliders.products.featured>
                    @endif
                </div>
                <div class="col-lg-4 col-md-12">
                    <x-sliders.products.best-sellers title="<span> BEST  </span> SELLERS">
                        @foreach ($bestSellers as $chunk)
                            <x-sliders.products.best-sellers.wrapper>
                                @foreach ($chunk as $bestSeller)
                                    @php
                                        $bsImages = product_images($bestSeller);
                                    @endphp
                                    <x-sliders.products.best-sellers.slide :image="$bsImages->thumb" :hover="$bsImages->hover"
                                        :name="$bestSeller->name" {{--discount="25%"--}} :ratings="$bestSeller->ratingPercent()" currency=""
                                        :price="$bestSeller->formattedPrice" :floats="false" {{-- :flags="false" --}} :cart="false"
                                        :link="route('shop.product', $bestSeller->slug)" :product="$bestSeller" />
                                @endforeach
                            </x-sliders.products.best-sellers.wrapper>
                        @endforeach
                    </x-sliders.products.best-sellers>
                    <!-- Testimonial Start -->
                    <div class="testimonial-area slider-dot-style-1 mtb-60px">
                        <div class="testimonial-slider-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <!-- Testimonial item Start -->
                                <div class="testimonial-slider-item">
                                    <div class="testimonial-image">
                                        <img src="{{$testimonial->getMedia('default')->first()->getUrl('thumb')}}"
                                            alt="{{$testimonial->author_name}}" width="120">
                                    </div>
                                    <div class="testimonial-content">
                                        <p> {!! $testimonial->content !!}</p>
                                    </div>
                                    <div class="testimonial-author">
                                        <h4>{{$testimonial->author_name}}</h4>
                                    </div>
                                </div>
                                <!-- Testimonial item End -->
                            @endforeach
                        </div>
                    </div>
                    <!-- Testimonial End -->
                    <!-- Banner Area Start -->
                    {{-- <div class="banner-area mtb-60px">
                        <div class="banner-wrapper">
                            <a href="#"><img src="{{asset('frontend/assets/images/banner-image/4.jpg')}}" alt="" /></a>
                        </div>
                    </div> --}}
                    <!-- Banner Area End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Custom Block Area End -->
    <!-- Category Tab Slider Area Start -->
    {{-- <div class="category-tab-slider-area mb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2><span> WHEELS </span>& TIRES</h2>
                        <div class="box-tab ">
                            <ul class="tab-heading tabs-categorys nav nav-tabs">
                                <li>
                                    <a class="active" data-bs-toggle="pill" href="#tab-1">
                                        <span>Wheel Bearings</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="pill" href="#tab-2">
                                        <span>Wheel Rim Screws</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="pill" href="#tab-3">
                                        <span>Wheel Simulators</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="category-tab-block">
                        <div class="category-image">
                            <!-- Banner Area Start -->
                            <div class="banner-area">
                                <div class="banner-wrapper">
                                    <a href="#"><img src="{{ asset('frontend/assets/images/banner-image/5.jpg') }}"
                                            alt="" /></a>
                                </div>
                            </div>
                            <!-- Banner Area End -->
                        </div>
                        <div class="category-tab">
                            <!-- Tab Content Start -->
                            <div class="tab-content">
                                <!-- 1st tab -->
                                <div id="tab-1" class="tab-pane active">
                                    <!-- Tab Slider Start -->
                                    <div class="tab-product-slider-wrappwer">
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Apple</span></a>
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Bose SoundLink Micro
                                                                Bluetooth
                                                                Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Canon</span></a>
                                                        <h2><a href="#" class="product-link">Beats EP Wired On-Ear
                                                                Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£93.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/16.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/16.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Bose SoundLink Micro
                                                                Bluetooth
                                                                Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/17.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Beats Solo2 Solo 2
                                                                Wired On-Ear
                                                                Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Hewlett-Packard</span></a>
                                                        <h2><a href="#" class="product-link">Beats Solo Wireless
                                                                On-Ear
                                                                Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                        <ul class="product-flag">
                                                            <li class="discount">-7%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Apple iPad with Retina
                                                                Display
                                                                MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                                <li class="old-price">£75.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/14.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/14.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- Tab Slider End -->
                                </div>
                                <!-- 1st tab -->
                                <!-- 2nd tab -->
                                <div id="tab-2" class="tab-pane fade">
                                    <!-- Tab Slider Start -->
                                    <div class="tab-product-slider-wrappwer">
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Canon</span></a>
                                                        <h2><a href="#" class="product-link">Beats EP Wired On-Ear
                                                                Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£93.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/16.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/16.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Bose SoundLink Micro
                                                                Bluetooth
                                                                Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/17.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Beats Solo2 Solo 2
                                                                Wired On-Ear
                                                                Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Apple</span></a>
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Bose SoundLink Micro
                                                                Bluetooth
                                                                Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Hewlett-Packard</span></a>
                                                        <h2><a href="#" class="product-link">Beats Solo Wireless
                                                                On-Ear
                                                                Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                        <ul class="product-flag">
                                                            <li class="discount">-7%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Apple iPad with Retina
                                                                Display
                                                                MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                                <li class="old-price">£75.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/14.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/14.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- Tab Slider End -->
                                </div>
                                <!-- 2nd tab -->
                                <!-- 3rd tab -->
                                <div id="tab-3" class="tab-pane fade">
                                    <!-- Tab Slider Start -->
                                    <div class="tab-product-slider-wrappwer">
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Apple</span></a>
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt" title="Add to cart"
                                                                    tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Bose SoundLink Micro
                                                                Bluetooth
                                                                Speaker 2</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/8.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">JBL Flip 3 Splashproof
                                                                Portable
                                                                Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/9.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Canon</span></a>
                                                        <h2><a href="#" class="product-link">Beats EP Wired On-Ear
                                                                Headphone-Black</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£93.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt"
                                                                    title="Add to cart" tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/16.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/16.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Bose SoundLink Micro
                                                                Bluetooth
                                                                Speaker</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/17.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Beats Solo2 Solo 2
                                                                Wired On-Ear
                                                                Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product-slider-item">
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/15.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <a class="inner-link" href="#"
                                                            tabindex="0"><span>Hewlett-Packard</span></a>
                                                        <h2><a href="#" class="product-link">Beats Solo Wireless
                                                                On-Ear
                                                                Headphone</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£453.28</li>
                                                            </ul>
                                                            <div class="cart-btn d-md-block d-none">
                                                                <a href="#" class="add-to-curt"
                                                                    title="Add to cart" tabindex="0"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn d-md-none">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"> <i class="icon-shopping-cart "></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                        <ul class="product-flag">
                                                            <li class="discount">-7%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">Apple iPad with
                                                                Retina Display
                                                                MD510LL/A </a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£73.28</li>
                                                                <li class="old-price">£75.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                            <article class=" product-layout list-product text-left">
                                                <div class="product-inner">
                                                    <div class="img-block">
                                                        <a href="#" class="thumbnail">
                                                            <img class="first-img"
                                                                src="{{ asset('frontend/assets/images/product-image/14.jpg') }}"
                                                                alt="" />
                                                            <img class="second-img"
                                                                src="{{ asset('frontend/assets/images/product-image/14.jpg') }}"
                                                                alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-decs">
                                                        <h2><a href="#" class="product-link">JBL Flip 3
                                                                Splashproof Portable
                                                                Bluetooth</a></h2>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                            <i class="ion-android-star color-gray"></i>
                                                        </div>
                                                        <div class="pricing-meta">
                                                            <ul>
                                                                <li class="current-price">£373.28</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    <a href="#" class="add-to-curt" title="Add to cart"
                                                        tabindex="0"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- Tab Slider End -->
                                </div>
                                <!-- 3rd tab -->
                            </div>
                            <!-- Tab Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Category Tab Slider Area End -->
    <!-- Blog Area Start -->
    {{-- <div class="main-blog-area mb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2><span>LATEST </span>BLOGS</h2>
                    </div>
                </div>
            </div>
            <!-- Blog Slider Start -->
            <div class="main-blog-slider-wrapper slider-nav-style-1">
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="#"><img src="{{asset('frontend/assets/images/blog-image/1.jpg')}}" alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">06</span>
                                    <span class="month-post">Sep</span>
                                    <span class="year-post">2020</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Buy Used Engines and Used
                                    Transmissions</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>It's no secret, engines and transmissions can be very expensive...</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="#"><img src="{{asset('frontend/assets/images/blog-image/2.jpg')}}" alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">30</span>
                                    <span class="month-post">Oct</span>
                                    <span class="year-post">2020</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Get Your Car or Truck Ready
                                    for the Summer Heat!</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>Summer is beautiful in Colorado but we can get some very, very, hot daytime temps...
                                    </p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="#"><img src="{{asset('frontend/assets/images/blog-image/3.jpg')}}" alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">08</span>
                                    <span class="month-post">Nov</span>
                                    <span class="year-post">2020</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Minor Wreck? We Got The Auto
                                    Parts!</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>It’s winter in Colorado and we’ve had a number of snowy days and hairy commutes...
                                    </p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="#"><img src="{{asset('frontend/assets/images/blog-image/4.jpg')}}" alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">30</span>
                                    <span class="month-post">Oct</span>
                                    <span class="year-post">2020</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">Purchasing New Auto Parts in
                                    our Online Store</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>Central Auto Parts has been a quality provider of used automotive parts in the
                                        Denver...</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
                <!-- Blog Slider Silgle Item -->
                <div class="blog-slider-item">
                    <div class="blog-slider-inner">
                        <div class="aritcles-image">
                            <a href="#"><img src="{{asset('frontend/assets/images/blog-image/5.jpg')}}" alt="blog-img"></a>
                            <p class="date-time-post">
                                <span>
                                    <span class="date-post">30</span>
                                    <span class="month-post">Oct</span>
                                    <span class="year-post">2020</span>
                                </span>
                            </p>
                        </div>
                        <div class="aritcles-content">
                            <div class="content-inner">
                                <a class="articles-name" href="blog-single-left-sidebar.html">The Life Cycle of Used Auto
                                    Parts and Wrecked Vehicles</a>
                                <p class="author-name">By <a href="https://hasthemes.com/">Hasthemes</a></p>
                                <div class="articles-intro">
                                    <p>I am often asked questions about my business when people find out what I do for a
                                        living.</p>
                                </div>
                                <a class="read-more" href="blog-single-left-sidebar.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Slider Silgle Item -->
            </div>
            <!-- Blog Slider End -->
        </div>
    </div> --}}
    <!-- Blog Area End -->
    <!-- Brand area start -->
    <x-sliders.brands.image>
        @foreach ($allBrands as $abrand)
            <x-sliders.brands.image.slide :href="route('shop.index', ['brands' => $abrand->slug])" :src="$abrand->getFirstMediaUrl('uploads')" :alt="$abrand->slug" />
        @endforeach
    </x-sliders.brands.image>
    <!-- Brand area end -->
@endsection
