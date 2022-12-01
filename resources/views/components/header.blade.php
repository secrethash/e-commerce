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
                                <li><a class="facebook ion-social-facebook" title="Facebook" href="#"></a></li>
                                <li><a class="twitter ion-social-twitter" title="Twitter" href="#"></a></li>
                                <li><a class="google ion-social-googleplus-outline" title="Google" href="#"></a>
                                </li>
                                <li><a class="youtube ion-social-youtube" title="Youtube" href="#"></a></li>
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
                                <li><a class="facebook ion-social-facebook" title="Facebook" href="#"></a></li>
                                <li><a class="twitter ion-social-twitter" title="Twitter" href="#"></a></li>
                                <li><a class="google ion-social-googleplus-outline" title="Google" href="#"></a>
                                </li>
                                <li><a class="youtube ion-social-youtube" title="Youtube" href="#"></a></li>
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
                                {{-- src="{{asset('frontend/assets/images/logo/manarat-logo.png')}}" --}} alt="manarat-logo" width="250" /></a>
                    </div>
                </div>
                <div class="col-md-9 align-self-center">
                    <div class="header-right-element d-flex justify-content-between">
                        <div class="search-element media-body mr-20px">
                            <form class="d-flex" action="#">
                                <input type="text" placeholder="Search entire store here ..." />
                                <button><i class="icon-search"></i></button>
                            </form>
                        </div>
                        <!--Cart info Start -->
                        <div class="header-tools d-flex align-items-center">
                            {{-- <div class="cart-info d-flex align-self-center me-3">
                                <a title="wishlist" href="#offcanvas-wishlist" class="heart offcanvas-toggle me-0" data-number="3">
                                    <i class="icon-heart"></i>
                                </a>
                            </div> --}}
                            @livewire('component.shop.wishlist')
                            @livewire('component.shop.cart')
                        </div>
                        <!--Cart info End -->
                        {{-- @livewire('component.shop.cart') --}}
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
                        {!! \App\Services\Menus::main() !!}
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
                    {{-- <div class="cart-info d-flex align-self-center me-3">
                        <a title="wishlist" href="#offcanvas-wishlist" class="heart offcanvas-toggle me-0" data-number="3">
                            <i class="icon-heart"></i>
                        </a>
                    </div> --}}
                    @livewire('component.shop.wishlist', ['for' => 'mobile'])
                    @livewire('component.shop.cart', ['for' => 'mobile'])
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
                    <form class="d-flex" action="#">
                        <input type="text" placeholder="Enter your search key ... " />
                        <button><i class="icon-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Search Category End -->
<div class="mobile-category-nav d-lg-none mb-15px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--=======  category menu  =======-->
                <div class="hero-side-category">
                    <!-- Category Toggle Wrap -->
                    <div class="category-toggle-wrap">
                        <!-- Category Toggle -->
                        <button class="category-toggle"><i class="fa fa-bars"></i> All Categories</button>
                    </div>

                    <!-- Category Menu -->
                    <nav class="category-menu">
                        {!! \App\Services\Menus::categories() !!}
                    </nav>
                </div>

                <!--=======  End of category menu =======-->
            </div>
        </div>
    </div>
</div>
<!-- Mobile Header Section End -->
<!-- OffCanvas Wishlist Start -->
{{-- <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
    <div class="inner">
        <div class="head">
            <span class="title">Wishlist</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
                <li>
                    <a href="single-product.html" class="image"><img
                            src="{{ asset('frontend/assets/images/product-image/1.jpg') }}"
                            alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Walnut Cutting Board</a>
                        <span class="quantity-price">1 x <span class="amount">£91.86</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img
                            src="{{ asset('frontend/assets/images/product-image/2.jpg') }}"
                            alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Lucky Wooden Elephant</a>
                        <span class="quantity-price">1 x <span class="amount">£453.28</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img
                            src="{{ asset('frontend/assets/images/product-image/3.jpg') }}"
                            alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Fish Cut Out Set</a>
                        <span class="quantity-price">1 x <span class="amount">£87.34</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="foot">
            <div class="buttons">
                <a href="wishlist.html" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
            </div>
        </div>
    </div>
</div> --}}
<!-- OffCanvas Wishlist End -->

{{-- <!-- OffCanvas Cart Start -->

<!-- OffCanvas Cart End --> --}}

<!-- OffCanvas Search Start -->
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner customScroll">
        <div class="head">
            <span class="title">&nbsp;</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="offcanvas-menu-search-form">
            <form action="#">
                <input type="text" placeholder="Search...">
                <button><i class="lnr lnr-magnifier"></i></button>
            </form>
        </div>
        <div class="offcanvas-menu">
            {!! \App\Services\Menus::mainMobile() !!}
        </div>
        <!-- OffCanvas Menu End -->
        <div class="offcanvas-social mt-30px">
            <ul>
                <li>
                    <a href="#"><i class="ion-social-facebook"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-twitter"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-google"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-youtube"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-instagram"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- OffCanvas Search End -->
<div class="contact-link d-lg-none">
    <a href="tel:(088)1234567">(088)1234567</a>
</div>
<div class="offcanvas-overlay"></div>
