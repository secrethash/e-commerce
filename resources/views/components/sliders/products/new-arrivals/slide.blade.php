
@props([
    'image', # Default Product Image
    'hover', # Hover Image
    'new' => false, # is a new product?
    'discount' => null, # is discounted
    'name', # Product Name
    'ratings' => 0, # Total Ratings
    'currency', # Product's Currency
    'price', # Product's Price
    'link', # Link to Product's Page
    'countdown' => null, # has countdown
    'floats' => true, # Display Floating Buttons
    'flags' => true, # Display Flags
])

<div class="arrval-slider-item">
    <x-sliders.products.common.slide />
</div>
