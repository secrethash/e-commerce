@props(['category', 'children'])
@aware(['current'])

@php
    $hasChildActive = false;
    if ($current) {
        // $callback = function($child) use($hasChildActive, $current) {
        //     if ($child->is($current)) {
        //         $hasChildActive = true;
        //     }
        //     $childHasChildren = Shopper\Framework\Models\Shop\Product\Category::where('parent_id', $child->id)->get();
        //     if($childHasChildren->count() >= 1) {
        //         $childHasChildren->each($callback);
        //     }
        //     return !$hasChildActive;
        // };
        // $children->each($callback);
    }
@endphp

@if ($children->count() >= 1)
    <div class="card">
        <div class="card-header" id="heading-{{ $category->slug }}">
            <a href="{{ route('shop.category', $category->slug) }}" data-bs-toggle="collapse"
                data-bs-target="#collapse-{{ $category->slug }}" aria-expanded="false"
                aria-controls="collapse-{{ $category->slug }}"
                @class([
                    "collapsed" => !($hasChildActive ?: $category->is($current)),
                ])>
                {{ $category->name }}
                ({{ $children->count() }})
            </a>
        </div>

        <div id="collapse-{{ $category->slug }}"
            aria-labelledby="heading-{{ $category->slug }}"
            data-parent="#categoriesAccordion"
            @class([
                "collapse",
                "show" => $category->is($current) OR $hasChildActive,
            ])>
            <div class="card-body">
                <ul class="category-list">
                    <li>
                        <a href="{{ route('shop.category', $category->slug) }}"
                            @class([
                                "text-danger" => $category->is($current),
                            ])>
                            {{ __('All Products in :Category', ['category' => $category->name]) }}
                        </a>
                    </li>
                    @foreach ($children as $child)
                        @php
                            $childrenOfChild = Shopper\Framework\Models\Shop\Product\Category::where('parent_id', $child->id)->get();
                        @endphp
                        <li>
                            @if ($childrenOfChild->count() >= 1)
                                <x-shop.sidebar.categories.element :category="$child" :children="$childrenOfChild" />
                            @else
                                <a href="{{ route('shop.category', $child->slug) }}"
                                    @class([
                                        "text-danger" => $child->is($current),
                                    ])>
                                    {{ $child->name }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div> <!-- card -->
@else
    <div class="card">
        <div class="card-header nochild" id="heading-{{ $category->slug }}">
            <a href="{{ route('shop.category', $category->slug) }}"
                @class([
                    "text-danger" => $category->is($current),
                ])>
                {{ $category->name }}
            </a>
        </div>
    </div>
@endif
