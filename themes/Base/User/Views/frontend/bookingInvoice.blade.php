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
    <link href="{{ asset('module/user/css/style.css') }}" rel="stylesheet">
<script>
        window.print();
    </script>
    <div id="invoice-print-zone">
        <div>
            <div class="py-4">
              <div class="px-14 py-6">
                <table class="w-full border-collapse border-spacing-0">
                  <tbody>
                    <tr>
                      <td class="w-full align-top">
                        <div>
                          <div class="h-12" style="    font-size: 34px;
    font-weight: 900;
">INVIOCE</div>
                        </div>
                      </td>
        
                      <td class="align-top">
                        <div class="text-sm">
                          <table class="border-collapse border-spacing-0">
                            <tbody>
                              <tr>
                                <td class="border-r pr-4">
                                  <div>
                                    <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                                    <p class="whitespace-nowrap font-bold text-main text-right">April 26, 2023</p>
                                  </div>
                                </td>
                                <td class="pl-4">
                                  <div>
                                    <p class="whitespace-nowrap text-slate-400 text-right">Invoice #</p>
                                    <p class="whitespace-nowrap font-bold text-main text-right">{{$booking->id}}</p>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
        
              <div class="bg-slate-100 px-14  py-6 text-sm" style="margin-top: 50px; margin-bottom:50px;">
                <table class="w-full border-collapse border-spacing-0">
                  <tbody>
                    <tr>
                      <td class="w-1/2 align-top">
                        <div class="text-sm text-neutral-600">
                            {!! setting_item_with_lang("invoice_company_info") !!}
                        </div>
                      </td>
                      <td class="w-1/2 align-top text-right">
                        <div class="text-sm text-neutral-600">
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
                                    <p>{{'Booking ID: '}}                @foreach ($Booking_id_array as $item)
                                    {{$item}}
                                    @endforeach</p>
                                    <p>{{('Status: ' . $booking->status)}}</p>
                                    <p>{{('Service: ' . $booking->object_model)}}</p>
                                    <p>{{('Travel Type: ' . $booking->travel_type)}}</p>
                                    @else
                
                                    <p>{{('Booking ID: ' . $booking->api_id)}}</p>
                                    <p>{{('Status: ' . $booking->status)}}</p>
                                    <p>{{('Service: ' . $booking->object_model)}}</p>
                                    <p>{{('Travel Type: ' . $booking->travel_type)}}</p>
                                    @endif
                                    {{-- Booking Status : {{$booking->status}} --}}
                                    {{-- Type : <span>{{$booking->object_model}}</span></p>
                                    Code : <span>{{$booking->code}}</span><br>
                                    Travel Type : <span>{{$booking->travel_type}}</span><br>
                                    Booking ID : <span>{{$booking->api_id}}</span><br> --}}
                                    @else
                                    <p>{{('Booking ID: ' . $booking->api_id)}}</p>
                                    <p>{{('Status: ' . $booking->status)}}</p>
                                    <p>{{('Service: ' . $booking->object_model)}}</p>
                                    @endif
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
        
              <div class="px-14 py-10 text-sm text-neutral-700">
                <table class="w-full border-collapse border-spacing-0">
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
                    {{-- <h4>Flight Information </h4> --}}
                    <thead>
                        <tr>
                          <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                          <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Title</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Airport From</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Airport To</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Departure Date</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Duration</td>
                          <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Price</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $flightDatas = json_decode($booking->flightData, true) ?? []; ?>
                        <?php $EachFlightPrice = json_decode($booking->each_flight_price, true) ?? []; ?>
                        @foreach($flightDatas as $index => $flightData )
                        <tr>
                          <td class="border-b py-3 pl-3">{{$index + 1}}</td>
                          <td class="border-b py-3 pl-2">{{$flightData['title']}}</td>
                          <td class="border-b py-3 pl-2 text-right">{{$flightData['airport_from']}}</td>
                          <td class="border-b py-3 pl-2 text-center">{{$flightData['airport_to']}}</td>
                          <td class="border-b py-3 pl-2 text-center">{{$flightData['departure_date_html']}}</td>
                          <td class="border-b py-3 pl-2 text-right">{{$flightData['duration'] . 'h'}}</td>
                          <td class="border-b py-3 pl-2 pr-3 text-right">{{format_money($EachFlightPrice[$index])}}</td>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="7">
                            <table class="w-full border-collapse border-spacing-0">
                              <tbody>
                                <tr>
                                  <td class="w-full"></td>
                                  <td>
                                    <table class="w-full border-collapse border-spacing-0">
                                      <tbody>
                                        <tr>
                                          <td class="border-b p-3">
                                            <div class="whitespace-nowrap text-slate-400">Net total:</div>
                                          </td>
                                          <td class="border-b p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->total)}}</div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="p-3">
                                            <div class="whitespace-nowrap text-slate-400">total paid:</div>
                                          </td>
                                          <td class="p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->paid)}}</div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="bg-main p-3">
                                            <div class="whitespace-nowrap font-bold text-white">Total Remaining:</div>
                                          </td>
                                          <td class="bg-main p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-white">{{format_money($booking->total - $booking->paid)}}</div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>

                    </div>
                    @elseif($booking->travel_type == 'Round Trip')
                    {{-- <h4>Flight Information </h4> --}}
                    <br>
                    <thead>
                        <tr>
                          <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                          <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Title</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Airport From</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Airport To</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Departure Date</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Duration</td>
                          <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Price</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $flightData = json_decode($booking->flightData, true) ?? []; ?>
                        <?php $EachFlightPrice = json_decode($booking->each_flight_price, true) ?? []; ?>
                        {{-- @foreach($flightDatas as $index => $flightData ) --}}
                        <tr>
                          <td class="border-b py-3 pl-3">Depart</td>
                          <td class="border-b py-3 pl-2">{{$flightData[0]['title']}}</td>
                          <td class="border-b py-3 pl-2 text-right">{{$flightData[0]['airport_from']}}</td>
                          <td class="border-b py-3 pl-2 text-center">{{$flightData[0]['airport_to']}}</td>
                          <td class="border-b py-3 pl-2 text-center">{{$flightData[0]['departure_date_html']}}</td>
                          <td class="border-b py-3 pl-2 text-right">{{$flightData[0]['duration'] . 'h'}}</td>
                          <td class="border-b py-3 pl-2 pr-3 text-right">{{format_money($flightData[0]['flight_seat'][0]['price'])}}</td>
                        </tr>
                        <tr>
                            <td class="border-b py-3 pl-3">Return</td>
                            <td class="border-b py-3 pl-2">{{$flightData[1]['title']}}</td>
                            <td class="border-b py-3 pl-2 text-right">{{$flightData[1]['airport_from']}}</td>
                            <td class="border-b py-3 pl-2 text-center">{{$flightData[1]['airport_to']}}</td>
                            <td class="border-b py-3 pl-2 text-center">{{$flightData[1]['departure_date_html']}}</td>
                            <td class="border-b py-3 pl-2 text-right">{{$flightData[1]['duration'] . 'h'}}</td>
                            <td class="border-b py-3 pl-2 pr-3 text-right">{{format_money($flightData[1]['flight_seat'][0]['price'])}}</td>
                          </tr>
                        {{-- @endforeach --}}
                        <tr>
                          <td colspan="7">
                            <table class="w-full border-collapse border-spacing-0">
                              <tbody>
                                <tr>
                                  <td class="w-full"></td>
                                  <td>
                                    <table class="w-full border-collapse border-spacing-0">
                                      <tbody>
                                        <tr>
                                          <td class="border-b p-3">
                                            <div class="whitespace-nowrap text-slate-400">Net total:</div>
                                          </td>
                                          <td class="border-b p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->total)}}</div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="p-3">
                                            <div class="whitespace-nowrap text-slate-400">total paid:</div>
                                          </td>
                                          <td class="p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->paid)}}</div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="bg-main p-3">
                                            <div class="whitespace-nowrap font-bold text-white">Total Remaining:</div>
                                          </td>
                                          <td class="bg-main p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-white">{{format_money($booking->total - $booking->paid)}}</div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    @else
                    <br>
                    <thead>
                        <tr>
                          <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                          <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Title</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Airport From</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Airport To</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Departure Date</td>
                          <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Duration</td>
                          <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Price</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $flightData = json_decode($booking->flightData, true) ?? []; ?>
                        <?php $EachFlightPrice = json_decode($booking->each_flight_price, true) ?? []; ?>
                        {{-- @foreach($flightDatas as $index => $flightData ) --}}
                        <tr>
                          <td class="border-b py-3 pl-3">{{1.}}</td>
                          <td class="border-b py-3 pl-2">{{$flightData['title']}}</td>
                          <td class="border-b py-3 pl-2 text-right">{{$flightData['airport_from']}}</td>
                          <td class="border-b py-3 pl-2 text-center">{{$flightData['airport_to']}}</td>
                          <td class="border-b py-3 pl-2 text-center">{{$flightData['departure_date_html']}}</td>
                          <td class="border-b py-3 pl-2 text-right">{{$flightData['duration'] . 'h'}}</td>
                          <td class="border-b py-3 pl-2 pr-3 text-right">{{format_money($booking->total)}}</td>
                        </tr>
                        {{-- @endforeach --}}
                        <tr>
                          <td colspan="7">
                            <table class="w-full border-collapse border-spacing-0">
                              <tbody>
                                <tr>
                                  <td class="w-full"></td>
                                  <td>
                                    <table class="w-full border-collapse border-spacing-0">
                                      <tbody>
                                        <tr>
                                          <td class="border-b p-3">
                                            <div class="whitespace-nowrap text-slate-400">Net total:</div>
                                          </td>
                                          <td class="border-b p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->total)}}</div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="p-3">
                                            <div class="whitespace-nowrap text-slate-400">total paid:</div>
                                          </td>
                                          <td class="p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->paid)}}</div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="bg-main p-3">
                                            <div class="whitespace-nowrap font-bold text-white">Total Remaining:</div>
                                          </td>
                                          <td class="bg-main p-3 text-right">
                                            <div class="whitespace-nowrap font-bold text-white">{{format_money($booking->total - $booking->paid)}}</div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    @endif
                    @else
                    <div>

                        <thead>
                            <tr>
                              <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                              <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Title</td>
                              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Night Stay</td>
                              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Adults</td>
                              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Children</td>
                              <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Ipr</td>
                              <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Price</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $hotelDatas = json_decode($booking->hotelData, true) ?? []; ?>
                            @foreach($hotelDatas as $index => $hotelData)
                            <tr>
                              <td class="border-b py-3 pl-3">Room  {{ $index + 1}}</td>
                              <td class="border-b py-3 pl-2">{{$hotelData['title']}}</td>
                              <td class="border-b py-3 pl-2 text-right">{{$hotelData['number_selected']}}</td>
                              <td class="border-b py-3 pl-2 text-center">{{$hotelData['adults_html']}}</td>
                              <td class="border-b py-3 pl-2 text-center">{{$hotelData['children_html']}}</td>
                              <td class="border-b py-3 pl-2 text-right">{{$hotelData['ipr']}}</td>
                              <td class="border-b py-3 pl-2 pr-3 text-right">{{$hotelData['price_text']}}</td>
                            </tr>
                            @endforeach
                            <tr>
                              <td colspan="7">
                                <table class="w-full border-collapse border-spacing-0">
                                  <tbody>
                                    <tr>
                                      <td class="w-full"></td>
                                      <td>
                                        <table class="w-full border-collapse border-spacing-0">
                                          <tbody>
                                            <tr>
                                              <td class="border-b p-3">
                                                <div class="whitespace-nowrap text-slate-400">Net total:</div>
                                              </td>
                                              <td class="border-b p-3 text-right">
                                                <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->total)}}</div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="p-3">
                                                <div class="whitespace-nowrap text-slate-400">total paid:</div>
                                              </td>
                                              <td class="p-3 text-right">
                                                <div class="whitespace-nowrap font-bold text-main">{{format_money($booking->paid)}}</div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="bg-main p-3">
                                                <div class="whitespace-nowrap font-bold text-white">Total Remaining:</div>
                                              </td>
                                              <td class="bg-main p-3 text-right">
                                                <div class="whitespace-nowrap font-bold text-white">{{format_money($booking->total - $booking->paid)}}</div>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                    </div>
                    @endif
                  
                </table>
              </div>
        
              <div class="px-14 text-sm text-neutral-700">
                <p class="text-main font-bold">Billing to:</p>
                <p>{{$booking->first_name.' '.$booking->last_name}}</p>
                <p>{{$booking->email}}</p>
                <p>{{$booking->phone}}</p>
                <p>{{$booking->address}}</p>
                <p>{{implode(', ',[$booking->city,$booking->state,$booking->zip_code,get_country_name($booking->country)])}}</p>
              </div>
        
              <div class="px-14 py-10 text-sm text-neutral-700">
                <p class="text-main font-bold">Notes</p>
                <p class="italic">Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries
                  for previewing layouts and visual mockups.</p>
                </dvi>
        
                <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
                  Supplier Company
                  <span class="text-slate-300 px-2">|</span>
                  info@company.com
                  <span class="text-slate-300 px-2">|</span>
                  +1-202-555-0106
                </footer>
              </div>
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
