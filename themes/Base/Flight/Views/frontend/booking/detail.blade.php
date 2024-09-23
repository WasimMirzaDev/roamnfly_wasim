
@php $lang_local = app()->getLocale() @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{ __("Your Booking") }}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div class="profile-wrapper d-flex justify-content-start">
                <div>
                    @php
                        $logo = \Modules\Flight\Services\FlightService::getAirLineLogo($service['sI'][0]['fD']['aI']['code'] ?? '', true);
                    @endphp
                    <img src="{{ asset('images/a.png') }}" class="img-responsive" style="width: 53px !important; margin-right: 20px;" alt="{{ clean($service['sI'][0]['fD']['aI']['name'] ?? '') }}">
                </div>
                <div class="inner-content">
                <div class="mt-2 d-flex align-items-center ">
                    <h3 class="service-name me-3">{{ clean($service['sI'][0]['fD']['aI']['name'] ?? '') }}</h3>
                    {{ __(":duration hrs", ['duration' => number_format(($service['sI'][0]['duration'] ?? 0) / 60, 2)]) }}

                </div>
                <div class="font-weight-medium mb-3">
                    <p class="mb-1">
                        {{ __(":from to :to", ['from' => $service['sI'][0]['da']['name'] ?? '', 'to' => $service['sI'][0]['aa']['name'] ?? '']) }}
                    </p>
                </div>
                </div>
             
                </div>
               

                <div class="flex-self-start justify-content-between d-flex">
                    <div class="flex-self-start d-flex align-items-center"> 
                        <div class="me-3">
                            <i class="icofont-airplane font-size-30 text-primary"></i>
                        </div>
                        <div class="text-lh-sm ml-1">
                            <h6 class="font-weight-bold font-size-21 text-gray-5 mb-0">{{ \Carbon\Carbon::parse($service['sI'][0]['dt'] ?? now())->format('H:i') }}</h6>
                            <span class="font-size-14 font-weight-normal text-gray-1">{{ $service['sI'][0]['da']['name'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="text-center d-none d-md-block d-lg-none">
                        <div class="mb-1">
                            <h6 class="font-size-14 font-weight-bold text-gray-5 mb-0">{{ __(":duration hrs", ['duration' => number_format(($service['sI'][0]['duration'] ?? 0) / 60, 2)]) }}</h6>
                        </div>
                    </div>
                    <div class="flex-self-start d-flex align-items-center">
                        <div class="me-3">
                            <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary"></i>
                        </div>
                        <div class="text-lh-sm ml-1">
                            <h6 class="font-weight-bold font-size-21 text-gray-5 mb-0">{{ \Carbon\Carbon::parse($service['sI'][0]['at'] ?? now())->format('H:i') }}</h6>
                            <span class="font-size-14 font-weight-normal text-gray-1">{{ $service['sI'][0]['aa']['name'] ?? '' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="review-section">
            <ul class="review-list d-flex justify-content-between">
                @if($booking->start_date)
                    <li>
                        <div class="label me-3">{{ __("Start Date") }}</div>
                        <div class="val">
                            {{ display_date($booking->start_date) }}
                        </div>
                    </li>
                    <li>
                        <div class="label me-3">{{ __("Duration") }}</div>
                        <div class="val">{{ human_time_diff(\Carbon\Carbon::parse($service['sI'][0]['at'] ?? now())->format('Y-m-d H:i:s'), \Carbon\Carbon::parse($service['sI'][0]['dt'] ?? now())->format('Y-m-d H:i:s')) }}</div>
                    </li>
                @endif
                @php
                    $flight_seat = $booking->getJsonMeta('flight_seat');
                @endphp
                @if(!empty($flight_seat))
                    @foreach($flight_seat as $type)
                        @if(!empty($type['number']))
                            <li>
                                <div class="label">{{ $type['seat_type'] ?? '' }}:</div>
                                <div class="val">
                                    {{ $type['number'] ?? '' }}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="review-section total-review">
            <ul class="review-list">
                @php $flight_seat = $booking->getJsonMeta('flight_seat') @endphp
                @php $person_types = $booking->getJsonMeta('person_types') @endphp

{{-- @php
    $total = 0; // Initialize a variable to accumulate the total

    if (!empty($flight_seat)) {
        foreach ($flight_seat as $type) {
            if (!empty($type['number'])) {
                // Calculate the total for the current seat type
                $seatTotal = ($type['price'] ?? 0) * ($type['number'] ?? 0);
                $total += $seatTotal; // Add to the accumulated total
            }
        }
    }
    
    // Append the total to $booking->total
    $booking->total += $total;
@endphp --}}
                @if(!empty($flight_seat))
                    @foreach($flight_seat as $type)
                        @if(!empty($type['number']))
                            <li>
                                <div class="label">{{ $type['seat_type'] ?? '' }}: {{ $type['number'] ?? '' }} * {{ format_money($type['price'] ?? 0) }}</div>
                                <div class="val">
                                    {{ format_money(($type['price'] ?? 0) * ($type['number'] ?? 0)) }}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    <li>
                        <div>
                            {{ __("Extra Prices:") }}
                        </div>
                    </li>
                    @foreach($extra_price as $type)
                        <li>
                            <div class="label">{{ $type['name_'.$lang_local] ?? __($type['name']) }}:</div>
                            <div class="val">
                                {{ format_money($type['total'] ?? 0) }}
                            </div>
                        </li>
                    @endforeach
                @endif
                @php
                    $list_all_fee = [];
                    if(!empty($booking->buyer_fees)){
                        $buyer_fees = json_decode($booking->buyer_fees , true);
                        $list_all_fee = $buyer_fees;
                    }
                    if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                        $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
                    }
                @endphp
                @if(!empty($list_all_fee))
                    @foreach ($list_all_fee as $item)
                        @php
                            $fee_price = $item['price'];
                            if(!empty($item['unit']) and $item['unit'] == "percent"){
                                $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                            }
                        @endphp
                        <li>
                            <div class="label">
                                {{ $item['name_'.$lang_local] ?? $item['name'] }}
                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    : {{ $booking->total_guests }} * {{ format_money($fee_price) }}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    {{ format_money($fee_price * $booking->total_guests) }}
                                @else
                                    {{ format_money($fee_price) }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif
                @if(!empty($booking->adults))
                <li>
                    <div class="label">
                        Adults 
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                            : {{$booking->adults}}
                        </div>
                    </li>
                    @endif
                @if(!empty($booking->children))
                <li>
                <div class="label">
                    Children
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                            : {{$booking->children}}
                        </div>
                    </li>
                    @endif
                    @if(!empty($booking->infants))
                <li>
                <div class="label">
                    Infants
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                            : {{$booking->infants}}
                        </div>
                    </li>
                    @endif
                {{-- @includeIf('Coupon::frontend/booking/checkout-coupon') --}}
                <li class="final-total d-block">
                    <div class="d-flex justify-content-between">
                        <div class="label">{{ __("Total:") }}</div>
                        <div class="val">{{ format_money($booking->total ?? 0) }}</div>
                    </div>
                    @if($booking->status != 'draft')
                        <div class="d-flex justify-content-between">
                            <div class="label">{{ __("Paid:") }}</div>
                            <div class="val">{{ format_money($booking->paid ?? 0) }}</div>
                        </div>
                        @if($booking->paid < $booking->total)
                            <div class="d-flex justify-content-between">
                                <div class="label">{{ __("Remain:") }}</div>
                                <div class="val">{{ format_money(($booking->total ?? 0) - ($booking->paid ?? 0)) }}</div>
                            </div>
                        @endif
                    @endif
                </li>
                @include ('Booking::frontend/booking/checkout-deposit-amount')
            </ul>
        </div>
    </div>
</div>
