
@props([
    'categories' => collect([]),
])

@forelse ($categories as $category)
    @php
        $children = Shopper\Framework\Models\Shop\Product\Category::where('parent_id', $category->id)->get();
    @endphp
    <x-shop.sidebar.categories.element
        :category="$category"
        :children="$children" />
@empty

@endforelse
