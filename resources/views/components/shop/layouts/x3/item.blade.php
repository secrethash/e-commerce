@props([
    'image', # Default Product Image
    'hover', # Hover Image
    'new' => false, # is a new product?
    'discount' => null, # is discounted
    'name', # Product Name
    'ratings' => 0, # Total Ratings
    'currency', # Product's Currency
    'price', # Product's Price
    'orignal' => null, # Old Price (if price dropped)
    'link', # Link to Product's Page
    'countdown' => null, # has countdown
    'floats' => true, # Display Floating Buttons
    'flags' => true, # Display Flags
    'cart' => true, # Display Add to Cart Button
    'product',
])


<div class="mb-30px col-md-4 col-sm-6  p-0">
    <div class="slider-single-item">
        <!-- Single Item -->
        <x-sliders.products.common.slide />
        <!-- Single Item -->
    </div>
</div>
