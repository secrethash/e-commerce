@props([
    'image',
    'title',
    'subtitle',
    'content',
    'animation' => 0,
    'position' => 'start',
    'button' => 'Shop Now',
    'action',
])

<!-- Single Slider  -->
<div class="single-slide slider-height-1 bg-img d-flex" data-bg-image="{{$image}}">
    <div class="container align-self-center">
        <div @class([
            "slider-content-1",
            "slider-animated-1" => $animation == 1,
            "slider-animated-2" => $animation == 2,
            "slider-animated-3" => $animation == 3,
            "text-left" => $position === 'start',
            "text-right" => $position === 'end',
            "text-center" => $position === 'center',
        ])>
            <span @class([
                "title",
                "theme-color" => $attributes->has('subtitle-color') && $attributes->get('subtitle-color') === 'theme',
                "color-white" => $attributes->get('subtitle-color') !== 'theme',
            ])>{!! $subtitle !!}</span>
            <h1 class="animated color-white">{!! $title !!}</h1>
            <p class="animated color-white">{!! $content !!}</p>
            <a href="{{$action}}" class="shop-btn animated">{{$button}}</a>
        </div>
    </div>
</div>
