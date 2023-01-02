<!-- JavaScript Includes
    ============================================ -->

<!-- Vendors JS -->
<script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>

<!-- Plugins JS -->
<script src="{{ asset('frontend/assets/js/plugins/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/countdown.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/elevateZoom.js') }}"></script>

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
{{-- <script src="{{asset('frontend/assets/js/vendor/vendor.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/plugins/plugins.min.js')}}"></script> --}}

<!-- Main Activation JS -->
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

@livewireScripts
@stack('lw-scripts')

<!-- BEGIN: Custom Components -->
@include('components.notice')
{{-- @livewire('common.notice.toastr') --}}
<script src="{{ asset('frontend/assets/js/notice-toastr.js') }}"></script>

