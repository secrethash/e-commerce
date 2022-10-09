<div>

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Shop</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- Shop Category Area End -->
    <div class="shop-category-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last col-md-12 order-md-first">


                    <!-- Shop Top Area Start -->
                    <div class="shop-top-bar">
                        <!-- Left Side start -->
                        <div class="shop-tab nav">
                            <a @class([
                                "active" => $layout == 'x3',
                                "grid-3",
                            ]) href="#shop-3" data-bs-toggle="tab" wire:click.prevent="changeLayout(3)">

                            </a>
                            {{-- <a class="grid-4" href="#shop-2" data-bs-toggle="tab">

                            </a> --}}
                            <a @class([
                                "active" => $layout == 'x1',
                                "list-views",
                            ]) href="#shop-1" data-bs-toggle="tab" wire:click.prevent="changeLayout(1)">

                            </a>
                        </div>
                        <div class="toolbar-amaount">
                            <p>Showing 1 to 9 of 20 (3 Pages)</p>
                        </div>
                        <div class="sorter">
                            <label for="input-limit">Sort By:</label>
                            <select>
                                <option value="">Default</option>
                                <option value="">Name (A - Z)</option>
                                <option value=""> Name (Z - A)</option>
                                <option value="">Price (Low > High)</option>
                                <option value="">Price (High > Low)</option>
                                <option value="">Rating (Highest)</option>
                                <option value="">Rating (Lowest)</option>
                                <option value="">Model (A - Z)</option>
                                <option value="">Model (Z - A)</option>
                            </select>
                        </div>
                        <div class="limiter">
                            <label for="input-limit">Show:</label>
                            <select>
                                <option value="">9</option>
                                <option value="">25</option>
                                <option value=""> 50</option>
                                <option value="">75</option>
                                <option value="">100</option>
                            </select>
                        </div>
                        <!-- Right Side End -->
                    </div>
                    <!-- Shop Top Area End -->

                    <!-- Shop Bottom Area Start -->
                    <div class="shop-bottom-area mt-35">
                        @if($layout=='x1')
                            <!-- x1 Start -->
                            <x-shop.layouts.x1>
                                @forelse ($products as $product)
                                    @php
                                        $productImages = $product->getMedia('uploads');
                                        $hover = null;
                                        $image = null;
                                    @endphp
                                    @foreach ($productImages as $productImage)
                                        @if ($loop->first)
                                            @php
                                                $image = $productImage->getUrl('thumb200x200');
                                            @endphp
                                        @elseif($loop->index === 1)
                                            @php
                                                $hover = $productImage->getUrl('thumb200x200');
                                            @endphp
                                        @else
                                            @break
                                        @endif
                                    @endforeach
                                    <x-shop.layouts.x1.item :image="$image" :hover="$hover" :new="$product->published_at > now()->subDays(15)" :name="$product->name"
                                        :ratings="$product->ratingPercent()" currency="" :price="$product->formattedPrice" link="#" :description="$product->description" />
                                @empty
                                    <x-shop.layouts.blank />
                                @endforelse
                            </x-shop.layouts.x1>
                            <!-- x1 End -->
                        @else
                            <!-- x3 Start -->
                            <x-shop.layouts.x3>
                                @forelse ($products as $product)
                                    @php
                                        $productImages = $product->getMedia('uploads');
                                        $hover = null;
                                        $image = null;
                                    @endphp
                                    @foreach ($productImages as $productImage)
                                        @if ($loop->first)
                                            @php
                                                $image = $productImage->getUrl('thumb200x200');
                                            @endphp
                                        @elseif($loop->index === 1)
                                            @php
                                                $hover = $productImage->getUrl('thumb200x200');
                                            @endphp
                                        @else
                                            @break
                                        @endif
                                    @endforeach
                                    <x-shop.layouts.x3.item :image="$image" :hover="$hover" :new="$product->published_at > now()->subDays(15)" :name="$product->name"
                                        :ratings="$product->ratingPercent()" currency="" :price="$product->formattedPrice" link="#" />
                                @empty
                                    <x-shop.layouts.blank />
                                @endforelse
                            </x-shop.layouts.x3>
                            <!-- x3 End -->
                        @endif
                        <!-- Shop Tab Content End -->
                        <!--  Pagination Area Start -->
                        <div class="pro-pagination-style mtb-50px">
                            {{-- <div class="pages">
                                <ul>
                                    <li>
                                        <a class="prev" href="#">|<i class="ion-ios-arrow-left"></i></a>
                                    </li>
                                    <li>
                                        <a class="prev" href="#"><i class="ion-ios-arrow-left"></i></a>
                                    </li>
                                    <li>
                                        <a class="prev" href="#">1</a>
                                    </li>
                                    <li><a class="active" href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li>
                                        <a class="next" href="#"><i class="ion-ios-arrow-right"></i></a>
                                    </li>
                                    <li>
                                        <a class="next" href="#"><i class="ion-ios-arrow-right"></i>|</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="toolbar-amaount">
                                <p>Showing 1 to 9 of 20 (3 Pages)</p>
                            </div> --}}
                            {{ $products->links() }}
                        </div>
                        <!--  Pagination Area End -->
                    </div>
                    <!-- Shop Bottom Area End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-md-60px mb-lm-60px">
                    <div class="shop-sidebar-wrap">
                        <x-shop.sidebar.categories title="CATEGORIES">
                            <x-shop.sidebar.categories.list
                                :categories="$categories"
                                :current="$category" />
                        </x-shop.sidebar.categories>
                        <!-- Sidebar single item -->
                        <div class="sidebar-widget-group bg-white mt-20">
                            <div class="sidebar-widget mt-20">
                            <h3 class="sidebar-title">FILLTER BY PRICE</h3>
                                <div class="price-filter">
                                    <div id="slider-range"></div>
                                    <div class="price-slider-amount">
                                        <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar single item -->
                            <div class="sidebar-widget mt-20">
                                <h3 class="sidebar-title">MANUFACTURER</h3>
                                <div class="sidebar-widget-list">
                                    <ul>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" /> <a href="#">Christian Dior<span>(6)</span> </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" value="" /> <a href="#">Diesel<span>(10)</span></a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" value="" /> <a href="#">ferragamo<span>(13)</span> </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" value="" /> <a href="#">hermes<span>(17)</span> </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" value="" /> <a href="#">louis vuitton<span>(16)</span> </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" value="" /> <a href="#">Tommy Hilfiger<span>(0)</span> </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" value="" /> <a href="#">Versace<span>(0)</span> </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Sidebar single item -->
                            <div class="sidebar-widget mt-30 b-b-0">
                                <h3 class="sidebar-title">SELECT BY COLOR</h3>
                                <div class="sidebar-widget-list-column">
                                    <div class="sidebar-widget-list">
                                        <ul>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" /> <a href="#">Black<span>(6)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Blue<span>(7)</span></a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Brown<span>(4)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Green<span>(9)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="sidebar-widget-list">
                                        <ul>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" /> <a href="#">Pink<span>(7)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Red<span>(7)</span></a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">White<span>(9)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="" /> <a href="#">Yellow<span>(10)</span> </a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
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
    <!-- Shop Category Area End -->
</div>
