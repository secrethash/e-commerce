
@props([
    'name',
    'link',
])

<div class="arrval-slider-item px-1">
    <article class="list-product text-left mx-1">
        <div class="product-inner bg-light shadow-sm border">
            <div class="product-decs text-center">
                <h6><a href="{{$link}}" class="product-link stretched-link">{{$name}}</a></h6>
            </div>
        </div>
    </article>
</div>
