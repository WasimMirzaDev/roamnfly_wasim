@extends('Layout::empty')

@push('css')
    <style type="text/css">
        html, body {
            background: #f0f0f0;
        }
        .bravo_topbar, .bravo_header, .bravo_footer {
            display: none;
        }
        .invoice-amount {
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 20px;
            display: inline-block;
            text-align: center;
        }
        .email_new_booking .b-table {
            width: 100%;
        }
        .email_new_booking .val {
            text-align: right;
        }
        .email_new_booking td,
        .email_new_booking th {
            padding: 5px;
        }
        .email_new_booking .val table {
            text-align: left;
        }
        .email_new_booking .b-panel-title,
        .email_new_booking .booking-number,
        .email_new_booking .booking-status,
        .email_new_booking .manage-booking-btn {
            display: none;
        }
        .email_new_booking .fsz21 {
            font-size: 21px;
        }
        .table-service-head {
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .table-service-head th {
            padding: 5px 15px;
        }
        #invoice-print-zone {
            background: white;
            padding: 15px;
            margin: 90px auto 40px auto;
            max-width: 1025px;
        }
        .invoice-company-info{
            margin-top: 15px;
        }
        .invoice-company-info p{
            margin-bottom: 2px;
            font-weight: normal;
        }
    </style>
    <link href="{{ asset('module/user/css/user.css') }}" rel="stylesheet">
    <script>
        window.print();
    </script>
    <div id="invoice-print-zone">
        <table width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th width="50%">
                    @if( !empty($logo = setting_item('logo_invoice_id') ?? setting_item('logo_id') ))
                        <img style="max-width: 200px;" src="{{get_file_url( $logo ,"full")}}" alt="{{setting_item("site_title")}}">
                    @endif
                    <div class="invoice-company-info">
                        {!! setting_item_with_lang("invoice_company_info") !!}
                    </div>
                </th>
                <th width="50%" align="right" class="text-right">
                    <h2 class="invoice-text-title">{{__("INVOICE")}}</h2>
                    {{__('Invoice #: :number',['number'=>$booking->id])}}
                    <br>
                    {{__('Created: :date',['date'=>display_date($booking->created_at)])}}
                    <br>
                    {{('Amount Paid: ' . format_money($booking->paid))}}<br>
        @if($booking->object_model == 'flight')
            @if($booking->travel_type == 'Multicity')
                    <?php
                    $adultsString = $booking->adults;
                    $childrenString = $booking->children;
                    $infantsString = $booking->infants;
        
                    $Booking_id_array = json_decode($booking->api_id, true) ?? [];
        $adultsForarray = json_decode($adultsString, true) ?? [];
        $title_array = json_decode($booking->title, true) ?? [];
        $childrenForarray = json_decode($childrenString, true) ?? [];
        $infantsForarray = json_decode($infantsString, true) ?? [];
        
                    ?>
                    {{-- {{('Booking ID: ' . $booking->api_id)}}<br> --}}
                    {{'Booking ID: '}}                @foreach ($Booking_id_array as $item)
                    {{$item}}
                    @endforeach<br>
                    {{('Status: ' . $booking->status)}}<br>
                    {{('Service: ' . $booking->object_model)}}<br>
                    {{('Travel Type: ' . $booking->travel_type)}}<br>
                    @else

                    {{('Booking ID: ' . $booking->api_id)}}<br>
                    {{('Status: ' . $booking->status)}}<br>
                    {{('Service: ' . $booking->object_model)}}<br>
                    {{('Travel Type: ' . $booking->travel_type)}}<br>
                    @endif
                    {{-- Booking Status : {{$booking->status}} --}}
                    {{-- Type : <span>{{$booking->object_model}}</span><br>
                    Code : <span>{{$booking->code}}</span><br>
                    Travel Type : <span>{{$booking->travel_type}}</span><br>
                    Booking ID : <span>{{$booking->api_id}}</span><br> --}}
                    @else
                    {{('Booking ID: ' . $booking->api_id)}}<br>
                    {{('Status: ' . $booking->status)}}<br>
                    {{('Service: ' . $booking->object_model)}}<br>
                    @endif
                </th>
            </tr>
            <tr>
                <th width="50%">
                    {!! nl2br(setting_item('invoice_company')) !!}
                </th>
                <th width="50%" align="right" class="text-right">
                    <div class="invoice-amount">
                        <div class="label">{{__("Amount due:")}}</div>
                        <div class="amount" style="font-size: 24px;"><strong>{{format_money($booking->total - $booking->paid)}}</strong>
                        </div>
                    </div>
                </th>
            </tr>
            </thead>
        </table>
        <hr>
        @if($booking->object_model == 'flight')
        @if($booking->travel_type == 'Multicity')
        <div>
            {{-- Type : <span>{{$booking->object_model}}</span><br>
            Code : <span>{{$booking->code}}</span><br>
            Travel Type : <span>{{$booking->travel_type}}</span><br> --}}
            <?php
            $adultsString = $booking->adults;
            $childrenString = $booking->children;
            $infantsString = $booking->infants;

            $Booking_id_array = json_decode($booking->api_id, true) ?? [];
            $adultsForarray = json_decode($adultsString, true) ?? [];
            $title_array = json_decode($booking->title, true) ?? [];
            $childrenForarray = json_decode($childrenString, true) ?? [];
            $infantsForarray = json_decode($infantsString, true) ?? [];
            ?>
        <h4>Flight Information </h4>
        <br>
        <?php $flightDatas = json_decode($booking->flightData, true) ?? []; ?>
        @foreach($flightDatas as $index => $flightData )
            <strong>Flight {{$index + 1}}</strong><br>
            {{-- <span>{{ dd($flightData);}}</span><br> --}}
            Title : <span>{{$flightData['title']}}</span><br>
            Departure Time : <span>{{$flightData['departure_time_html']}}</span><br>
            Departure Date : <span>{{$flightData['departure_date_html']}}</span><br>
            Airport From : <span>{{$flightData['airport_from']}}</span><br>
            Duration : <span>{{$flightData['duration'] . 'h'}}</span><br>
            Arrival Time : <span>{{$flightData['arrival_time_html']}}</span><br>
            Arrival Date : <span>{{$flightData['arrival_date_html']}}</span><br>
            Airport To : <span>{{$flightData['airport_to']}}</span><br>
            <br>
            @endforeach

            Adults : <span>                
                @foreach ($adultsForarray as $item)
                {{$item}}
                @endforeach</span><br>
            Children : <span>                
                @foreach ($childrenForarray as $item)
                {{$item}}
                @endforeach</span><br>
            Infants : <span>                
                @foreach ($infantsForarray as $item)
                {{$item}}
                @endforeach</span><br>

        </div>
        @elseif($booking->travel_type == 'Round Trip')
        <h4>Flight Information </h4>
        <br>
        <strong>Depart : </strong><br>
        <?php $flightData = json_decode($booking->flightData, true) ?? []; ?>
        {{-- <span>{{ dd($flightData);}}</span><br> --}}
            Title : <span>{{$flightData[0]['title']}}</span><br>
            Departure Time : <span>{{$flightData[0]['departure_time_html']}}</span><br>
            Departure Date : <span>{{$flightData[0]['departure_date_html']}}</span><br>
            Airport From : <span>{{$flightData[0]['airport_from']}}</span><br>
            Duration : <span>{{$flightData[0]['duration'] . 'h'}}</span><br>
            Arrival Time : <span>{{$flightData[0]['arrival_time_html']}}</span><br>
            Arrival Date : <span>{{$flightData[0]['arrival_date_html']}}</span><br>
            Airport To : <span>{{$flightData[0]['airport_to']}}</span><br>
            <br>
            <br>
            <strong>Return : </strong><br>
            <?php $flightData = json_decode($booking->flightData, true) ?? []; ?>
            {{-- <span>{{ dd($flightData);}}</span><br> --}}
                Title : <span>{{$flightData[1]['title']}}</span><br>
                Departure Time : <span>{{$flightData[1]['departure_time_html']}}</span><br>
                Departure Date : <span>{{$flightData[1]['departure_date_html']}}</span><br>
                Airport From : <span>{{$flightData[1]['airport_from']}}</span><br>
                Duration : <span>{{$flightData[1]['duration'] . 'h'}}</span><br>
                Arrival Time : <span>{{$flightData[1]['arrival_time_html']}}</span><br>
                Arrival Date : <span>{{$flightData[1]['arrival_date_html']}}</span><br>
                Airport To : <span>{{$flightData[1]['airport_to']}}</span><br>
                <br>
                <br>
                <?php
                $adultsString = $booking->adults;
                $childrenString = $booking->children;
                $infantsString = $booking->infants;
    
                $Booking_id_array = json_decode($booking->api_id, true) ?? [];
                $adultsForarray = json_decode($adultsString, true) ?? [];
                $title_array = json_decode($booking->title, true) ?? [];
                $childrenForarray = json_decode($childrenString, true) ?? [];
                $infantsForarray = json_decode($infantsString, true) ?? [];
                ?>
            Adults : <span>                
                @foreach ($adultsForarray as $item)
                {{$item}}
                @endforeach</span><br>
            Children : <span>                
                @foreach ($childrenForarray as $item)
                {{$item}}
                @endforeach</span><br>
            Infants : <span>                
                @foreach ($infantsForarray as $item)
                {{$item}}
                @endforeach</span><br>

        @else
        <h4>Flight Information </h4>
        <br>
            <strong>Flight One</strong><br>
            <?php $flightData = json_decode($booking->flightData, true) ?? []; ?>
            {{-- <span>{{ dd($flightData);}}</span><br> --}}
            Title : <span>{{$flightData['title']}}</span><br>
            Departure Time : <span>{{$flightData['departure_time_html']}}</span><br>
            Departure Date : <span>{{$flightData['departure_date_html']}}</span><br>
            Airport From : <span>{{$flightData['airport_from']}}</span><br>
            Duration : <span>{{$flightData['duration'] . 'h'}}</span><br>
            Arrival Time : <span>{{$flightData['arrival_time_html']}}</span><br>
            Arrival Date : <span>{{$flightData['arrival_date_html']}}</span><br>
            Airport To : <span>{{$flightData['airport_to']}}</span><br>
            <br>
            Children : <span>{{$booking->adults}}</span><br>
            Children : <span>{{$booking->children}}</span><br>
            Infants : <span>{{$booking->infants}}</span><br>
        @endif
        @else
        <div>
            <h4>Room Information</h4>
            
            <?php $hotelDatas = json_decode($booking->hotelData, true) ?? []; ?>
            @foreach($hotelDatas as $index => $hotelData)
            <br>
            <strong>Room {{$index + 1}}</strong> 
            <br>
            Title : <span>{{$hotelData['title']}}</span><br>
            Night Stay : <span>{{$hotelData['number_selected']}}</span><br>
            Adults : <span>{{$hotelData['adults_html']}}</span><br>
            Children : <span>{{$hotelData['children_html']}}</span><br>
            price : <span>{{$hotelData['price_text']}}</span><br>
            Ipr : <span>{{$hotelData['ipr']}}</span><br>
            <br>
            <strong>Features</strong>
            @foreach ($hotelData['desc'] as $item)
            <br>{{$item}}
            @endforeach
            @endforeach
        </div>
        @endif

        <hr>
        <div class="customer-info">
            <h5><strong>{{__('Billing to:')}}</strong></h5>
            <span>{{$booking->first_name.' '.$booking->last_name}}</span>
            <br>
            <br>
            <span>{{$booking->email}}</span><br>
            <span>{{$booking->phone}}</span><br>
            <span>{{$booking->address}}</span><br>
            <span>{{implode(', ',[$booking->city,$booking->state,$booking->zip_code,get_country_name($booking->country)])}}</span><br>
        </div>
        <hr>
        @if(!empty($service->email_new_booking_file))
            <div class="email_new_booking">
                @include($service->email_new_booking_file ?? '')
            </div>
        @endif
    </div>
@endpush
@push('js')
    <script type="text/javascript" src="{{ asset("module/user/js/user.js") }}"></script>
@endpush
