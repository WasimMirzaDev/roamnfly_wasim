@php   $lang_local = app()->getLocale() @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        
        @foreach ($service as $rows)
        @foreach ($rows as $index => $row)
        {{-- @php dd($row) @endphp --}}
            

            <div class="review-section">
                <div class="service-info">
                    <div>
                        @php
                            $logo =\Modules\Flight\Services\FlightService::getAirLineLogo($row['code'], true);
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('uploads/'.$logo) }}" class="img-responsive" alt="{!! clean($row['title']) !!}">
                            </div>
                            <div class="col-md-6">
                                <h2 class="service-name">Flight {{$index + 1}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <h3 class="service-name">{!! clean($row['title']) !!}</h3>
                    </div>
                    <div class="font-weight-medium  mb-3">
                        <p class="mb-1">
                            {{__(':from to :to',['from'=>$row['airport_from'],'to'=>$row['airport_to']])}}
                        </p>
                        {{__(":duration hrs",['duration'=>(number_format($row['duration']/60,2))])}}
                    </div>

                    <div class="flex-self-start justify-content-between">
                        <div class="flex-self-start">
                            <div class="mr-2">
                                <i class="icofont-airplane font-size-30 text-primary"></i>
                            </div>
                            <div class="text-lh-sm ml-1">
                                <h6 class="font-weight-bold font-size-21 text-gray-5 mb-0">{{\Carbon\Carbon::parse($row['departure_time_html'])->format('H:i')}}</h6>
                                <span class="font-size-14 font-weight-normal text-gray-1">{{$row['arrival_date_html']}}</span>
                            </div>
                        </div>
                        <div class="text-center d-none d-md-block d-lg-none">
                            <div class="mb-1">
                                <h6 class="font-size-14 font-weight-bold text-gray-5 mb-0">{{__(":duration hrs",['duration'=>(number_format($row['duration']/60,2))])}}</h6>
                            </div>
                        </div>
                        <div class="flex-self-start">
                            <div class="mr-2">
                                <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary"></i>
                            </div>
                            <div class="text-lh-sm ml-1">
                                <h6 class="font-weight-bold font-size-21 text-gray-5 mb-0">{{\Carbon\Carbon::parse($row['arrival_time_html'])->format('H:i')}}</h6>
                                <span class="font-size-14 font-weight-normal text-gray-1">{{$row['arrival_date_html']}}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        @endforeach
        @endforeach
        <div class="review-section">
            <ul class="review-list">
                @if($booking->start_date)
                    <li>
                        <div class="label">{{ __("Start Date") }}</div>
                        <div class="val">
                            {{display_date($booking->start_date)}}
                        </div>
                    </li>
                    {{-- <li>
                        <div class="label">{{ __("Start Duration") }}</div>
                        <div class="val">{{human_time_diff(\Carbon\Carbon::parse($service[0]['sI'][0]['at'])->format('Y-m-d H:i:s'),\Carbon\Carbon::parse($service[0]['sI'][0]['dt'])->format('Y-m-d H:i:s'))}}</div>
                    </li> --}}
                    <li>
                        <div class="label">{{ __("end Date") }}</div>
                        <div class="val">
                            {{display_date($booking->end_date)}}
                        </div>
                    </li>
                    {{-- <li>
                        <div class="label">{{ __("Return Duration") }}</div>
                        <div class="val">{{human_time_diff(\Carbon\Carbon::parse($service[1]['sI'][0]['at'])->format('Y-m-d H:i:s'),\Carbon\Carbon::parse($service[1]['sI'][0]['dt'])->format('Y-m-d H:i:s'))}}</div>
                    </li> --}}
                @endif
                @php
                    $flight_seat = $booking->getJsonMeta('flight_seat');
                @endphp
                @if(!empty($flight_seat))
                    @foreach($flight_seat as $type)
                        @if(!empty($type['number']))
                            <li>
                                <div class="label">{{($loop->iteration > 1 ? 'Return ': 'Depart ').$type['seat_type']}}:</div>
                                <div class="val">
                                    {{$type['number']}}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="review-section total-review">
            <ul class="review-list">
                @php $flight_seat = $booking->getJsonMeta('flight_seat')@endphp
                @php $person_types = $booking->getJsonMeta('person_types') @endphp
                @if(!empty($flight_seat))
                    @foreach($flight_seat as $type)
                        @if(!empty($type['number']))
                            <li>
                                <div class="label">{{ ($loop->iteration > 1 ? 'Return ': 'Depart '). $type['seat_type']}}: {{$type['number']}} * {{format_money($type['price'])}}</div>
                                <div class="val">
                                    {{format_money($type['price'] * $type['number'])}}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    <li>
                        <div>
                            {{__("Extra Prices:")}}
                        </div>
                    </li>
                    @foreach($extra_price as $type)
                        <li>
                            <div class="label">{{$type['name_'.$lang_local] ?? __($type['name'])}}:</div>
                            <div class="val">
                                {{format_money($type['total'] ?? 0)}}
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
                                {{$item['name_'.$lang_local] ?? $item['name']}}
                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    {{ format_money( $fee_price * $booking->total_guests ) }}
                                @else
                                    {{ format_money( $fee_price ) }}
                                @endif
                            </div>
                        </li>
                        
                    @endforeach
                @endif
                @if(!empty($booking->adults) && $booking->adults != null)
                @php
                    $adultsForarray = json_decode($booking->adults, true);
                @endphp
                @if(is_array($adultsForarray) && !empty($adultsForarray))
                Adults :
                @foreach($adultsForarray as $index => $price)
                <li>
                    <div class="label">
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                        {{ "Flight ". $index + 1 }}: {{ ($price) }}
                    </div>
                </li>
                @endforeach
                @else
                <li>
                    <div class="label">
                        Adults 
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                            : {{$booking->adults}}
                    </div>
                </li>
                @endif
                @endif
                @if(!empty($booking->children) && $booking->children != null)
                @php
                $childForarray = json_decode($booking->children, true);
            @endphp
            @if(is_array($childForarray) && !empty($childForarray) )
            Children :
            @foreach($childForarray as $index => $price)
            <li>
                <div class="label">
                    <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                    {{ "Flight ". $index + 1 }} : {{ ($price) }}
                </div>
            </li>
            @endforeach
            @else
                <li>
                <div class="label">
                    Children
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                            : {{$booking->children}}
                        </div>
                    </li>
                    @endif
                    @endif


                    @if(!empty($booking->infants) && $booking->infants != null)
                    @php
                    $InfantsForarray = json_decode($booking->infants, true);
                @endphp
                @if(is_array($InfantsForarray) && !empty($InfantsForarray))
                Infants :
                @foreach($InfantsForarray as $index => $price)
                <li>
                    <div class="label">
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                        {{ "Flight ". $index + 1}} : {{ ($price) }}
                    </div>
                </li>
                @endforeach
                @else
                <li>
                <div class="label">
                    Infants
                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top"></i>
                            : {{$booking->infants}}
                        </div>
                    </li>
                    @endif
                    @endif

                {{-- @includeIf('Coupon::frontend/booking/checkout-coupon') --}}
                @if(!empty($booking->each_flight_price) && $booking->each_flight_price != null)
                @php
                    $each_flight_price = json_decode($booking->each_flight_price, true);
                @endphp
                @if(is_array($each_flight_price) && !empty($each_flight_price))
                @foreach($each_flight_price as $index => $price)
                Total for flight {{$index + 1}} 
                        : {{ format_money($price) }}
                        <br>
                @endforeach
                @endif
                @endif
                <li class="final-total d-block">
                    <div class="d-flex justify-content-between">
                        <div class="label">{{__("Total:")}}</div>
                        <div class="val">{{format_money($booking->total)}}</div>
                    </div>
                    @if($booking->status !='draft')
                        <div class="d-flex justify-content-between">
                            <div class="label">{{__("Paid:")}}</div>
                            <div class="val">{{format_money($booking->paid)}}</div>
                        </div>
                        @if($booking->paid < $booking->total )
                            <div class="d-flex justify-content-between">
                                <div class="label">{{__("Remain:")}}</div>
                                <div class="val">{{format_money($booking->total - $booking->paid)}}</div>
                            </div>
                        @endif
                    @endif
                </li>
                @include ('Booking::frontend/booking/checkout-deposit-amount')
            </ul>
        </div>
    </div>
</div>