
@props([
    'title',
])

<div class="best-sell-area">
    <div class="section-title">
        <h2>{!! $title !!}</h2>
    </div>
    <div class="best-sell-slider-wrapper bg-white slider-nav-style-1">
        {!! $slot !!}
    </div>
</div>
