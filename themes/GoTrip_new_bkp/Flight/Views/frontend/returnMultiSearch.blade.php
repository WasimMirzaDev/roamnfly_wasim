@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/flight/css/flight.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <style>
        /* .container{
            max-width: 1400px;
            margin: 0 auto;
        } */
        .bravo_wrap .bravo_search_flight .bravo_form_search{
            margin-bottom: 0px;
        }
        .bravo_header{
            background:transparent !important; 
        }
    </style>
@endpush
@section('content')
    <div class="bravo_search_flight">
        <div class="container">
            <div class=" pt-20 pb-15">
                <div class="d-none text-center">
                    <h1 class="text-30 fw-600">
                        {{setting_item_with_lang("flight_page_search_title")}}
                    </h1>
                </div>

                @include('Flight::frontend.layouts.search.form-return-search')

            </div>
        </div>
        <span class="bgGradient"></span>
            <style>
                .bgGradient {
                    background-image: url('{{ asset('images/bg-airplane-search.jpg') }}');
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
        {{-- <div class="layout-pt-md layout-pb-md bg-light-2" style="position: relative; z-index:2 !important;"> --}}
            <div class="container">
                <div class="row">
                    {{-- <span class="bgGradient"></span> --}}
                    <div class="col-xl-3 col-lg-4">
                        @include('Flight::frontend.layouts.search.filter-search')
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        @include('Flight::frontend.layouts.return.search.mutli-list-item')
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
    <script>
        // Define initialData variable globally
        window.initialData = {
            adults: {{ Request::query('seat_type')['adults'] ?? 0 }},
            children: {{ Request::query('seat_type')['children'] ?? 0 }},
            infants: {{ Request::query('seat_type')['infants'] ?? 0 }},
            from_where: @json(Request::query('from_where', [])),
            to_where: @json(Request::query('to_where', [])),
            flight_seat: []
        };
    
        console.log(window.initialData);
    </script>
    @include('Flight::frontend.layouts.return.search.multi-modal-form-book')
    @include('Flight::frontend.layouts.return.search.flightFormSelectModalMulti')
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="{{ asset('themes/gotrip/module/flight/js/flight.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
