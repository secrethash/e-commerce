@props(['title'])

<div class="feature-area mb-lm-60px">
    <div class="section-title">
        <h2>{!! $title !!}</h2>
    </div>
    <div class="feature-slider-wrapper slider-nav-style-1">
        {!! $slot !!}
        {{-- <article class="list-product text-left">
                <div class="product-inner">
                    <div class="img-block">
                        <a href="#" class="thumbnail">
                            <img class="first-img" src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                alt="" />
                            <img class="second-img" src="{{ asset('frontend/assets/images/product-image/13.jpg') }}"
                                alt="" />
                        </a>
                        <div class="add-to-link">
                            <ul>
                                <li>
                                    <a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a>
                                </li>
                                <li>
                                    <a href="compare.html" title="Add to compare"><i class="icon-repeat"></i></a>
                                </li>
                                <li>
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="icon-eye"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-decs">
                        <h2><a href="#" class="product-link">Amazon Cloud Cam Security Camera</a>
                        </h2>
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
                        <a href="#" class="add-to-curt" title="Add to cart"><i class="icon-shopping-cart"></i></a>
                    </div>
                </div>
            </article> --}}
    </div>
</div>
