{{-- <div class="py-30 px-30 bg-white rounded-4 base-tr mt-30 {{$wrap_class ?? ''}}" data-x="flight-item-{{ $row['sI'][0]['id'] ?? '' }}" data-x-toggle="shadow-{{ $row['sI'][0]['id'] ?? '' }}">
    <div class="row y-gap-30 justify-between">
        <div class="col">
            <div class="row y-gap-10 items-center">
                <div class="col-sm-auto">
                    <div class="has-skeleton">
                        @php
                            $logo = isset($row['sI'][0]['fD']['aI']['code'])
                                ? \Modules\Flight\Services\FlightService::getAirLineLogo($row['sI'][0]['fD']['aI']['code'], true)
                                : 'default-logo.png';
                        @endphp
                        <img class="size-40" src="{{ asset('uploads/'.$logo) }}" alt="{{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}">
                    </div>
                </div>
                <div class="col">
                    <div class="row x-gap-20 items-end">
                        <div class="col-auto">
                            <div class="has-skeleton">
                                <div class="lh-15 fw-500">{{ isset($row['sI'][0]['dt']) ? \Carbon\Carbon::parse($row['sI'][0]['dt'])->format('D M d H:i') : 'N/A' }}</div>
                                <div class="text-15 lh-15 text-light-1">{{ $row['sI'][0]['da']['name'] ?? 'Destination' }}</div>
                            </div>
                        </div>

                        <div class="col text-center">
                            <div class="flightLine">
                                <div></div>
                                <div></div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="has-skeleton">
                                <div class="lh-15 fw-500">{{ isset($row['sI'][0]['at']) ? \Carbon\Carbon::parse($row['sI'][0]['at'])->format('D M d H:i') : 'N/A' }}</div>
                                <div class="text-15 lh-15 text-light-1">{{ $row['sI'][0]['aa']['name'] ?? 'Arrival' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-auto">
                    <div class="text-15 text-light-1 px-20 md:px-0 has-skeleton">{{ isset($row['sI'][0]['duration']) ? number_format($row['sI'][0]['duration']/60,2).'h' : 'Duration N/A' }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-auto">
            <div class="has-skeleton">
                <div class="d-flex items-center h-full">
                    <div class="pl-30 border-left-light h-full md:d-none"></div>

                    <div>
                        @php
                        $index;
                        // print_r($index);
                        $publishedPrices = collect($row['totalPriceList'] ?? [])->filter(function($price) {
                            return $price['fareIdentifier'] === 'PUBLISHED';
                        })->values()->all();
                        $publishedPrice = $publishedPrices[0]['fd']['ADULT']['fC']['TF'] ?? ($row['totalPriceList'][0]['fd']['ADULT']['fC']['TF'] ?? 0);
                        $publishedPriceId = $publishedPrices[0]['id'] ?? ($row['totalPriceList'][0]['id'] ?? 0);
                    @endphp
                    <div class="text-right md:text-left mb-10">
                        <div class="text-18 lh-16 fw-500">{{ format_money($publishedPrice) }}</div>
                        <div class="text-15 lh-16 text-light-1">{{ __('avg/person') }}</div>
                    </div>
                    <div class="accordion__button">
                        {{-- @if($row->can_book) --}}
                            {{-- <a data-id="{{ $publishedPriceId }}" data-index="{{ $index }}" href="" onclick="event.preventDefault()" class="button -dark-1 px-30 h-50 bg-blue-1 text-white btn-Select-flight">{{ __("Select Flight") }} <div class="icon-arrow-top-right ml-15"></div></a> --}}
                        {{-- @else
                            <a href="#" class="button -dark-1 px-30 h-50 bg-warning-2 text-white btn-disabled">{{ __("Full Book") }}</a>
                        @endif --}}
                    {{-- </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 shadow-hover-3 mb-4 d-none">
    <a href="#" class="d-block mb-0 mx-1 mt-1 p-3" tabindex="0">
        <img class="card-img-top" src="" alt="{{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}">
    </a>
    <div class="card-body px-3 pt-0 pb-3 my-0 mx-1">
        <div class="row">
            <div class="col-7">
                <a href="#" class="card-title text-dark font-size-17 font-weight-bold" tabindex="0">{{ $row['sI'][0]['da']['name'] ?? 'Destination' }}</a>
            </div>
            <div class="col-5">
                <div class="text-right">
                    <h6 class="font-weight-bold font-size-17 text-gray-3 mb-0">{{ format_money($publishedPrice) }}</h6>
                    <span class="font-weight-normal font-size-12 d-block text-color-1">{{ __('avg/person') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="border-bottom pb-3 mb-3">
            <div class="px-3">
                <div class="d-flex mx-1">
                    <i class="icofont-airplane font-size-30 text-primary mr-3"></i>
                    <div class="d-flex flex-column">
                        <span class="font-weight-normal text-gray-5">{{ __('Take off') }}</span>
                        <span class="font-size-14 text-gray-1">{{ isset($row['sI'][0]['dt']) ? \Carbon\Carbon::parse($row['sI'][0]['dt'])->format('D M d H:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-bottom pb-3 mb-3">
            <div class="px-3">
                <div class="d-flex mx-1">
                    <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary mr-3"></i>
                    <div class="d-flex flex-column">
                        <span class="font-weight-normal text-gray-5">{{ __('Landing') }}</span>
                        <span class="font-size-14 text-gray-1">{{ isset($row['sI'][0]['at']) ? \Carbon\Carbon::parse($row['sI'][0]['at'])->format('D M d H:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center pl-3 pr-3">
            {{-- @if($row->can_book) --}}
            {{-- @click="openModalBook('{{ $publishedPriceId }}')" --}}
            {{-- <a @click="SelectedPriceID('{{ $publishedPriceId }}')" href="" onclick="event.preventDefault()" class="btn btn-primary text-white btn-choose w-100">{{ __("Select flight") }}</a> --}}
            {{-- @else
                <a href="#" class="btn btn-warning btn-disabled">{{ __("Full Book") }}</a>
            @endif --}}
        {{-- </div>
    </div>
</div> --}}



<div class="card-item-one">

<div class="py-30 px-30 bg-white rounded-4 base-tr mt-30 {{$wrap_class ?? ''}}" data-x="flight-item-{{ $row['sI'][0]['id'] ?? '' }}" data-x-toggle="shadow-{{ $row['sI'][0]['id'] ?? '' }}">
    <div class="row justify-content-between">
        <div class="col-8">
            <div class="row y-gap-10 items-center" style="gap: 35px;">
                <div class="col-sm-auto col-3 d-flex align-items-center">
                    <div class="has-skeleton">
                        @php
                            $logo = isset($row['sI'][0]['fD']['aI']['code'])
                                ? \Modules\Flight\Services\FlightService::getAirLineLogo($row['sI'][0]['fD']['aI']['code'], true)
                                : 'default-logo.png';
                        @endphp
                        <img class="size-40" src="{{ asset('images/a.png') }}" alt="{{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}">
                    </div>
                    <div class="content-wrapper px-2">
                        <div class="h3-heading">
                            {{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}
                        </div>
                        <span style="font-size: 12px;" class="text-black">
                            6E716B,6E1431
                        </span>
                    </div>
                </div>
                <div class="col p-0">
                    <div class="row x-gap-20 items-start">
                        <div class="col-auto" style="max-width: 33%; width:100%;">
                            <div class="has-skeleton">
<div class="lh-15 fw-500">{{ isset($row['sI'][0]['dt']) ? \Carbon\Carbon::parse($row['sI'][0]['dt'])->format('h:i A') : '07:30 PM' }}</div>
                                <div class="text-15 lh-15 text-light-1" style="overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis">{{ $row['sI'][0]['da']['name'] ?? 'Indore' }}</div>
                            </div>
                        </div>

                        <div class="col text-center">
                            <div class="col-md-auto">
                                <div class="text-15 text-light-1 px-20 md:px-0 has-skeleton">{{ isset($row['sI'][0]['duration']) ? number_format($row['sI'][0]['duration']/60,2).'h' : 'Duration N/A' }}</div>
                            </div>
                            <div class="flightLine">
                                <div></div>
                                <div></div>
                            </div>
                        </div>

                        <div class="col-auto" style="max-width: 33%; width:100%;">
                            <div class="has-skeleton">
<div class="lh-15 fw-500">{{ isset($row['sI'][0]['at']) ? \Carbon\Carbon::parse($row['sI'][0]['at'])->format('h:i A') : '09:00 PM' }}</div>
                                <div class="text-15 lh-15 text-light-1" style="overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis">{{ $row['sI'][0]['aa']['name'] ?? 'Abu Dubai' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

               
            </div>
        </div>
        <div class="col-md-auto col-4">
            <div class="has-skeleton">
                <div class="d-flex items-center h-full justify-content-between">
                    {{-- <div class="pl-30 border-left-light h-full md:d-none"></div> --}}

                    <div class="btn-flight-content d-flex ">
                        @php
                        $index;
                        // print_r($index);
                        $publishedPrices = collect($row['totalPriceList'] ?? [])->filter(function($price) {
                            return $price['fareIdentifier'] === 'PUBLISHED';
                        })->values()->all();
                        $publishedPrice = $publishedPrices[0]['fd']['ADULT']['fC']['TF'] ?? ($row['totalPriceList'][0]['fd']['ADULT']['fC']['TF'] ?? 0);
                        $publishedPriceId = $publishedPrices[0]['id'] ?? ($row['totalPriceList'][0]['id'] ?? 0);
                    @endphp
                    <div class="text-right md:text-left mb-10">
                        <div class="text-18 lh-16 fw-500">{{ format_money($publishedPrice ?? '30000') }}</div>
                        <div class="text-15 lh-16 text-light-1">{{ __('avg/person') }}</div>
                    </div>
                    <div class="accordion__button" style="margin-left: 20px !important;">
                        {{-- @if($row->can_book) --}}
                            <a id="{{ $publishedPriceId ?? 'awojdioawjdi' }}" data-id="{{ $publishedPriceId ?? 'awojdioawjdi' }}" data-index="{{ $index ?? '1'}}" href="" onclick="event.preventDefault()" class="button -dark-1 px-30 h-50 bg-blue-1 text-white btn-Select-flight btn-flight-link"  style=" background: transparent !important;
    color: #ff624d;
    border: 1px solid #ff624d;
    border-radius: 25px;"  onmouseover="this.style.backgroundColor='blue';">{{ __("Select") }} </a>
        {{-- <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i> --}}
                        {{-- @else
                            <a href="#" class="button -dark-1 px-30 h-50 bg-warning-2 text-white btn-disabled">{{ __("Full Book") }}</a>
                        @endif --}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 shadow-hover-3 mb-4 d-none">
    <a href="#" class="d-block mb-0 mx-1 mt-1 p-3" tabindex="0">
        <img class="card-img-top" src="" alt="{{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}">
    </a>
    <div class="card-body px-3 pt-0 pb-3 my-0 mx-1">
        <div class="row">
            <div class="col-7">
                <a href="#" class="card-title text-dark font-size-17 font-weight-bold" tabindex="0">{{ $row['sI'][0]['da']['name'] ?? 'Destination' }}</a>
            </div>
            <div class="col-5">
                <div class="text-right">
                    <h6 class="font-weight-bold font-size-17 text-gray-3 mb-0">{{ format_money($publishedPrice ?? '4000') }}</h6>
                    <span class="font-weight-normal font-size-12 d-block text-color-1">{{ __('avg/person') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="border-bottom pb-3 mb-3">
            <div class="px-3">
                <div class="d-flex mx-1">
                    <i class="icofont-airplane font-size-30 text-primary mr-3"></i>
                    <div class="d-flex flex-column">
                        <span class="font-weight-normal text-gray-5">{{ __('Take off') }}</span>
                        <span class="font-size-14 text-gray-1">{{ isset($row['sI'][0]['dt']) ? \Carbon\Carbon::parse($row['sI'][0]['dt'])->format('H:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-bottom pb-3 mb-3">
            <div class="px-3">
                <div class="d-flex mx-1">
                    <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary mr-3"></i>
                    <div class="d-flex flex-column">
                        <span class="font-weight-normal text-gray-5">{{ __('Landing') }}</span>
                        <span class="font-size-14 text-gray-1">{{ isset($row['sI'][0]['at']) ? \Carbon\Carbon::parse($row['sI'][0]['at'])->format('H:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center pl-3 pr-3">
            {{-- @if($row->can_book) --}}
            {{-- @click="openModalBook('{{ $publishedPriceId }}')" --}}
            <a @click="SelectedPriceID('{{ $publishedPriceId  ?? 'awdjiawda'}}')" href="" onclick="event.preventDefault()" class="btn btn-primary text-white btn-choose w-100">{{ __("Select flight") }}</a>
            {{-- @else
                <a href="#" class="btn btn-warning btn-disabled">{{ __("Full Book") }}</a>
            @endif --}}
        </div>
    </div>
</div>
</div>


<div class="card-item-two">
    <div class="py-30 px-30 bg-white rounded-4 base-tr mt-30 {{$wrap_class ?? ''}}"
        data-x="flight-item-{{ $row['sI'][0]['id'] ?? '' }}" data-x-toggle="shadow-{{ $row['sI'][0]['id'] ?? '' }}">
        <div class="main-wrapper justify-content-between">


            <div class="two-dives-wrapper d-flex justify-content-between align-items-center">
                <div class="div-wrapper-1 d-flex align-items-center">
                    <div class="inner-side d-flex justify-content-between align-items-center">
                    <div class="child-inner d-flex justify-content-between">
                     <div class="has-skeleton">
                        @php
                            $logo = isset($row['sI'][0]['fD']['aI']['code'])
                                ? \Modules\Flight\Services\FlightService::getAirLineLogo($row['sI'][0]['fD']['aI']['code'], true)
                                : 'default-logo.png';
                        @endphp
                        <img class="size-40" src="{{ asset('images/a.png') }}"
                            alt="{{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}">
                    </div>
                    <div class="content-wrapper  px-2">
                        <div class="h3-heading">
                            {{$row['sI'][0]['fD']['aI']['name'] ?? 'Airline'}}
                        </div>
                        <span style="font-size: 12px;" class="text-black">
                            6E716B,6E1431
                        </span>
                    </div>
                    </div>

                    <div class="accordion__button" style="margin-left: 20px !important;">
                                    {{-- @if($row->can_book) --}}
                                        <a data-id="{{ $publishedPriceId ?? 'awojdioawjdi' }}" data-index="{{ $index ?? '1'}}" href="" onclick="event.preventDefault()" class="button -dark-1 px-30 h-50 bg-blue-1 text-white btn-Select-flight btn-flight-link"  style=" background: transparent !important;
                color: #ff624d;
                border: 1px solid #ff624d;
                border-radius: 25px;"  onmouseover="this.style.backgroundColor='blue';">{{ __("Select") }} </a>
                    {{-- <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i> --}}
                                    {{-- @else
                                        <a href="#" class="button -dark-1 px-30 h-50 bg-warning-2 text-white btn-disabled">{{ __("Full Book") }}</a>
                                    @endif --}}
                                </div>
                    </div>
                   
                </div>
               
            </div>
            <div class="two-three-dives-wrapper d-flex justify-content-between align-items-center mt-3">
            <div class="div-wrapper-2 ">
                <div class="row x-gap-20 items-start">
                    <div class="col-auto custom-div-width">
                        <div class="has-skeleton">
                            <div class="lh-15 fw-500">
                                {{ isset($row['sI'][0]['dt']) ? \Carbon\Carbon::parse($row['sI'][0]['dt'])->format('h:i A') : '07:30 PM' }}
                            </div>
                            <div class="text-15 lh-15 text-light-1" style="    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis ">{{ $row['sI'][0]['da']['name'] ?? 'Indore' }}</div>
                        </div>
                    </div>

                    <div class="col text-center custom-div-width bar-line">
                        <div class="col-md-auto">
                            <div class="text-15 text-light-1 px-20 md:px-0 has-skeleton">
                                {{ isset($row['sI'][0]['duration']) ? number_format($row['sI'][0]['duration'] / 60, 2) . 'h' : 'Duration N/A' }}
                            </div>
                        </div>
                        <div class="flightLine">
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                    <div class="col-auto custom-div-width">
                        <div class="has-skeleton">
                            @php 
                                                                                                                                                $startDate = \Carbon\Carbon::parse($row['sI'][0]['dt']);
                                $endDate = \Carbon\Carbon::parse($row['sI'][0]['at']);

                                // Calculate the number of days between the dates
                                $daysDifference = $startDate->diffInDays($endDate, false); // false to allow negative results

                                // // If the difference is less than 1 day but more than 0, count as 1 day
                                // if ($daysDifference < 1 && $startDate->diffInHours($endDate) > 0) {
                                //     $daysDifference = 1;
                                // }
                            @endphp
                            <div class="timePlusDays d-flex">
                                <div class="lh-15 fw-500">
                                    {{ isset($row['sI'][0]['at']) ? \Carbon\Carbon::parse($row['sI'][0]['at'])->format('h:i A') : '09:00 PM' }}
                                </div>
                                <div class="days " style="width: 5px;
    height: 5px;
    margin-left: 2px;
    color: #ff9b00;
    font-size: small;">{{$daysDifference == 0 ? '' : '+' . $daysDifference . 'Days'}}</div>
                            </div>

                            <div class="text-15 lh-15 text-light-1" style="    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis">{{ $row['sI'][0]['aa']['name'] ?? 'Abu Dubai' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div-wrapper-3">
                    <div class="has-skeleton">
                        <div class="d-flex items-center h-full justify-content-between">
                            {{-- <div class="pl-30 border-left-light h-full md:d-none"></div> --}}

                            <div class="btn-flight-content d-flex ">
                                @php
                                    $index;
                                    // print_r($index);
                                    $publishedPrices = collect($row['totalPriceList'] ?? [])->filter(function ($price) {
                                        return $price['fareIdentifier'] === 'PUBLISHED';
                                    })->values()->all();
                                    $publishedPrice = $publishedPrices[0]['fd']['ADULT']['fC']['TF'] ?? ($row['totalPriceList'][0]['fd']['ADULT']['fC']['TF'] ?? 0);
                                    $publishedPriceId = $publishedPrices[0]['id'] ?? ($row['totalPriceList'][0]['id'] ?? 0);
                                @endphp
                                <div class="text-right md:text-left mb-10">
                                    <div class="text-18 lh-16 fw-500">{{ format_money($publishedPrice ?? '30000') }}
                                    </div>
                                    <div class="text-15 lh-16 text-light-1">{{ __('avg/person') }}</div>
                                </div>
                                <!-- <div class="accordion__button" style="margin-left: 20px !important;">
                                    {{-- @if($row->can_book) --}}
                                        <a data-id="{{ $publishedPriceId ?? 'awojdioawjdi' }}" data-index="{{ $index ?? '1'}}" href="" onclick="event.preventDefault()" class="button -dark-1 px-30 h-50 bg-blue-1 text-white btn-Select-flight btn-flight-link"  style=" background: transparent !important;
                color: #ff624d;
                border: 1px solid #ff624d;
                border-radius: 25px;"  onmouseover="this.style.backgroundColor='blue';">{{ __("Select") }} </a>
                    {{-- <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i> --}}
                                    {{-- @else
                                        <a href="#" class="button -dark-1 px-30 h-50 bg-warning-2 text-white btn-disabled">{{ __("Full Book") }}</a>
                                    @endif --}}
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
           



        </div>
    </div>











    <div class="card w-100 shadow-hover-3 mb-4 d-none">
        <a href="#" class="d-block mb-0 mx-1 mt-1 p-3" tabindex="0">
            <img class="card-img-top" src="" alt="{{ $row['sI'][0]['fD']['aI']['name'] ?? 'Airline' }}">
        </a>
        <div class="card-body px-3 pt-0 pb-3 my-0 mx-1">
            <div class="row">
                <div class="col-7">
                    <a href="#" class="card-title text-dark font-size-17 font-weight-bold"
                        tabindex="0">{{ $row['sI'][0]['da']['name'] ?? 'Destination' }}</a>
                </div>
                <div class="col-5">
                    <div class="text-right">
                        <h6 class="font-weight-bold font-size-17 text-gray-3 mb-0">
                            {{ format_money($publishedPrice ?? '4000') }}
                        </h6>
                        <span class="font-weight-normal font-size-12 d-block text-color-1">{{ __('avg/person') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="border-bottom pb-3 mb-3">
                <div class="px-3">
                    <div class="d-flex mx-1">
                        <i class="icofont-airplane font-size-30 text-primary mr-3"></i>
                        <div class="d-flex flex-column">
                            <span class="font-weight-normal text-gray-5">{{ __('Take off') }}</span>
                            <span
                                class="font-size-14 text-gray-1">{{ isset($row['sI'][0]['dt']) ? \Carbon\Carbon::parse($row['sI'][0]['dt'])->format('H:i A') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-bottom pb-3 mb-3">
                <div class="px-3">
                    <div class="d-flex mx-1">
                        <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary mr-3"></i>
                        <div class="d-flex flex-column">
                            <span class="font-weight-normal text-gray-5">{{ __('Landing') }}</span>
                            <span
                                class="font-size-14 text-gray-1">{{ isset($row['sI'][0]['at']) ? \Carbon\Carbon::parse($row['sI'][0]['at'])->format('H:i A') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center pl-3 pr-3">
                {{-- @if($row->can_book) --}}
                {{-- @click="openModalBook('{{ $publishedPriceId }}')" --}}
                <a @click="SelectedPriceID('{{ $publishedPriceId ?? 'awdjiawda'}}')" href=""
                    onclick="event.preventDefault()"
                    class="btn btn-primary text-white btn-choose w-100">{{ __("Select flight") }}</a>
                {{-- @else
                <a href="#" class="btn btn-warning btn-disabled">{{ __("Full Book") }}</a>
                @endif --}}
            </div>
        </div>
    </div>
</div> 