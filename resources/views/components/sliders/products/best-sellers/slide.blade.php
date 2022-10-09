
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
    'floats' => false, # Display Floating Buttons
    'flags' => false, # Display Flags
    'cart' => false, # Display Add to Cart Button
])


<x-sliders.products.common.slide />
