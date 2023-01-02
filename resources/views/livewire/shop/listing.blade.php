<div>
    {{-- @dump($products) --}}
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
                    <div class="shop-top-bar mb-2">
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
                            {{-- <p>Showing 1 to 9 of 20 (3 Pages)</p> --}}
                        </div>
                        {{-- <div class="sorter">
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
                        </div> --}}
                        <div class="limiter">
                            <label for="input-limit">Show:</label>
                            <select wire:model='per_page'>
                                <option value="9">9</option>
                                <option value="25">25</option>
                                <option value="50"> 50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <!-- Right Side End -->
                    </div>
                    <!-- Shop Top Area End -->

                    @if ($resetFilter)
                        <div class="row justify-content-between align-items-end mb-3 mx-1">
                            <div class="col">
                                @if (!blank($brands))
                                    <div class="d-block my-1">
                                        <h6 class="fw-light ms-2">Brands</h6>
                                        <button class="btn btn-danger btn-sm rounded-pill" type="button">
                                            <x-heroicon-o-filter width="18" />
                                            {{$brands}}
                                            <span class="badge bg-light text-danger rounded-circle p-1">
                                                <x-heroicon-s-x width="14" />
                                            </span>
                                        </button>
                                    </div>
                                @endif
                                @if (!blank($searchQuery))
                                    <div class="d-block my-1">
                                        <h6 class="fw-light ms-2">Search</h6>
                                        <button class="btn btn-primary btn-sm rounded-pill" type="button">
                                            <x-heroicon-o-search width="18" />
                                            {{$searchQuery}}
                                            <span class="badge bg-light text-primary rounded-circle p-1">
                                                <x-heroicon-s-x width="14" />
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="col d-flex justify-content-end align-items-start">
                                <!-- Reset Filters -->
                                <div class="d-block text-end">
                                    <a href="{{ route('shop.index') }}" class="btn btn-small btn-dark rounded-pill">
                                        <x-heroicon-o-x-circle width="18" />
                                        {{ __('Reset Filter') }}
                                    </a>
                                </div>
                                <!-- Reset Filters -->
                            </div>
                        </div>
                    @endif

                    <!-- Shop Bottom Area Start -->
                    <div class="shop-bottom-area mt-35">
                        @if($layout=='x1')
                            <!-- x1 Start -->
                            <x-shop.layouts.x1>
                                @forelse ($products as $product)
                                    @php
                                        $images = product_images($product);
                                    @endphp
                                    <x-shop.layouts.x1.item :image="$images->thumb" :hover="$images->hover" :new="$product->published_at > now()->subDays(15)" :name="$product->name"
                                        :ratings="$product->ratingPercent()" currency="" :price="$product->formattedPrice" :link="route('shop.product', $product->slug)"
                                        :description="$product->description" :product="$product" :key="$product->slug" />
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
                                        $images = product_images($product);
                                    @endphp
                                    <x-shop.layouts.x3.item :image="$images->thumb" :hover="$images->hover" :new="$product->published_at > now()->subDays(15)" :name="$product->name"
                                        :ratings="$product->ratingPercent()" currency="" :price="$product->formattedPrice" :link="route('shop.product', $product->slug)"
                                        :product="$product" :key="$product->slug" />
                                @empty
                                    <x-shop.layouts.blank />
                                @endforelse
                            </x-shop.layouts.x3>
                            <!-- x3 End -->
                        @endif
                        <!-- Shop Tab Content End -->
                        <!--  Pagination Area Start -->
                        <div class="mtb-50px">
                            {!! $products->links() !!}
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
                            {{-- <div class="sidebar-widget mt-20">
                                <h3 class="sidebar-title">FILLTER BY PRICE</h3>
                                <div class="price-filter">
                                    <div id="slider-range"></div>
                                    <div class="price-slider-amount">
                                        <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                    </div>
                                </div>
                            </div> --}}
                            <!-- Sidebar single item -->
                            <div class="sidebar-widget mt-20">
                                <h3 class="sidebar-title">{{ __('Car Brands') }}</h3>
                                <div class="sidebar-widget-list">
                                    <ul>
                                        {{-- <li>{{ var_export($brands) }}</li> --}}
                                        @foreach ($carBrands as $carBrand)
                                            <li>
                                                {{-- <div class="sidebar-widget-list-left"> --}}
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                            type="checkbox"
                                                            id="car-brand-{{$carBrand->slug}}"
                                                            value="{{$carBrand->slug}}"
                                                            wire:model="selectedBrands">
                                                        <label class="form-check-label" for="car-brand-{{$carBrand->slug}}">
                                                            {{$carBrand->name}}
                                                        </label>
                                                    </div>
                                                {{-- </div> --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- Sidebar single item -->
                            <div class="sidebar-widget mt-30 b-b-0">
                                <h3 class="sidebar-title">{{ __('Aftermarket Brands') }}</h3>
                                <div class="sidebar-widget-list">
                                    <ul>
                                        @foreach ($aftermarketBrands as $aftermarketBrand)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        id="aftermarket-brand-{{$aftermarketBrand->slug}}"
                                                        value="{{$aftermarketBrand->slug}}"
                                                        wire:model="selectedBrands">
                                                    <label class="form-check-label" for="aftermarket-brand-{{$aftermarketBrand->slug}}">
                                                        {{$aftermarketBrand->name}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
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

@push('lw-scripts')
    <script type="text/javascript">
        // $('input[name="carbrands[]"]').on('change', function(e) {
        //     @this.call('', $(e.target).val());
        // })
    </script>
@endpush
