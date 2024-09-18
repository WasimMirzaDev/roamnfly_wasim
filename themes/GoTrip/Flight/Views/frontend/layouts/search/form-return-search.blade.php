@php
$style = $style ?? 'default';
$classes =
' form-search-all-service mainSearch -col-5 border-light rounded-4 pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 mt-15';
$button_classes = ' -dark-1 py-15 col-12 bg-blue-1 text-white w-100 rounded-4';
if ($style == 'sidebar') {
$classes = ' form-search-sidebar';
$button_classes = ' -dark-1 py-15 col-12 bg-blue-1 h-60 text-white w-100 rounded-4';
}
if ($style == 'normal') {
$classes =
' px-20 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-100 form-search-all-service mainSearch -w-900 bg-white';
$button_classes = ' -dark-1 py-15 h-60 col-12 rounded-100 bg-blue-1 text-white w-100';
}
if ($style == 'normal2') {
$classes = 'mainSearch bg-white pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 shadow-1';
$button_classes = ' -dark-1 py-15 h-60 col-12 rounded-100 bg-blue-1 text-white w-100';
}
if ($style == 'carousel_v2') {
$classes = ' w-100';
$button_classes = ' -dark-1 py-15 px-35 h-60 col-12 rounded-4 bg-yellow-1 text-dark-1';
}
if ($style == 'flightCarousel') {
$classes = ' w-100';
$button_classes = ' -dark-1 py-15 col-12 bg-blue-1 h-60 text-white w-100 rounded-4';
}
@endphp



<?php
$attr = "travel-type";
$inputName = "travel_type";
?>
    <div id="loader" class="" style="display:none; position:absolute; top:50%; left:50%;">
        <i class="fa fa-spinner fa-spin" style="font-size: 70px;"></i>
    </div>
    {{-- bravo_form_search --}}
<form action="{{ route('flight.search') }}" class="gotrip_form_search  bravo_form form {{ $classes }}" method="get">
    {{-- @php dd($field) @endphp --}}
    @php
    $flight_search_fields = setting_item_array('flight_search_fields');
    // dd($flight_search_fields);
    $flight_search_fields = array_values(
    \Illuminate\Support\Arr::sort($flight_search_fields, function ($value) {
    return $value['position'] ?? 0;
    }),
    );

    $travelType = request('travel_type');
    $fromWhere = request('from_where', []);
    $toWhere = request('to_where', []);
    $dateRange = request('date');
    $SeatTypee = request('seat_type', []);
    @endphp

    <script>
        // Define initialData variable globally
        window.initialData = {
            adults: {{
                    Request::query('seat_type')['adults'] ?? 0
                }},
            children: {{
                    Request::query('seat_type')['children'] ?? 0
                }},
            infants: {{
                    Request::query('seat_type')['infants'] ?? 0
                }},
            flight_seat: []
        };
        console.log(window.initialData);
    </script>
    <Style>
        .bravo_wrap .form-search-all-service .tabs__pane.-tab-item-flight .bravo_form {
            max-width: 100% !important;
            width: 100%;
            padding: 95px 0px 4rem 0px !important;
        }

        .gotrip_form_search {
            padding: 1rem 0 !important;
            display: block !important;
            height: auto !important;
        }

        .adjust-border {
            height: 120px !important;
        }

        .hotel-heading {
            text-align: center;
            color: #8f8f8f;
            font-weight: 500;
            font-size: 20px;
        }

        .smart-search-location,
        .js-first-date,
        .js-last-date,
        .render .adults,
        .render .children,
        .render {
            font-size: 16px !important;
            color: #dfdfdf !important;
        }

        .bravo_wrap .gotrip_form_search .field-items>.row>div:not(:nth-last-child()) {
            padding: 5px 9px 0 !important;

        }

        .field-items h4 {
            font-size: 14px !important;

        }

        .field-items .row {
            height: 100% !important;
        }

        .searchMenu-loc__field>div {

            position: fixed !important;
            box-shadow: 0 10px 10px #dfd6d6
        }


        .header-row {}

        .check-in-out-render {
            & span {

                font-size: 15px !important;
            }
        }

        .col-lg-2 {
            & button {
                position: relative;
                top: 20px;
                left: 5px;
                padding: 5px 10px;
            }
        }

    
        .bravo_wrap .bravo_search_flight .bravo_form_search {
            display: flex;
            justify-content: space-between;
            align-items: start;

        }

        .tabs.-underline .tabs__controls .tabs__button::after {
            background-color: var(--color-dark-1);
        }

        .button-city-add {
            background: transparent !important;
            color: var(--color-dark-1);
            border: 1px solid var(--color-dark-1);
            border-radius: 4px;
            padding: 20px !important;
            margin-top: 10px
        }

        .gotrip_form_search {
            padding: 0px !important;
            border: none !important;

        }

        .border-light {
            border: none;
        }

        .field-items {
padding: 0 !important;
margin: 7px 0 !important;
            .row {
                color: white;
                gap: 10px !important;

                .col-lg-2,
                .col-lg-3,
                .col-lg-1 {
                    background: hsl(0deg 0.84% 30.33% / 45%) !important;
                    border-radius: 4px !important;
                }
            }
        }
        #search-title {
            display: none;
        }

        .header-row {
            gap: 10px !important;
            background: none;

            .col-lg-2,
            .col-lg-3 {
                background: hsl(0deg 0.84% 30.33% / 45%) !important;
                border-right: none !important;
                border-radius: 4px;
                padding: 5px 9px 0 !important;
            }
        }

        .js-search::placeholder {
            color: #dfdfdf !important;
        }

        .js-search {
            color: #dfdfdf !important;
        }

        #multiCityDiv1,
        #multiCityDiv2,
        #multiCityDiv3,
        #multiCityDiv4,
        #multiCityDiv5 {
            margin: 0 !important;
            max-width: 1181px !important;
            border: none !important;
        }

        .button-city-add {
            margin: 0 !important;
            top: 2px !important;
            left: 0 !important;
        }

        .trip-heading {
            & h4 {
                padding: 13.5px 10px
            }
        }

        .last-tab {
            position: fixed !important;
            color: black;

            .row {
                color: var(--color-dark-1);
            }
        }

        .btn-non {
            display: none !important;
        }

        @media (max-width: 992px) {
            .button-no-one {
                display: none !important;
            }

            .bgGradient {
                min-height: 485px !important;
            }

            .button-item-one {
                margin-top: 20px !important;
            }



            .col-lg-2,
            .col-lg-3 {

                padding: 10px 10px 0 !important;
              
            }

            .button-no-two {
                padding: 0 !important;
                border: none !important;
            }

            .bravo_wrap .gotrip_form_search .field-items>.row>div:last-child {
                padding: 0 !important;
            }

    

            .btn-non {
                display: block !important;
            }
        }

   
        .card-item-two {
            display: none;

            .custom-div-width {
                max-width: 33%;
                width: 100%;
            }

        }

        @media (max-width: 1200px) {
            .card-item-one {
                display: none !important;
            }

            .card-item-two {
                display: inline-block !important;
                width: 100%;
            }
.bravo_search_flight{
    .mainSearch__submit{
       
        .text-search{
            font-size: 13px;
        }
     
    }
}






        }
        .icon-search:before{
            font-size: 17px;
        } 
        .icon-search{
            margin-right: 3px !important;
        }
        @media (max-width: 450px) {
            .two-dives-wrapper {
.div-wrapper-1,
.btn-flight-content {
    flex-direction: column;
}
.btn-flight-content{
    & div{
        text-align: center;
    }
}
.accordion__button {
    & a{
        height: 32px !important;
    }
}

}
.bar-line{
    display: none !important;
}
.div-wrapper-2 {
margin-top: 18px ;
.row {
display:  flex !important;
justify-content: space-between;
    .custom-div-width {
        max-width: 50%;
    }
}
}
    }
.button-city-add{
    padding: 22px 20px !important;
}







    </style>

    <script>
        if (window.location.pathname === '/flight') {
            document.styleSheets[0].addRule('.bravo_wrap .bravo_search_flight .bravo_form_search',
                'margin-top: 10px !important;');
            document.styleSheets[0].addRule('.bravo_wrap .gotrip_form_search .field-items:nth-child(1)',
                'padding: 0px 0px 0px !important');
        }
    </script>



    {{-- <div class="w-100" id="multiCityDivContainer">
        <div class="col-md-12">
            @if (!empty($attr) and !empty(($attr = \Modules\Core\Models\Attributes::where('slug', $attr)->first())))
            <div class="searchMenu-loc js-form-dd js-liverSearch item"> --}}
    {{-- <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span>
                <div data-x-dd-click="searchMenu-loc"  class="d-none">
                    <h4 class="text-15 fw-500 ls-2 lh-16">{{ $attr->name }}</h4>
    <div class="text-15 text-light-1 ls-2 lh-16 smart-search"> --}}
        <!-- Retrieve value from URL or set to empty -->
        {{-- <input type="hidden" id="{{ $inputName }}" name="{{ $inputName }}" class="js-search-get-id" value="{{ Request::query($inputName) ?? '' }}"> --}}
        <!-- Display selected term name or placeholder -->
        {{-- <input type="text"  autocomplete="off" readonly class="smart-search-location parent_text js-search js-dd-focus" 
                            placeholder="{{ __('Select Type') }}"
        value="{{ optional($attr->terms->where('name', Request::query($inputName))->first())->name ?? '' }}">
    </div>
    </div>
    <div data-x-dd="searchMenu-loc">
        <div>
            <div class="y-gap-5 js-results">
                <div class="d-flex ms-4" style="color: black; font-size:18px;">
                    @foreach ($attr->terms as $term)
                    @php $translate = $term->translate(); @endphp
                    <div class=" js-search-option getMultiRow" data-id="{{ $translate->name }}">
                        <div class="d-flex ms-4" style="justify-content: center;" onclick="document.getElementById('{{$translate->name}}').checked = true;">
                            <input type="radio" id="{{$translate->name}}" class="me-2" name="travel_type_extra" value="{{$translate->name}}">
                            <label for="{{$translate->name}}" style="white-space: nowrap;" class="js-search-option-target">{{ $translate->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
    @endif --}}





    {{--
<div class="d-flex ms-4" style="color: black; font-size:18px;">
    <div class="d-flex ms-4" style="justify-content: center;">
        <input type="radio" id="one-way" class="me-2" name="travel_type" value="one-way">
        <label for="one-way" style="white-space: nowrap;">One Way</label>
    </div>
    <div class="d-flex ms-4" style="justify-content: center;">
        <input type="radio" id="round-trip" class="me-2" name="travel_type" value="round-trip">
        <label for="round-trip" style="white-space: nowrap;">Round Trip</label>
    </div>
    <div class="d-flex ms-4" style="justify-content: center;">
        <input type="radio" id="multi-city" class="me-2" name="travel_type" value="multi-city">
        <label for="multi-city" style="white-space: nowrap;">Multi City</label>
    </div>
</div> --}}
    {{-- < class="w-100" id="multiCityDivContainer"> --}}
    {{-- <div class="col-md-12"> --}}
    <div class="row field-items " style="margin: 0px auto;">
        <div class="col-lg-11 p-0">
            @if (!empty($flight_search_fields))
            <div class="row w-100 m-0 adjust-border header-row" style="color: var(--color-dark-1);; ">
                <style>
                    .js-results {
                        display: block !important;
                    }
                </style>


                {{-- @php$attr = 'travel-type';
                        $inputName = 'travel_type';
                    @endphp --}}
                <div class="col-lg-2 align-self-center px-10 lg:py-5 lg:px-0 ">
                    @if (!empty($attr) and !empty(($attr = \Modules\Core\Models\Attributes::where('slug', $attr)->first())))
                    <div class="searchMenu-loc js-form-dd js-liverSearch item">
                        <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span>
                        <div data-x-dd-click="searchMenu-loc">
                            <h4 class="text-15 fw-500 ls-2 lh-16">{{ $attr->name }}</h4>
                            <div class="text-15 text-light-1 ls-2 lh-16 smart-search">
                                <input type="hidden" id="{{ $inputName }}" name="{{ $inputName }}"
                                    class="js-search-get-id" value="{{ Request::query($inputName) ?? '' }}">
                                <!-- Display selected term name or placeholder -->
                                <input type="text" autocomplete="off" readonly
                                    class="smart-search-location parent_text js-search js-dd-focus"
                                    placeholder="{{ __('Select Type') }}"
                                    value="{{ optional($attr->terms->where('name', Request::query($inputName))->first())->name ?? '' }}">
                            </div>
                        </div>
                        <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc"
                            data-x-dd-toggle="-is-active">
                            <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                <div class="y-gap-5 js-results">
                                    @foreach ($attr->terms as $term)
                                    @php $translate = $term->translate(); @endphp
                                    <div class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option getMultiRow"
                                        data-id="{{ $translate->name }}">
                                        <div class="d-flex align-items-center">
                                            <div class="{{ $term->icon }} text-light-1 text-20 pt-4">
                                            </div>
                                            <div class="ml-10">
                                                <div class="text-15 lh-12 fw-500 js-search-option-target">
                                                    {{ $translate->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @foreach ($flight_search_fields as $index => $field)
                <div class="col-lg-{{ $index == 1 || $index == 0 || $index == 3 || $index == 4 ? '2' : '3' }} align-self-center px-10 lg:py-5 lg:px-0"
                    style="{{ $index == 3 ? 'white-space:nowrap;' : '' }}">
                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp


                    @switch($field['field'])
                    @case ('date')
                    @include('Layout::common.search.fields.date' ,[
                        'index' => 0
                    ])
                    @break

                    @case ('seat_type')
                    @include('Layout::common.search.fields.seat_type', [
                    'SeatTypee' => $SeatTypee,
                    ])
                    @break

                    @case ('from_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'from_where',
                    'fromWhere' => 0,
                    ])
                    @break

                    @case ('to_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'to_where',
                    'fromWhere' => 0,
                    ])
                    @break
                    @endswitch
                </div>
                @endforeach

            </div>
            @endif
        </div>
        <div class="col-lg-1 p-0">

            <div class="button-item">
                <button class="mainSearch__submit button button-no-one{{ $button_classes }}" id="flightSearch"
                    type="submit" onclick="showLoader()">
                    <i class="icon-search text-20 mr-10"></i>
                    <span class="text-search">{{ __('SEARCH') }}</span>
                </button>
            </div>

            <script>
                function showLoader() {
                    document.getElementById('loader').style.display = 'block';
                }
            </script>
        </div>
    </div>
    {{-- </div> --}}

    <!-- Repeat for multiCityDiv1 -->

     <div class="col-md-12 mt-2 {{Request::query('from_where')[1] ?? 'd-none'}}" id="multiCityDiv1"
        style="border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
        {{-- <hr style="color: var(--color-dark-1);;"> --}}
        <div class="field-items d-block" style="padding: 0px; margin:0px !important;">
            @if (!empty($flight_search_fields))
            <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                <div class="col-lg-2 align-self-center px-10 lg:py-5 lg:px-0 trip-heading">
                    <h4>Trip 2</h4>
                </div>
                @foreach ($flight_search_fields as $index => $field)
                @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                <div
                    class="col-lg-{{ $index == 1 || $index == 0 || $index == 3 || $index == 4 ? '2' : '3' }} align-self-center px-10 lg:py-5 lg:px-0">
                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                    @switch($field['field'])
                    @case ('date')
                    @include('Layout::common.search.fields.date' ,[
                        'index' => 1
                    ])
                    @break

                    @case ('from_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'from_where',
                    'fromWhere' => 1,
                    ])
                    @break

                    @case ('to_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'to_where',
                    'fromWhere' => 1,
                    ])
                    @break
                    @endswitch
                </div>
                @endif
                @endforeach
                <div class="col-lg-2 m-0 p-0 button-no-two">
                    <button type="button"
                        class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                        <i class="icon-plus text-15 mr-10"></i> Add Another City
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mt-2 {{Request::query('from_where')[2] ?? 'd-none'}}" id="multiCityDiv2"
        style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
        {{-- <hr style="color: var(--color-dark-1);;"> --}}
        <div class="field-items d-block" style="padding: 0px; margin-bottom:8px !important;">
            @if (!empty($flight_search_fields))
            <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                <div class="col-lg-2 align-self-center px-10 lg:py-5 lg:px-0 trip-heading">
                    <h4>Trip 3</h4>
                </div>
                @foreach ($flight_search_fields as $index => $field)
                @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                <div
                    class="col-lg-{{ $index == 1 || $index == 0 || $index == 3 || $index == 4 ? '2' : '3' }} align-self-center px-10 lg:py-5 lg:px-0">
                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                    @switch($field['field'])
                    @case ('date')
                    @include('Layout::common.search.fields.date' ,[
                        'index' => 2
                    ])
                    @break

                    @case ('from_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'from_where',
                    'fromWhere' => 2,
                    ])
                    @break

                    @case ('to_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'to_where',
                    'fromWhere' => 2,
                    ])
                    @break
                    @endswitch
                </div>
                @endif
                @endforeach
                <div class="col-lg-2 button-no-two">
                    <button type="button "
                        class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                        <i class="icon-plus text-15 mr-10"></i> Add Another City
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mt-2 {{Request::query('from_where')[3] ?? 'd-none'}}" id="multiCityDiv3"
        style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
        {{-- <hr style="color: var(--color-dark-1);;"> --}}
        <div class="field-items d-block" style="padding: 0px; margin-bottom:8px !important;">
            @if (!empty($flight_search_fields))
            <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                <div class="col-lg-2 align-self-center px-10 lg:py-5 lg:px-0 trip-heading">
                    <h4>Trip 3</h4>
                </div>
                @foreach ($flight_search_fields as $index => $field)
                @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                <div
                    class="col-lg-{{ $index == 1 || $index == 0 || $index == 3 || $index == 4 ? '2' : '3' }} align-self-center px-10 lg:py-5 lg:px-0">
                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                    @switch($field['field'])
                    @case ('date')
                    @include('Layout::common.search.fields.date' ,[
                        'index' => 3
                    ])
                    @break

                    @case ('from_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'from_where',
                    'fromWhere' => 3,
                    ])
                    @break

                    @case ('to_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'to_where',
                    'fromWhere' => 3,
                    ])
                    @break
                    @endswitch
                </div>
                @endif
                @endforeach
                <div class="col-lg-2 button-no-two">
                    <button type="button"
                        class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                        <i class="icon-plus text-15 mr-10"></i> Add Another City
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mt-2 {{Request::query('from_where')[3] ?? 'd-none'}}" id="multiCityDiv4"
        style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
        {{-- <hr style="color: var(--color-dark-1);;"> --}}
        <div class="field-items d-block" style="padding: 0px; margin-bottom:8px !important;">
            @if (!empty($flight_search_fields))
            <div class="row w-100 m-0" style="color: var(--color-dark-1);;">
                <div class="col-lg-2 align-self-center px-10 lg:py-5 lg:px-0 trip-heading">
                    <h4>Trip 4</h4>
                </div>
                @foreach ($flight_search_fields as $index => $field)
                @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                <div
                    class="col-lg-{{ $index == 1 || $index == 0 || $index == 3 || $index == 4 ? '2' : '3' }} align-self-center px-10 lg:py-5 lg:px-0">
                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                    @switch($field['field'])
                    @case ('date')
                    @include('Layout::common.search.fields.date' ,[
                        'index' => 3
                    ])
                    @break

                    @case ('from_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'from_where',
                    'fromWhere' => 3,
                    ])
                    @break

                    @case ('to_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'to_where',
                    'fromWhere' => 3,
                    ])
                    @break
                    @endswitch
                </div>
                @endif
                @endforeach
                <div class="col-lg-2 button-no-two">
                    <button type="button"
                        class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                        <i class="icon-plus text-15 mr-10"></i> Add Another City
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mt-2 {{Request::query('from_where')[4] ?? 'd-none'}}" id="multiCityDiv5"
        style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
        {{-- <hr style="color: var(--color-dark-1);;"> --}}
        <div class="field-items d-block" style="padding: 0px; margin-bottom:8px !important;">
            @if (!empty($flight_search_fields))
            <div class="row w-100 m-0" style="color: var(--color-dark-1);;">
                <div class="col-lg-2 align-self-center px-10 lg:py-5 lg:px-0 trip-heading">
                    <h4>Trip 5</h4>
                </div>
                @foreach ($flight_search_fields as $index => $field)
                @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                <div
                    class="col-lg-{{ $index == 1 || $index == 0 || $index == 3 || $index == 4 ? '2' : '3' }} align-self-center px-10 lg:py-5 lg:px-0">
                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                    @switch($field['field'])
                    @case ('date')
                    @include('Layout::common.search.fields.date' ,[
                        'index' => 4
                    ])
                    @break

                    @case ('from_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'from_where',
                    'fromWhere' => 4,
                    ])
                    @break

                    @case ('to_where')
                    @include('Layout::common.search.fields.airport', [
                    'inputName' => 'to_where',
                    'fromWhere' => 4,
                    ])
                    @break
                    @endswitch
                </div>
                @endif
                @endforeach
                <div class="col-lg-2 button-no-two">
                    <button type="button"
                        class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                        <i class="icon-plus text-15 mr-10"></i> Add Another City
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
     
  
    <div class="col-lg-1 p-0">

        <div class="button-item button-item-one btn-non">
            <button class="mainSearch__submit button {{ $button_classes }}" id="flightSearch" type="submit">
                <i class="icon-search text-20 mr-10"></i>
                <span class="text-search">{{ __('SEARCH') }}</span>
            </button>
        </div>
    </div>
    </div>
    </div>


    <input type="hidden" id="cityCount" value="1">
</form>