
@props([
    'title',
])

<!-- Arrivel Area Start -->
<div class="arrival-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>{!! $title !!}</h2>
                </div>
            </div>
        </div>
        <div class="arrival-wrapper">
            <div class="arrival-slider slider-nav-style-1">
                {!! $slot !!}
            </div>
        </div>
    </div>
</div>
<!-- Arrivel Area End -->
