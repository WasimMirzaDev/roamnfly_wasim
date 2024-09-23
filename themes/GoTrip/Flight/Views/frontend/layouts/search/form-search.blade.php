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
<form action="{{ route('flight.search') }}" id="formheight"
    class="gotrip_form_search bravo_form_search bravo_form form {{ $classes }}" method="get">
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
            adults: {{ Request::query('seat_type')['adults'] ?? 0 }},
            children: {{ Request::query('seat_type')['children'] ?? 0 }},
            infants: {{ Request::query('seat_type')['infants'] ?? 0 }},
            flight_seat: []
        };
        console.log(window.initialData);
    </script>
    <Style>
        .bravo_wrap .form-search-all-service .tabs__pane.-tab-item-flight .bravo_form {
            max-width: 100% !important;
            width: 100%;
            padding: 3rem 0px !important;
        }

        .gotrip_form_search {
            padding: 3rem 0 !important;
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
            font-size: 20px !important;
        }

        .bravo_wrap .gotrip_form_search .field-items>.row>div {
            padding: 15px 15px 0 !important;
            height: 100% !important;

        }

        .field-items {
            height: 100px !important;

        }

        .field-items h4 {
            font-size: 17px !important;
        }

        .field-items .row {
            height: 100% !important;
        }


        .col-lg-2 {
            & button {
                position: relative;
                top: 20px;
                left: 5px;
                padding: 5px 10px;
            }
        }

        /* .bravo_wrap .gotrip_form_search .field-items:nth-child(1){
        padding: 65px 20px 20px;
    } */
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
        @media (max-width: 991px) {

.gotrip_form_search {
    height: 390px !important;
}


}
        @media (max-width: 769px) {

            .gotrip_form_search {
                height: 390px !important;
            }


            .searchMenu-guests__field {
                z-index: 999 !important;
            }

            .hotel-heading {
                font-size: 15px !important;
            }

            .smart-search-location {
                font-size: 15px !important;
            }

            .field-items h4 {
                font-size: 15px !important;
            }

            .field-items {
                height: 75px !important;
                /* padding: 0 20px !important; */
                margin: 0 !important;
            }

            .bravo_wrap .gotrip_form_search .field-items>.row>div {

                padding: 10px !important;
            }

            .image-wrapper-go {
                height: 30px !important;
                width: 42px !important;

            }

            .field-items .row {
                border: 0 !important;
            }

            .render {
                font-size: 15px !important;
            }

            .bravo_wrap .gotrip_form_search .field-items {
                margin: 0 !important;
                padding: 0 !important;
                /* height: 500px !important; */
            }


        }

        @media (max-width: 500px) {
            .ratio-group {
                font-size: 14px !important;
                margin-left: 4px !important;
            }
        }

        @media (max-width: 992px) {
            .check-boxes {

                margin-left: 0 !important;
            }

            .check-box-one {
                margin-left: 10px !important;
            }

            body:has(#Multicity:checked) .gotrip_form_search {
                height: 750px !important;
            }
#multiCityDiv1{
    border-top: 7px solid #e7e7e7 !important;

    width: auto !important;
    margin: 240px 0 0 0 !important;
}
#multiCityDiv3{
    border-top: 7px solid #e7e7e7 !important;

width: auto !important;
margin: 240px 0 0 0 !important;
}
#multiCityDiv4{
    border-top: 7px solid #e7e7e7 !important;

width: auto !important;
margin: 240px 0 0 0 !important;
}
#multiCityDiv5{
    border-top: 7px solid #e7e7e7 !important;

width: auto !important;
margin: 240px 0 0 0 !important;
}

        }
        .twelevehundred{
            height: 1400px !important;
        }
        .eighthundred{
            height: 800px !important;
        }
    </style>

    <script>
        if (window.location.pathname === '/flight') {
            document.styleSheets[0].addRule('.bravo_wrap .bravo_search_flight .bravo_form_search',
                'margin-top: 10px !important;');
            document.styleSheets[0].addRule('.bravo_wrap .gotrip_form_search .field-items:nth-child(1)',
                'padding: 20px 20px 20px !important');
        }
    </script>


    <div class="w-100" id="multiCityDivContainer">
        <div class="col-md-12">
            @php
                $attr = 'travel-type';
                $inputName = 'travel_type';
            @endphp
            @if (!empty($attr) and !empty(($attr = \Modules\Core\Models\Attributes::where('slug', $attr)->first())))
                <div class="searchMenu-loc js-form-dd js-liverSearch item">
                    {{-- <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span> --}}
                    <div data-x-dd-click="searchMenu-loc" class="d-none">
                        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $attr->name }}</h4>
                        <div class="text-15 text-light-1 ls-2 lh-16 smart-search">
                            <!-- Retrieve value from URL or set to empty -->
                            <input type="hidden" id="{{ $inputName }}" name="{{ $inputName }}"
                                class="js-search-get-id" value="{{ Request::query($inputName) ?? 'One Way' }}">
                            <!-- Display selected term name or placeholder -->
                            <input type="text" autocomplete="off" readonly
                                class="smart-search-location parent_text js-search js-dd-focus"
                                placeholder="{{ __('Select Type') }}"
                                value="{{ optional($attr->terms->where('name', Request::query($inputName))->first())->name ?? '' }}">
                        </div>
                    </div>
                    <div data-x-dd="searchMenu-loc">
                        <div>
                            <div class="y-gap-5 js-results">
                                <div class="d-flex ratio-group ms-4 check-boxes" style="color: black; font-size:18px;">
                                    @foreach ($attr->terms as $term)
                                        @php $translate = $term->translate(); @endphp
                                        <div class=" js-search-option getMultiRow" data-id="{{ $translate->name }}"        onclick="document.getElementById('{{ $translate->name }}').checked = true;">
                                            <div class="d-flex ms-4 check-box-one" style="justify-content: center;">
                                                <input type="radio" id="{{ $translate->name }}" class="me-2"
       name="travel_type_extra" value="{{ $translate->name }}" 
       {{ $translate->name == 'One Way' ? 'checked' : '' }}
       />

                                                <label for="{{ $translate->name }}"    style="white-space: nowrap;"
                                                    class="js-search-option-target">{{ $translate->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <script>
                function checkRadioButton(clickedId) {
                    // Find the radio button with the matching id
                    var radioButton = document.getElementById(clickedId);
                    // alert(clickedId);
                    if (radioButton && !radioButton.checked) {
                        radioButton.checked = true;
                    }
                }
            </script>
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
            <div class="field-items">
                @if (!empty($flight_search_fields))
                    <div class="row w-100 m-0 adjust-border" style="color: var(--color-dark-1);">
                        @foreach ($flight_search_fields as $field)
                            <div class="col-lg-{{ $field['size'] }} align-self-center px-10 lg:py-5 lg:px-0">
                                @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                                @switch($field['field'])
                                    @case ('date')
                                        @include('Layout::common.search.fields.date')
                                    @break

                                    @case ('seat_type')
                                        @include('Layout::common.search.fields.seat_type', [
                                            'SeatTypee' => $SeatTypee,
                                        ])
                                    @break

                                    @case ('from_where')
                                        @include('Layout::common.search.fields.airport', [
                                            'inputName' => 'from_where',
                                            'fromWhere' => $fromWhere,
                                        ])
                                    @break

                                    @case ('to_where')
                                        @include('Layout::common.search.fields.airport', [
                                            'inputName' => 'to_where',
                                            'toWhere' => $toWhere,
                                        ])
                                    @break
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Repeat for multiCityDiv1 -->
        <div class="col-md-12 mt-2 d-none" id="multiCityDiv1"
            style="border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
            {{-- <hr style="color: var(--color-dark-1);;"> --}}
            <div class="field-items d-block" style="padding: 0px; margin:0px !important;">
                @if (!empty($flight_search_fields))
                    <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                        @foreach ($flight_search_fields as $field)
                            @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                                <div
                                    class="col-lg-{{ $field['size'] ?? '6' }} align-self-center px-10 lg:py-5 lg:px-0">
                                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                                    @switch($field['field'])
                                        @case ('date')
                                            @include('Layout::common.search.fields.date')
                                        @break

                                        @case ('from_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'from_where',
                                                'fromWhere' => $fromWhere,
                                            ])
                                        @break

                                        @case ('to_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'to_where',
                                                'toWhere' => $toWhere,
                                            ])
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        @endforeach
                        <div class="col-lg-3 m-0 p-0">
                            <button type="button"
                                class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                                <i class="icon-plus text-15 mr-10"></i> Add Another City
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-2 d-none" id="multiCityDiv2"
            style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
            {{-- <hr style="color: var(--color-dark-1);;"> --}}
            <div class="field-items d-block" style="padding: 0px; margin:0px !important;">
                @if (!empty($flight_search_fields))
                    <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                        @foreach ($flight_search_fields as $field)
                            @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                                <div
                                    class="col-lg-{{ $field['size'] ?? '6' }} align-self-center px-10 lg:py-5 lg:px-0">
                                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                                    @switch($field['field'])
                                        @case ('date')
                                            @include('Layout::common.search.fields.date')
                                        @break

                                        @case ('from_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'from_where',
                                            ])
                                        @break

                                        @case ('to_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'to_where',
                                            ])
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        @endforeach
                        <div class="col-lg-3">
                            <button type="button"
                                class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                                <i class="icon-plus text-15 mr-10"></i> Add Another City
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-2 d-none" id="multiCityDiv3"
            style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
            {{-- <hr style="color: var(--color-dark-1);;"> --}}
            <div class="field-items d-block" style="padding: 0px; margin:0px !important;">
                @if (!empty($flight_search_fields))
                    <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                        @foreach ($flight_search_fields as $field)
                            @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                                <div
                                    class="col-lg-{{ $field['size'] ?? '6' }} align-self-center px-10 lg:py-5 lg:px-0">
                                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                                    @switch($field['field'])
                                        @case ('date')
                                            @include('Layout::common.search.fields.date')
                                        @break

                                        @case ('from_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'from_where',
                                            ])
                                        @break

                                        @case ('to_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'to_where',
                                            ])
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        @endforeach
                        <div class="col-lg-3">
                            <button type="button"
                                class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                                <i class="icon-plus text-15 mr-10"></i> Add Another City
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-2 d-none" id="multiCityDiv4"
            style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
            {{-- <hr style="color: var(--color-dark-1);;"> --}}
            <div class="field-items d-block" style="padding: 0px; margin:0px !important;">
                @if (!empty($flight_search_fields))
                    <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                        @foreach ($flight_search_fields as $field)
                            @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                                <div
                                    class="col-lg-{{ $field['size'] ?? '6' }} align-self-center px-10 lg:py-5 lg:px-0">
                                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                                    @switch($field['field'])
                                        @case ('date')
                                            @include('Layout::common.search.fields.date')
                                        @break

                                        @case ('from_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'from_where',
                                            ])
                                        @break

                                        @case ('to_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'to_where',
                                            ])
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        @endforeach
                        <div class="col-lg-3">
                            <button type="button"
                                class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                                <i class="icon-plus text-15 mr-10"></i> Add Another City
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-2 d-none" id="multiCityDiv5"
            style="    border: 1px solid #e7e7e7; border-radius:10px; margin:0px 31px; width:auto !important;">
            {{-- <hr style="color: var(--color-dark-1);;"> --}}
            <div class="field-items d-block" style="padding: 0px; margin:0px !important;">
                @if (!empty($flight_search_fields))
                    <div class="row w-100 m-0" style="color: var(--color-dark-1);">
                        @foreach ($flight_search_fields as $field)
                            @if ($field['field'] != 'travel_type' && $field['field'] != 'seat_type')
                                <div
                                    class="col-lg-{{ $field['size'] ?? '6' }} align-self-center px-10 lg:py-5 lg:px-0">
                                    @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                                    @switch($field['field'])
                                        @case ('date')
                                            @include('Layout::common.search.fields.date')
                                        @break

                                        @case ('from_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'from_where',
                                            ])
                                        @break

                                        @case ('to_where')
                                            @include('Layout::common.search.fields.airport', [
                                                'inputName' => 'to_where',
                                            ])
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        @endforeach
                        <div class="col-lg-3">
                            <button type="button"
                                class="button -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white addCity button-city-add">
                                <i class="icon-plus text-15 mr-10"></i> Add Another City
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="button-item">
        <button class="mainSearch__submit button {{ $button_classes }}" id="flightSearch" type="submit">
            <i class="icon-search text-20 mr-10"></i>
            <span class="text-search">{{ __('SEARCH') }}</span>
        </button>
    </div>
    <input type="hidden" id="cityCount" value="1">
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const multiCityDiv1 = document.getElementById('multiCityDiv1');
    const multiCityDiv2 = document.getElementById('multiCityDiv2');
    const gotripFormSearchElements = document.getElementsByClassName('gotrip_form_search');

    // Convert HTMLCollection to Array for easier manipulation
    const gotripFormSearchArray = Array.from(gotripFormSearchElements);

    // Remove existing classes from all elements
    gotripFormSearchArray.forEach(element => {
        element.classList.remove('eighthundred', 'twelevehundred'); // Remove previously set height classes
    });

    // Add the appropriate class based on visibility
    gotripFormSearchArray.forEach(element => {
        if (!(multiCityDiv1.classList.contains('d-none'))) {
            element.classList.add('eighthundred'); // Set height when multiCityDiv1 is visible
        } else if (!(multiCityDiv2.classList.contains('d-none'))) {
            element.classList.add('twelevehundred'); // Set height when multiCityDiv2 is visible
        }
    });
});

</script>
