
@props([
    'title',
])

<div class="hot-deal-area">
    <div class="section-title">
        <h2>{!! $title !!}</h2>
    </div>
    <div class="box-style">
        <div class="hot-deal-slider-wrapper slider-nav-style-1">
            {!! $slot !!}
        </div>
    </div>
</div>
