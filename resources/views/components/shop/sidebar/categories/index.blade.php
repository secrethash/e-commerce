
@props(['title'])

<div class="sidebar-widget mb-30px bg-white">
    <h3 class="sidebar-title">{!! $title !!}</h3>
    <div class="accordion" id="categoriesAccordion">
        {!! $slot !!}
    </div>
</div>
