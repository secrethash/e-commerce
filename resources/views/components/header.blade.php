<!-- Header Section Start From Here -->
<header class="header-wrapper">
    <!-- Header Nav Start -->
    <div class="header-nav bg-black d-none d-md-block">
        <div class="container">
            <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between">
                <div class="header-static-nav d-flex">
                    <p>WELCOME TO MANARAT ONLINE SHOPPING STORE !</p>
                    <div class="social-top">
                        <div class="follow d-flex">
                            <label>Follow Us:</label>
                            <ul class="link-follow">
                                @if(!blank(shopper_setting('shop_facebook_link')))
                                    <li><a class="facebook ion-social-facebook" title="Facebook" href="{{shopper_setting('shop_facebook_link')}}"></a></li>
                                @endif
                                @if(!blank(shopper_setting('shop_twitter_link')))
                                    <li><a class="twitter ion-social-twitter" title="Twitter" href="{{shopper_setting('shop_twitter_link')}}"></a></li>
                                @endif
                                @if(!blank(shopper_setting('shop_instagram_link')))
                                    <li><a class="instagram ion-social-instagram-outline" title="Instagram" href="{{shopper_setting('shop_instagram_link')}}"></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-menu-nav">
                    <ul class="menu-nav">
                        <li>
                            <div class="dropdown">
                                @guest
                                    <button type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" class="d-flex align-items-center justify-content-between">
                                        {{-- <i class="icon-myaccount ion-android-person"></i> --}}
                                        <x-ri-login-circle-fill width="20" class="me-1" />
                                        <span>Login / Signup</span>
                                        <i class="ion-ios-arrow-down"></i>
                                    </button>

                                    <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                        <li><a href="{{route('register')}}">Register</a></li>
                                        <li><a href="{{route('login')}}">Login</a></li>
                                    </ul>
                                @endguest
                                @auth
                                    <button type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" class="d-flex align-items-center justify-content-between">
                                        {{-- <i class="icon-myaccount ion-android-person"></i> --}}
                                        <x-ri-user-smile-fill width="20" class="me-1" />
                                        <span>Hello, {{ auth()->user()->first_name }}</span>
                                        <i class="ion-ios-arrow-down"></i>
                                    </button>

                                    <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                            <li><a href="{{route('user.account')}}">My Account</a></li>
                                            <li><a href="{{route('user.orders')}}">Order History</a></li>
                                            @can('access_dashboard')
                                                <li><a href="{{route('shopper.dashboard')}}">Console</a></li>
                                            @endcan
                                            @can('can_view_backend')
                                                <li><a href="{{route('filament.pages.dashboard')}}">Admin</a></li>
                                            @endcan
                                            <li><a href="{{route('logout.link')}}">Logout</a></li>
                                    </ul>
                                @endauth
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Header Nav Start -->

    <div class="header-nav header-nav-mobile bg-black d-md-none">
        <div class="container">
            <div class="header-nav-wrapper ">
                <div class="header-static-nav f-none text-center">
                    <p>WELCOME TO MANARAT ONLINE SHOPPING STORE !</p>
                </div>
                <div class="header-menu-nav d-flex justify-content-between">
                    <div class="social-top align-self-center">
                        <div class="follow d-flex">
                            <label>Follow Us:</label>
                            <ul class="link-follow">
                                @if(!blank(shopper_setting('shop_facebook_link')))
                                    <li><a class="facebook ion-social-facebook" title="Facebook" href="{{shopper_setting('shop_facebook_link')}}"></a></li>
                                @endif
                                @if(!blank(shopper_setting('shop_twitter_link')))
                                    <li><a class="twitter ion-social-twitter" title="Twitter" href="{{shopper_setting('shop_twitter_link')}}"></a></li>
                                @endif
                                @if(!blank(shopper_setting('shop_instagram_link')))
                                    <li><a class="instagram ion-social-instagram-outline" title="Instagram" href="{{shopper_setting('shop_instagram_link')}}"></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="mobile-menu-nav">
                        <ul class="menu-nav">
                            <li>
                                <div class="dropdown">
                                    @guest
                                        <button type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false" class="d-flex align-items-center justify-content-between">
                                            <x-ri-login-circle-fill width="20" class="me-1" />
                                            <span>Login / Signup</span>
                                            <i class="ion-ios-arrow-down"></i>
                                        </button>

                                        <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                            <li><a href="{{route('register')}}">Register</a></li>
                                            <li><a href="{{route('login')}}">Login</a></li>
                                        </ul>
                                    @endguest
                                    @auth
                                        <button type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false" class="d-flex align-items-center justify-content-between">
                                            {{-- <i class="icon-myaccount ion-android-person"></i> --}}
                                            <x-ri-user-smile-fill width="20" class="me-1" />
                                            <span>Hello, {{ auth()->user()->first_name }}</span>
                                            <i class="ion-ios-arrow-down"></i>
                                        </button>

                                        <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                                <li><a href="{{route('user.account')}}">My Account</a></li>
                                                <li><a href="{{route('user.orders')}}">Order History</a></li>
                                                @can('access_dashboard')
                                                    <li><a href="{{route('shopper.dashboard')}}">Console</a></li>
                                                @endcan
                                                @can('can_view_backend')
                                                    <li><a href="{{route('filament.pages.dashboard')}}">Admin</a></li>
                                                @endcan
                                                <li><a href="{{route('logout.link')}}">Logout</a></li>
                                        </ul>
                                    @endauth
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Header Nav End -->
    <!-- Header Nav End -->
    <div class="header-top bg-white ptb-30px d-lg-block d-none">
        <div class="container">
            <div class="row">
                <div class="col-md-3 d-flex">
                    <div class="logo align-self-center">
                        <a href="{{ route('home') }}"><img class="img-responsive" src="{{ asset('images/logo.svg') }}"
                            alt="manarat-logo" width="250" /></a>
                    </div>
                </div>
                <div class="col-md-9 align-self-center">
                    <div class="header-right-element d-flex justify-content-between">
                        <div class="search-element media-body mr-20px">
                            <livewire:component.search />
                        </div>
                        <!--Cart info Start -->
                        <div class="header-tools d-flex align-items-center">
                            @livewire('component.shop.wishlist', [], key('wishlist-xl'))
                            @livewire('component.shop.cart', [], key('cart-xl'))
                        </div>
                        <!--Cart info End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Menu Starts -->
    <div class="header-menu bg-red sticky-nav d-lg-block d-none padding-0px">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="header-horizontal-menu">
                        {!! $customMenu()->main() !!}
                    </div>
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- header Menu Ends -->
</header>
<!-- Header Section End Here -->

<!-- Mobile Header Section Start -->
<div class="mobile-header d-lg-none sticky-nav white-bg ptb-20px">
    <div class="container">
        <div class="row align-items-center">

            <!-- Header Logo Start -->
            <div class="col d-flex">
                <div class="mobile-menu-toggle home-2">
                    <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                        <svg viewBox="0 0 800 600">
                            <path
                                d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                id="top"></path>
                            <path d="M300,320 L540,320" id="middle"></path>
                            <path
                                d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="header-logo">
                    <a href="{{ route('home') }}"><img class="img-responsive" src="{{ asset('images/logo.svg') }}"
                            alt="manarat-logo" width="150"></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Header Tools Start -->
            <div class="col-auto">
                <div class="header-tools d-flex justify-content-end align-items-center">
                    @livewire('component.shop.wishlist', ['for' => 'mobile'], key('wishlist-mobile'))
                    @livewire('component.shop.cart', ['for' => 'mobile'], key('cart-mobile'))
                </div>
            </div>
            <!-- Header Tools End -->
        </div>
    </div>
</div>

<!-- Search Category Start -->
<div class="mobile-search-area d-lg-none mb-15px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="search-element media-body">
                    <livewire:component.search />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Header Section End -->

<!-- OffCanvas Search Start -->
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner customScroll">
        <div class="head">
            <span class="title">&nbsp;</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="offcanvas-menu">
            {!! $customMenu()->mainMobile() !!}
        </div>
        <!-- OffCanvas Menu End -->
        <div class="offcanvas-social mt-30px">
            <ul>
                @if(!blank(shopper_setting('shop_facebook_link')))
                    <li>
                        <a title="Facebook" href="{{shopper_setting('shop_facebook_link')}}">
                            <i class="ion-social-facebook"></i>
                        </a>
                    </li>
                @endif
                @if(!blank(shopper_setting('shop_twitter_link')))
                    <li>
                        <a title="Twitter" href="{{shopper_setting('shop_twitter_link')}}">
                            <i class="ion-social-twitter"></i>
                        </a>
                    </li>
                @endif
                @if(!blank(shopper_setting('shop_instagram_link')))
                    <li>
                        <a title="Instagram" href="{{shopper_setting('shop_instagram_link')}}">
                            <i class="ion-social-instagram"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- OffCanvas Search End -->
<div class="contact-link d-lg-none">
    <a href="tel:{{shopper_setting('shop_phone_number')}}">{{shopper_setting('shop_phone_number')}}</a>
</div>
<div class="offcanvas-overlay"></div>
