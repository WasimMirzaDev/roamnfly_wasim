<?php

namespace Modules\Hotel\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Modules\Hotel\Models\Hotel;
use Modules\Booking\Models\Booking;
use Modules\Hotel\Models\HotelRoomBooking;
use App\Services\BaseService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

class HotelService extends BaseService
{    

    public static $checkout_booking_detail_file = 'Hotel::frontend/booking/detail';
    public static $checkout_booking_detail_modal_file = 'Hotel::frontend/booking/detail-modal';
    public static $set_paid_modal_file = 'Hotel::frontend/booking/set-paid-modal';
    public $email_new_booking_file = 'Hotel::emails.new_booking_detail';
    
    public function searchHotel($param)
    {
        $this->clearHotelCache();
        $hotelIds       = $this->searchHotelIds($param);
        // dd($hotelIds);
        $hotelsDetail   = $this->searchHotelById($hotelIds);

        return $this->searchHotelDetail($hotelsDetail);
    }
    
    // this will return hotel ids only
    private function searchHotelIds($param)
    {
        // dd($this->setSearchParams($param));
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('hotel-searchquery-list'), $this->setSearchParams($param));
            if ($response->successful()) {
                return $response->json()['searchIds'];
            } else {
                // Log error and return empty array
                $this->generateEmailLog('hotel-searchquery-list', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('hotel-searchquery-list', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }

    private function setSearchParams($searchParams)
    {
        $roomInfo = [
        'numberOfAdults' => $searchParams['adults'],
        'numberOfChild' => $searchParams['children']
    ];
    
    // Conditionally add 'childAge' if there are children
    if ($searchParams['children'] != '0') {
        $roomInfo['childAge'] = [6]; // or dynamically generate the ages if needed
    }
    
        return  [
                    'searchQuery' => [
                        'checkinDate' => Carbon::parse($searchParams['start'][0])->format('Y-m-d'),
                        'checkoutDate' => Carbon::parse($searchParams['end'][0])->format('Y-m-d'),
                        'roomInfo' => [$roomInfo
                        ],
                        'searchCriteria' => [
                            'city' => $this->getLocationCode($searchParams['location_id']),
                            'nationality' => '106',
                            'currency' => 'INR'
                        ],
                        'searchPreferences' => [
                            'ratings' => $searchParams['star_rate'] ?? [3, 4, 5],
                            'fsc' => true
                        ]
                    ],
                    'sync' => false
                ];
    }

    // this will return hotel detail by givivng id
    private function searchHotelById($hotelIds)
    {
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('hotel-search'),['searchId' => $hotelIds]);
            if ($response->successful()) {
                return $response->json()['searchResult']['his'];
            } else {
                // Log error and return empty array
                $this->generateEmailLog('hotel-search', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('hotel-search', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }
    
    // this will return hotel complete detail by givivng id
    public function searchHotelDetail($hotelIds, $isAdmin = false)
    {
        $allHotels = [];
        if ($hotelIds) {
            foreach ($hotelIds as $hotelId) {
                try {
                    $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('hotelDetail-search'), ['id' => $hotelId['id']]);
                    if ($response->successful()) {
                        $hotelData = $response->json()['hotel'];
                        $allHotels[] = $hotelData;
                        // Store the hotel data in cache for 60 minutes
                        if(!$isAdmin){
                            Cache::put('hotel_'.$hotelData['id'], $hotelData);
                        }
                    } else {
                        // Log error but continue to the next hotel
                        $this->generateEmailLog('hotelDetail-search', $this->apiType, $response->status(), $response->body());
                    }
                } catch (\Exception $e) {
                    // Log exception but continue to the next hotel
                    $this->generateEmailLog('hotelDetail-search', $this->apiType, $e->getCode(), $e->getMessage());
                }
            }
        }

        return $allHotels;
    }

    // this will return hotel review/booking Id
    public function checkRoomAvailability($hotelId,$rooms_id)
    {
        // ini_set('max_execution_time', '300');
        $this->clearRoomCache();
        $allRooms = [];
        if($hotelId)
        {
            // $roomIds = $this->getHotelDetailFromCache($hotelId)['ops'] ?? '';

            // $roomIds = array_slice($roomIds, 0, 1);
            // dd($roomIds);
            if($rooms_id)
            {
                foreach($rooms_id as $roomId)
                {
                    if($roomId['id'])
                    {
                        try {
                            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('hotel-review'),['hotelId' => $hotelId, 'optionId' => $roomId['id']]);
                            if ($response->successful()) {
                                $roomData = $response->json();
                                if($roomData['status']['httpStatus'] == 200)
                                {
                                    $allRooms [] = [
                                                    'id'              => $roomData['hInfo']['ops'][0]['ris'][0]['id'] ?? '',
                                                    'title'           => $roomData['hInfo']['ops'][0]['ris'][0]['rc'] ?? '',
                                                    'short_name'      => $roomData['hInfo']['ops'][0]['ris'][0]['srn'] ?? '',
                                                    'desc'            => explode('-',$roomData['hInfo']['ops'][0]['ris'][0]['des']) ?? '',
                                                    'price'           => $roomData['hInfo']['ops'][0]['ris'][0]['tp'] ?? 0,
                                                    'size_html'       => '',
                                                    'beds_html'       => '',
                                                    'adults_html'     => $roomData['hInfo']['ops'][0]['ris'][0]['adt'] ? 'x' . $roomData['hInfo']['ops'][0]['ris'][0]['adt'] : '',
                                                    'children_html'   => $roomData['hInfo']['ops'][0]['ris'][0]['chd'] ? 'x' . $roomData['hInfo']['ops'][0]['ris'][0]['chd']: '',
                                                    'number_selected' => 0,
                                                    'number'          => 7,
                                                    'min_day_stays'   => 1,
                                                    'image'           => $roomData['hInfo']['ops'][0]['ris'][0]['imgs'][0]['url'] ?? '',
                                                    'tmp_number'      => 0,
                                                    'gallery'         => $roomData['hInfo']['ops'][0]['ris'][0]['imgs'],
                                                    'price_html'      => format_money($roomData['hInfo']['ops'][0]['ris'][0]['tp']) . '<span class="unit">/' . (count($roomData['hInfo']['ops'][0]['ris'][0]['pis'] ?? []) ? __(':count nights', ['count' => count($roomData['hInfo']['ops'][0]['ris'][0]['pis'] ?? [])]) : __(":count night", ['count' => count($roomData['hInfo']['ops'][0]['ris'][0]['pis'] ?? [])])) . '</span>',
                                                    'price_text'      => format_money($roomData['hInfo']['ops'][0]['ris'][0]['tp']) . '/' . (count($roomData['hInfo']['ops'][0]['ris'][0]['pis'] ?? [])  ? __(':count nights', ['count' => count($roomData['hInfo']['ops'][0]['ris'][0]['pis'] ?? [])]) : __(":count night", ['count' => count($roomData['hInfo']['ops'][0]['ris'][0]['pis'] ?? [])])),
                                                    'terms'           => $roomData['hInfo']['ops'][0]['ris'][0]['fcs'],
                                                    'term_features'   => $roomData['hInfo']['ops'][0]['ris'][0]['fcs'],
                                                    'bookingId'       => $roomData['bookingId'],
                                                    'conditions'      => $roomData['conditions'],
                                                    'ipr'      =>  $roomId['ipr']
                                                ];
                                    // Store the hotel data in cache for 60 minutes
                                    Cache::put('room_'.$roomData['hInfo']['ops'][0]['ris'][0]['id'], $roomData);
                                }
                            } else {
                                // Log error and return empty array
                                $this->generateEmailLog('hotel-review', $this->apiType, $response->status(), $response->body());
                                return [];
                            }
                        } catch (\Exception $e) {
                            $this->generateEmailLog('hotel-review', $this->apiType, $e->getCode(), $e->getMessage());
                            return [];
                        }
                    }
                }
            }
        }

        return $allRooms;
    }

    // this will book room by givivng id
    public function bookRoom(Request $request, $roomDetail, $bookingDetail)
    {
        // dd( $bookingDetail);
        // dd($this->setBookParams($request, $roomDetail, $bookingDetail));
        try {
            $api_ids = json_decode($bookingDetail->H_Booking_ids, true);
            if (is_array($api_ids) && !empty($api_ids)) {
                foreach ($api_ids as $index => $id) {
                    
            $totalIpr = json_decode($bookingDetail->totalIpr, true);
            $total = json_decode($bookingDetail->each_flight_price, true);
            // dd($this->setBookParams($request, $roomDetail, $bookingDetail ,$id, $total[$index]));
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('hotel/book','oms'), $this->setBookParams($request, $roomDetail, $bookingDetail ,$id, $total[$index] , $totalIpr[$index]));
            $bookingData = $response->json();
            $responseData=[];
            if ($response->successful()) {

            } else {
                // Log error and return empty array
                $this->generateEmailLog('hotel-book', $this->apiType, $response->status(), $response->body());
                $responseData['status'] =   false;
                $responseData['msg']    =   $bookingData['errors'][0]['message'] ?? 'something went wrong in booking hotel';
                return $responseData;
            }
        }}
        if($bookingData['status']['httpStatus'] == 200)
        {
            $responseData['status'] =   true;
            $responseData['msg']    =   'booking made successfully!';
            return $responseData;
            // return $this->bookedRoomDetail($response->json()['bookingId']);
        }
        } catch (\Exception $e) {
            $this->generateEmailLog('hotel-book', $this->apiType, $e->getCode(), $e->getMessage());
            $responseData['status'] = false;
            $responseData['msg'] = 'Something wrong with hotel api.';
            return $responseData;
        }
    }

    private function setBookParams($request, $roomDetail, $bookingDetail,$id ,$total ,$totalIpr)
    {
        $user = $request->all();
        $adults = $user['adults'] ?? []; // Use null coalescing operator to handle undefined keys
        $children = $user['children'] ?? [];
        $infants = $user['infants'] ?? [];
        $user['passport_expiry_date'] = Carbon::now()->addYears(10)->format('Y-m-d');

        $travellerInfo = [];

        // Process adults data if available
        if (!empty($adults)) {
            foreach ($adults as $adult) {
                $travellerInfo[] = [
                    'fN' => $adult['first_name'],
                    'lN' => $adult['last_name'],
                    'pan' => $totalIpr == 'true' ? $adult['pan'] : null, // Conditionally add 'pan'
                    'pNum' => $adult['passport'],
                    "dob" => $adult['dob'],
                    'ti' => 'Mr',
                    "pNat" => "IN",
                    'pt' => 'ADULT',
                    "eD" => $adult['eD'] ?? $user['passport_expiry_date'],
                    'pid' => $adult['pid'] ?? "2005-08-09"
                ];
            }
        }

        // Process children data if available
        if (!empty($children)) {
            foreach ($children as $child) {
                $travellerInfo[] = [
                    'fN' => $child['first_name'],
                    'lN' => $child['last_name'],
                    'pan' => $totalIpr == 'true' ? $child['pan'] : null, // Conditionally add 'pan'
                    'pNum' => $child['passport'],
                    "dob" => $child['dob'],
                    'ti' => 'Master',
                    "pNat" => "IN",
                    'pt' => 'CHILD',
                    "eD" => $child['eD'] ?? $user['passport_expiry_date'],
                    'pid' => $child['pid'] ?? "2005-08-09"
                ];
            }
        }

        // Further processing of $travellerInfo if needed


        $response = [
            'bookingId' => $id,
            'paymentInfos' => [
                    [
                        'amount' => $total,
                    ]
                ],
                'roomTravellerInfo'     => [
                    [ 'travellerInfo' => $travellerInfo ]],
            'type'                  => "HOTEL",
            'deliveryInfo' => [
                'emails' => [$user['email']],
                'contacts' => [$user['phone']],
                "code" => [
                    "+91"
                ]
            ]
        ];

        if ($bookingDetail->is_gst === true) {
            $response['gstInfo'] = [
                'gstNumber' => '07ABCDE1234F1Z5',  // Assuming 'gst_number' is provided in the request
                'email' => 'apitest@apitest.com',
                'registeredName' => 'XYZ Pvt Ltd',  // Assuming 'registered_name' is provided in the request
                'mobile' => '9728408906',
                'address' => 'Delhi',  // Assuming 'address' is provided in the request
            ];
        }
        // dd($response);
        return $response;
    }

    // this will book room detail by givivng id
    public function bookedRoomDetail($bookingId)
    {
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('booking-details','oms'), ['bookingId' => $bookingId]);
            $responseData=[];
            if ($response->successful()) {
                $bookingData = $response->json();
                if($bookingData['status']['httpStatus'] == 200)
                {
                    $responseData['status'] = true;
                    $responseresponseData['msg'] = 'Booked Successfully';
                    $responseData['booking']= $bookingData['order'];
                    return $responseData;
                }
            } else {
                // Log error and return empty array
                $this->generateEmailLog('hotel-booking-detail', $this->apiType, $response->status(), $response->body());
                $responseData['status'] = false;
                $responseData['msg'] = 'Something wrong in fetching booking detail.';
                return $responseData;
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('hotel-booking-detail', $this->apiType, $e->getCode(), $e->getMessage());
            $responseData['status'] = false;
            $responseData['msg'] = 'Something wrong in fetching booking detail.';
            return $responseData;
        }
    }

    public static function getDetailUrl($hotelId, $include_param = true)
    {
        $param = [];
        if ($include_param) {
            if (!empty($date = request()->input('date'))) {
                $dates = explode(" - ", $date);
                if (!empty($dates)) {
                    $param['start'] = $dates[0] ?? "";
                    $param['end'] = $dates[1] ?? "";
                }
            }
            if (!empty($location_id = request()->input('location_id'))) {
                $param['location_id'] = $location_id;
            }
            if (!empty($adults = request()->input('adults'))) {
                $param['adults'] = $adults;
            }
            if (!empty($children = request()->input('children'))) {
                $param['children'] = $children;
            }
            if (!empty($room = request()->input('room'))) {
                $param['room'] = $room;
            }
        }
        $urlDetail = app_get_locale(false, false, '/') . config('hotel.hotel_route_prefix') . "/" . $hotelId;
        if (!empty($param)) {
            $urlDetail .= "?" . http_build_query($param);
        }
        return url($urlDetail);
    }

    public function getHotelDetailFromCache($hotelId)
    {
        return Cache::get('hotel_' . $hotelId);
    }

    public function getRoomDetailFromCache($roomId)
    {
        return Cache::get('room_' . $roomId);
    }

    private function clearHotelCache()
    {
        if (Cache::has('hotel_*')) {
            $keys = Cache::getKeysMatching('hotel_*');
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        } 
        
        $this->clearRoomCache();
    }

    private function clearRoomCache()
    {
        if (Cache::has('room_*')) {
            $keys = Cache::getKeysMatching('room_*');
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }
    }

    public function getBookingData($row)
    {

        if (!empty($start = request()->input('start'))) {
            $start_html = display_date($start);
            $end_html = request()->input('end') ? display_date(request()->input('end')) : "";
            $date_html = $start_html . '<i class="fa fa-long-arrow-right" style="font-size: inherit"></i>' . $end_html;
        }
        $booking_data = [
            'id'              => $row['id'],
            'person_types'    => [],
            'max'             => 0,
            'open_hours'      => [],
            'extra_price'     => [],
            'minDate'         => date('m/d/Y'),
            'max_guests'      => $this->max_guests ?? 1,
            'buyer_fees'      => [],
            'i18n'            => [
                'date_required' => __("Please select check-in and check-out date"),
                "rooms"         => __('rooms'),
                "room"          => __('room'),
            ],
            'start_date'      => request()->input('start') ?? "",
            'start_date_html' => $date_html ?? __('Please select'),
            'end_date'        => request()->input('end') ?? "",
            'deposit'=>$this->isDepositEnable(),
            'deposit_type'=>$this->getDepositType(),
            'deposit_amount'=>$this->getDepositAmount(),
            'deposit_fomular'=>$this->getDepositFomular(),
            'is_form_enquiry_and_book'=> $this->isFormEnquiryAndBook(),
            'enquiry_type'=> $this->getBookingEnquiryType(),
        ];
        if (!empty($adults = request()->input('adults'))) {
            $booking_data['adults'] = $adults;
        }
        if (!empty($children = request()->input('children'))) {
            $booking_data['children'] = $children;
        }
        if (!empty($children = request()->input('room'))) {
            $booking_data['room'] = $children;
        }
        $lang = app()->getLocale();
        // if ($this->enable_extra_price) {
        //     $booking_data['extra_price'] = $this->extra_price;
        //     if (!empty($booking_data['extra_price'])) {
        //         foreach ($booking_data['extra_price'] as $k => &$type) {
        //             if (!empty($lang) and !empty($type['name_' . $lang])) {
        //                 $type['name'] = $type['name_' . $lang];
        //             }
        //             $type['number'] = 0;
        //             $type['enable'] = 0;
        //             $type['price_html'] = format_money($type['price']);
        //             $type['price_type'] = '';
        //             switch ($type['type']) {
        //                 case "per_day":
        //                     $type['price_type'] .= '/' . __('day');
        //                     break;
        //             }
        //             if (!empty($type['per_person'])) {
        //                 $type['price_type'] .= '/' . __('guest');
        //             }
        //         }
        //     }
        //     $booking_data['extra_price'] = array_values((array)$booking_data['extra_price']);
        // }
        $list_fees = setting_item_array('hotel_booking_buyer_fees');
        if (!empty($list_fees)) {
            foreach ($list_fees as $item) {
                $item['type_name'] = $item['name_' . app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_' . app()->getLocale()] ?? $item['desc'] ?? '';
                $item['price_type'] = '';
                if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                    $item['price_type'] .= '/' . __('guest');
                }
                $booking_data['buyer_fees'][] = $item;
            }
        }
        if(!empty($this->enable_service_fee) and !empty($service_fee = $this->service_fee)){
            foreach ($service_fee as $item) {
                $item['type_name'] = $item['name_' . app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_' . app()->getLocale()] ?? $item['desc'] ?? '';
                $item['price_type'] = '';
                if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                    $item['price_type'] .= '/' . __('guest');
                }
                $booking_data['buyer_fees'][] = $item;
            }
        }
        return $booking_data;
    }

    public function addToCart(Request $request)
    {
        // $res = $this->addToCartValidate($request);
        // if($res !== true) return $res;

        // Add Booking

        $total_guests = $request->input('adults') + $request->input('children');
        $adults = $request->input('adults');
        $children = $request->input('children');
        $discount = 0;
        $start_date = new \DateTime($request->input('start_date'));
        $end_date = new \DateTime($request->input('end_date'));
        $extra_price = [];
        $extra_price_input = $request->input('extra_price');
	    $extra_price = [];

	    $total = 0;
        $bookingIDS = [];
        $EachHotelPrice = [];
        $totalIpr = [];
        $total_room_selected = 0;
        if (!empty($request->rooms)) {
            foreach ($request->rooms as $room) {
                if (isset($room['id'])) {
                    if($room['number_selected'] > 0){
                        $total += $room['price'] * $room['number_selected'];
                        $total_room_selected += $room['number_selected'];
                        $bookingIDS[] = $room['bookingId']; // Append the string to the array
                        $EachHotelPrice[] = $room['price'] * $room['number_selected'];
                        $totalIpr[] = $room['ipr'];
                    }
                }
            }
        }

        // dd($bookingIDS);

        $duration_in_hour = max(1,ceil(($end_date->getTimestamp() - $start_date->getTimestamp()) / HOUR_IN_SECONDS ) );
        // if ($this->enable_extra_price and !empty($this->extra_price)) {
        //     if (!empty($this->extra_price)) {
        //         foreach ($this->extra_price as $k => $type) {
        //             if (isset($extra_price_input[$k]) and !empty($extra_price_input[$k]['enable'])) {
        //                 $type_total = 0;
        //                 switch ($type['type']) {
        //                     case "one_time":
        //                         $type_total = $type['price'];
        //                         break;
        //                     case "per_day":
        //                         $type_total = $type['price'] * ceil($duration_in_hour / 24);
        //                         break;
        //                 }
        //                 if (!empty($type['per_person'])) {
        //                     $type_total = $type_total * $total_guests;
        //                 }
        //                 $type['total'] = $type_total;
        //                 $total += $type_total;
        //                 $extra_price[] = $type;
        //             }
        //         }
        //     }
        // }

        //Buyer Fees for Admin
        $total_before_fees = $total;
        $total_buyer_fee = 0;
        // if (!empty($list_buyer_fees = setting_item('hotel_booking_buyer_fees'))) {
        //     $list_fees = json_decode($list_buyer_fees, true);
        //     $total_buyer_fee = $this->calculateServiceFees($list_fees , $total_before_fees , $total_guests);
        //     $total += $total_buyer_fee;
        // }

        //Service Fees for Vendor
        $total_service_fee = 0;
        // if(!empty($this->enable_service_fee) and !empty($list_service_fee = $this->service_fee)){
        //     $total_service_fee = $this->calculateServiceFees($list_service_fee , $total_before_fees , $total_guests);
        //     $total += $total_service_fee;
        // }

        $booking = new Booking;
        $booking->status = 'draft';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = 0;
        $booking->customer_id = Auth::id();
        $booking->total = $total;
        $booking->api_id = $request->service_id;
        $booking->adults = $adults;
        $booking->H_Booking_ids = json_encode($bookingIDS);
        $booking->totalIpr = json_encode($totalIpr);
        $booking->children = $children;
        $booking->title = $this->getHotelDetailFromCache($request->service_id)['name'];
        $booking->total_guests = $total_guests;
        $booking->each_flight_price = json_encode($EachHotelPrice);
        $booking->start_date = $start_date->format('Y-m-d H:i:s');
        $booking->end_date = $end_date->format('Y-m-d H:i:s');
        
        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        // $booking->calculateCommission();

        // if($this->isDepositEnable())
        // {
        //     $booking_deposit_fomular = $this->getDepositFomular();
        //     $tmp_price_total = $booking->total;
        //     if($booking_deposit_fomular == "deposit_and_fee"){
        //         $tmp_price_total = $booking->total_before_fees;
        //     }

        //     switch ($this->getDepositType()){
        //         case "percent":
        //             $booking->deposit = $tmp_price_total * $this->getDepositAmount() / 100;
        //             break;
        //         default:
        //             $booking->deposit = $this->getDepositAmount();
        //             break;
        //     }
        //     if($booking_deposit_fomular == "deposit_and_fee"){
        //         $booking->deposit = $booking->deposit + $total_buyer_fee + $total_service_fee;
        //     }
        // }

        $check = $booking->save();

        if ($check) {
            Booking::clearDraftBookings();
            $booking->addMeta('duration', $booking->duration_nights);
            $booking->addMeta('base_price', $total);
            $booking->addMeta('sale_price', $total);
            $booking->addMeta('guests', $total_guests);
            $booking->addMeta('adults', $request->input('adults'));
            $booking->addMeta('children', $request->input('children'));
            $booking->addMeta('extra_price', $extra_price);

            // if($this->isDepositEnable())
            // {
            //     $booking->addMeta('deposit_info',[
            //         'type'=>$this->getDepositType(),
            //         'amount'=>$this->getDepositAmount(),
            //         'fomular'=>$this->getDepositFomular(),
            //     ]);
            // }
            
            // Add Room Booking
            if (!empty($request->rooms)) {
                foreach ($request->rooms as $room) {
                    if (isset($room['id'])) {
                        if($room['number_selected'] > 0){
                            $hotelRoomBooking = new HotelRoomBooking();
                            $hotelRoomBooking->fillByAttr([
                                'api_room_id',
                                'api_hotel_id',
                                'start_date',
                                'end_date',
                                'number',
                                'booking_id',
                                'price',
                                'title'
                            ], [
                                'api_room_id' => $room['id'],
                                'api_hotel_id' => $request->service_id,
                                'start_date' => $start_date->format('Y-m-d H:i:s'),
                                'end_date'   => $end_date->format('Y-m-d H:i:s'),
                                'number'     => $room['number_selected'],
                                'booking_id' => $booking->id,
                                'price'      => $room['price'],
                                'title'      => $room['short_name']
                            ]);
                            $hotelRoomBooking->save();
                        }
                    }
                }
            }
            return [
                    'url' => $booking->getCheckoutUrl(),
                    'booking_code' => $booking->code,
                ];
        }
    }

    public static function isEnableEnquiry()
    {
        if(!empty(setting_item('booking_enquiry_for_hotel'))){
            return true;
        }
        return false;
    }

    public static function isFormEnquiryAndBook()
    {
        $check = setting_item('booking_enquiry_for_hotel');
        if(!empty($check) and setting_item('booking_enquiry_type_hotel') == "booking_and_enquiry" ){
            return true;
        }
        return false;
    }

    public static function getBookingEnquiryType()
    {
        $check = setting_item('booking_enquiry_for_hotel');
        if(!empty($check)){
            if( setting_item('booking_enquiry_type_hotel') == "only_enquiry" ) {
                return "enquiry";
            }
        }
        return "book";
    }

    public static function isEnable()
    {
        return setting_item('hotel_disable') == false;
    }

    public function isDepositEnable()
    {
        return (setting_item('hotel_deposit_enable') and setting_item('hotel_deposit_amount'));
    }
    
    public function getDepositAmount()
    {
        return setting_item('hotel_deposit_amount');
    }
    
    public function getDepositType()
    {
        return setting_item('hotel_deposit_type');
    }
    
    public function getDepositFomular()
    {
        return setting_item('hotel_deposit_fomular','default');
    }
}