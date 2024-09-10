@extends('layouts.app')
@push('css')
    <link href="{{ asset('themes/gotrip/dist/frontend/module/hotel/css/hotel.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endpush
@section('content')
<style>
    .bravo_header{
            background:transparent !important; 
        }
</style>

{{-- <script>
window.addEventListener('scroll', function() {
    var header = document.querySelector('.bravo_header');
    if (window.scrollY > 0) {
        header.style.background = 'black';
        header.style.cssText += ';background-color:black !important;';
    } else {
        header.style.background = 'transparent';
        header.style.cssText += ';background-color:transparent !important;';
    }
});
</script> --}}
    <div class="bravo_search bravo_search_hotel">
        @if($layout != 'map')
        <section class=" @if($layout == 'grid') bg-blue-2 @endif">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        {{-- <div class="text-center">
                            <h1 class="text-30 fw-600">{{setting_item_with_lang("hotel_page_search_title")}}</h1>
                        </div> --}}
                        @include('Hotel::frontend.layouts.search.form-return-search', ['style' => 'default'])
                    </div>
                </div>
            </div>
        </section>
        @endif
        <span class="bgGradient"></span>
        <style>
            .bgGradient {
                background-image: url('{{ asset('images/bg-hotel-search3.jpg') }}');
                width: 100%;
                position: absolute;
                top: 0;
                left: 0;
                min-height: 368px;
                z-index: -1; /* Removed !important */
                background-size: cover; /* Cover the entire element */
                background-position: center; /* Center the image */
            }
        </style>
            
            <script>
                document.body.classList.add('bg-light-2');
            </script>

        <section class="layout-pt-md layout-pb-lg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        @include('Hotel::frontend.layouts.search.filter-search')
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        @include('Hotel::frontend.layouts.search.list-item', ['layout' => $layout])
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="{{ asset('module/hotel/js/hotel.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
