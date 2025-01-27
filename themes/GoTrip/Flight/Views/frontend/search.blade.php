@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/flight/css/flight.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <style>
        .bravo_wrap .bravo_search_flight .bravo_form_search{
            margin-bottom: 0px;
        }
        .bravo_header{
            background:transparent !important; 
        }
        @media (max-width: 992px) {
    .bravo-search-container {
        max-height: 385px !important;
        height: 100% !important;
        overflow-y: scroll !important;
        margin-bottom: 20px;
    }
}
    </style>
@endpush
@section('content')
    <div class="bravo_search_flight">
        <div class="container bravo-search-container">
            <div class=" pt-lg-20 pb-15">
                <div class="text-center d-none">
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
                    background-image: linear-gradient(270deg, rgba(5, 16, 54, 0.5) 0%, #051036 72.43%), url('{{ asset('images/bg-airplane-search.jpg') }}');
                    width: 100%;
                    position: absolute;
                    top: 0;
                    left: 0;
                    min-height: 485px !important;
                    z-index: -1; 
                    background-size: cover; 
                    background-position: center; 
                }
            </style>
        {{-- <div class="layout-pt-md layout-pb-md bg-light-2" style="position: relative; z-index:-2 !important;"> --}}
<script>
    document.body.classList.add('bg-light-2');
</script>
            <div class="container" style="">
                <div class="row" >
                    {{-- <div class="col-xl-3 col-lg-4">
                        @include('Flight::frontend.layouts.search.filter-search')
                    </div> --}}
                    <div class="col-xl-12 col-lg-12">
                        @include('Flight::frontend.layouts.search.list-item')
                        
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
    @if(Request::query('travel_type') == "Multicity")
    @include('Flight::frontend.layouts.return.search.multi-modal-form-book')
    @include('Flight::frontend.layouts.return.search.flightFormSelectModalMulti')
    @elseif (Request::query('travel_type') == "Round Trip")
    @include('Flight::frontend.layouts.return.search.modal-form-book')
    @elseif (Request::query('travel_type') == "One Way")
    @include('Flight::frontend.layouts.search.modal-form-book')
    @endif
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="{{ asset('themes/gotrip/module/flight/js/flight.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
