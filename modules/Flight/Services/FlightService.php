<?php

namespace Modules\Flight\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Airline;
use Modules\Booking\Models\Booking;
use Modules\Flight\Models\BookingPassengers;
use App\Services\BaseService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Cookie;

class FlightService extends BaseService
{

    public static $checkout_booking_detail_file = 'Flight::frontend/booking/detail';
    public static $checkout_return_booking_detail_file = 'Flight::frontend/booking/returnDetail';
    public static $checkout_multi_booking_detail_file = 'Flight::frontend/booking/multiFlightDetail';
    public static $checkout_booking_detail_modal_file = 'Flight::frontend/booking/detail-modal';
    public static $set_paid_modal_file = 'Flight::frontend/booking/set-paid-modal';
    public $email_new_booking_file = 'Flight::emails.new_booking_detail';


    public function searchMultiFlights($param)
    {
        $this->clearFlightCache();
        return $this->getSearchFlightsMulti($param);
    }

    public function searchFlight($param)
    {

        $this->clearFlightCache();
        return $this->getSearchFlights($param);
    }

    // private function getSearchFlightsC($param)
    // {
    //     try {
    //         $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('air-search-all','fms'), $this->setSearchParams($param));
    //         if ($response->successful()) {
    //             $flightData = $response->json()['searchResult']['tripInfos'];
    //             return $flightData;
    //         } else {
    //             // Log error and return empty array
    //             $this->generateEmailLog('air-search-all', $this->apiType, $response->status(), $response->body());
    //             return [];
    //         }
    //     } catch (\Exception $e) {
    //         $this->generateEmailLog('air-search-all', $this->apiType, $e->getCode(), $e->getMessage());
    //         return [];
    //     }
    // }

    public function getSearchFlightsMulti($param)
    {
        try {
            // return $param;
            $responses = []; // Array to store all responses
            if ($param['travel_type'] == 'Multicity') {
                foreach ($param['from_where'] as $index => $orignCity) {
                    $response = Http::withHeaders(['apikey' => $this->apiToken])
                        ->post($this->getEndpoint('air-search-all', 'fms'), $this->setSearchParams($param, $index));

                    if ($response->successful()) {
                        $responses[] = $response->json()['searchResult']['tripInfos'];
                    }
                }
            }
            return $responses;
        } catch (\Exception $e) {
            // Catch any exceptions and log them
            $this->generateEmailLog('air-search-all', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }

    private function getSearchFlights($param)
    {
        try {
            // return $param;
            // return $this->setSearchParams($param);
            $index = 0;
            $response = Http::withHeaders(['apikey' => $this->apiToken])
                ->post($this->getEndpoint('air-search-all', 'fms'), $this->setSearchParams($param, $index));

            if ($response->successful()) {

                // $flightData = $response->json()['searchResult']['tripInfos'];
                // return $flightData;
                // dd($response->json()['searchResult']['tripInfos']);
                $flightData = $response->json()['searchResult']['tripInfos'];
                // return $flightData;
                return $flightData;
                // $filteredFlights = [];
                // if (array_key_exists('RETURN', $flightData)) {
                //     // $list    =  $flightData['ONWARD'];
                //     // $return  =  $flightData['RETURN'];
                //     // $lists   = $this->pairFlights($list,$return);
                //     // return $list;
                //     return $flightData;

                //     $filteredComboFlights = [];
                //     $successfulResponse = false;
                //     foreach ($lists as $list) {
                //         $excludeList = false;
                //         $idArray = [];

                //         foreach ($list as $element) {
                //             $currentId = $element['totalPriceList'][0]['id'];
                //             $idArray[] = $currentId;
                //         }

                //         $id = implode(',', $idArray);
                //         $id = strpos($id, ',') !== false ? explode(',', $id) : [$id];

                //         $reviewResponse = Http::withHeaders(['apikey' => $this->apiToken])
                //             ->post($this->getEndpoint('review', 'fms'), ['priceIds' => $id]);

                //         if ($reviewResponse->successful()) {
                //             $successfulResponse = true;
                //         } else {
                //             $excludeList = true;
                //         }

                //         if (!$excludeList) {
                //             $filteredComboFlights[] = $list;
                //         }
                //     }
                //     if (!empty($filteredComboFlights)) {
                //         $filteredFlights['COMBO'] = $filteredComboFlights;
                //     }
                // }
                // // Handle COMBO flights
                // if (array_key_exists('COMBO', $flightData)) {
                //     // dd($flightData);
                //     $filteredComboFlights = []; // Temporary array for valid COMBO flights
                //     $lists = $this->pairComboFlights($flightData['COMBO']);
                //     // $filteredFlights['COMBO'] = $lists;
                //     // dd($lists);
                //     // return $filteredFlights;
                //     // return $filteredFlights;

                //     $successfulResponse = false; // Flag to track if there's a successful response

                //     foreach ($lists as $list) {
                //         $excludeList = false;
                //         $idArray = [];

                //         foreach ($list as $element) {
                //             $currentId = $element['totalPriceList'][0]['id'];
                //             $idArray[] = $currentId;
                //         }

                //         $id = implode(',', $idArray);
                //         $id = strpos($id, ',') !== false ? explode(',', $id) : [$id];

                //         $reviewResponse = Http::withHeaders(['apikey' => $this->apiToken])
                //             ->post($this->getEndpoint('review', 'fms'), ['priceIds' => $id]);

                //         if ($reviewResponse->successful()) {
                //             $successfulResponse = true;
                //         } else {
                //             $excludeList = true;
                //         }

                //         if (!$excludeList) {
                //             $filteredComboFlights[] = $list;
                //         }
                //     }
                //     if (!empty($filteredComboFlights)) {
                //         $filteredFlights['COMBO'] = $filteredComboFlights;
                //     }
                // }

                // // Handle ONWARD flights
                // if (array_key_exists('ONWARD', $flightData)) {
                //     foreach ($flightData['ONWARD'] as $onward) {
                //         $id = $onward['totalPriceList'][0]['id'];
                //         $id = strpos($id, ',') !== false ? explode(',', $id) : [$id];

                //         $reviewResponse = Http::withHeaders(['apikey' => $this->apiToken])
                //             ->post($this->getEndpoint('review', 'fms'), ['priceIds' => $id]);

                //         if ($reviewResponse->successful()) {
                //             $filteredFlights['ONWARD'][] = $onward;
                //         }
                //     }
                // }
                // return $filteredFlights;
            } else {
                // Log error if the initial search API call fails
                $this->generateEmailLog('air-search-all', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            // Catch any exceptions and log them
            $this->generateEmailLog('air-search-all', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }


    public function reviewSelectedFlight($id)
    {
        if (strpos($id, ',') !== false) {
            $id = explode(',', $id);
        } else {
            $id = [$id];
        }
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('review', 'fms'), ['priceIds' => $id]);

            if ($response->successful()) {
                $flightData = $response->json()['tripInfos'];
                Cache::put('flights', $flightData);
                // dd($response->json());
                return $response->json();
            } else {
                // Log error and return empty array
                $this->generateEmailLog('review', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('review', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }


    public function reviewSelectedMultiFlight($id)
    {
        if (strpos($id, ',') !== false) {
            $id = explode(',', $id);
        } else {
            $id = [$id];
        }
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('review', 'fms'), ['priceIds' => $id]);

            if ($response->successful()) {
                $flightData = $response->json()['tripInfos'];
                Cache::put('flights', $flightData);

                return $response->json();
            } else {
                // Log error and return empty array
                $this->generateEmailLog('review', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('review', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }

    private function setSearchParams($searchParams, $index)
    {

        // return $searchParams;
        // return $searchParams['seat_type']['class'];
        if (empty($searchParams['seat_type']['class'])) {
            $searchParams['seat_type']['class'] = "";
        }

        // $paramsJson = json_encode($info);

        // // Delete the old cookie
        // Cookie::queue(Cookie::forget('flight_search_params'));

        // // Store the new parameters in a cookie
        // Cookie::queue(Cookie::make('flight_search_params', $paramsJson, 60, '/', null, false, true, 'None'));
        return [
            'searchQuery' => [
                'cabinClass' => $this->cabinClass($searchParams['seat_type']['class']),
                'paxInfo' => [
                    'ADULT' => $searchParams['seat_type']['adults'],
                    'CHILD' => $searchParams['seat_type']['children'],
                    'INFANT' => $searchParams['seat_type']['infants']
                ]
                ,
                'routeInfos' => $this->getRouteInfo($searchParams, $index),
                'searchModifiers' => [
                    'isDirectFlight' => true,
                    'isConnectingFlight' => false
                ]
            ]
        ];
    }

    private function getRouteInfo($searchParams, $index)
    {

        if ($searchParams['travel_type'] == 'One Way') {
            $routeInfos[] = [
                'fromCityOrAirport' => [
                    'code' => $searchParams['from_where'][0]
                ],
                'toCityOrAirport' => [
                    'code' => $searchParams['to_where'][0]
                ],
                'travelDate' => Carbon::parse($searchParams['start'][0])->format('Y-m-d')
            ];
        } elseif ($searchParams['travel_type'] == 'Round Trip') {
            $routeInfos[] = [
                'fromCityOrAirport' => [
                    'code' => $searchParams['from_where'][0]
                ],
                'toCityOrAirport' => [
                    'code' => $searchParams['to_where'][0]
                ],
                'travelDate' => Carbon::parse($searchParams['start'][0])->format('Y-m-d')
            ];
            $routeInfos[] = [
                'fromCityOrAirport' => [
                    'code' => $searchParams['to_where'][0]
                ],
                'toCityOrAirport' => [
                    'code' => $searchParams['from_where'][0]
                ],
                'travelDate' => Carbon::parse($searchParams['end'][0])->format('Y-m-d')
            ];
        } elseif ($searchParams['travel_type'] == 'Multicity') {
            $routeInfos = [];
            $routeInfos[] = [
                'fromCityOrAirport' => [
                    'code' => $searchParams['from_where'][$index]
                ],
                'toCityOrAirport' => [
                    'code' => $searchParams['to_where'][$index]
                ],
                'travelDate' => Carbon::parse($searchParams['start'][$index])->format('Y-m-d')
            ];
        }
        return $routeInfos;
    }

    public function cabinClass($type)
    {

        switch ($type) {
            case 'eco':
                return 'ECONOMY';
                break;
            case 'premium':
                return 'PREMIUM_ECONOMY';
                break;
            case 'fist_class':
                return 'FIRST';
                break;
            case 'business':
                return 'BUSINESS';
                break;
            default:
                return 'unknown';
        }
    }

    public function formatApiData($data)
    {
        $tripInfo = $data['tripInfos'] ?? '';
        $rows = collect();

        if ($tripInfo) {
            // dd($tripInfo);
            foreach ($tripInfo as $info) {
                $flight_seats = [];
                $row = collect([
                    'title' => $info['sI'][0]['fD']['aI']['name'] ?? '',
                    'code' => $info['sI'][0]['fD']['aI']['code'] ?? '',
                    'logo
                    ' => $this->getAirLineLogo($info['sI'][0]['fD']['aI']['code'] ?? '', true),
                    'departure_time_html' => isset($info['sI'][0]['dt']) ? Carbon::parse($info['sI'][0]['dt'])->format('H:i') : '',
                    'duration' => isset($info['sI'][0]['duration']) ? number_format(($info['sI'][0]['duration'] / 60), 2) : '',
                    'departure_date_html' => isset($info['sI'][0]['dt']) ? Carbon::parse($info['sI'][0]['dt'])->format('D, d M y') : '',
                    'airport_from' => $info['sI'][0]['da']['name'] ?? '',
                    'arrival_time_html' => isset($info['sI'][0]['at']) ? Carbon::parse($info['sI'][0]['at'])->format('H:i') : '',
                    'arrival_date_html' => isset($info['sI'][0]['at']) ? Carbon::parse($info['sI'][0]['at'])->format('D, d M y') : '',
                    'airport_to' => $info['sI'][0]['aa']['name'] ?? '',
                    'booking_id' => $data['bookingId'] ?? '',
                    'is_gst' => $data['conditions']['gst']['igm'] ?? '',
                    'id' => $info['sI'][0]['id'] ?? '',
                ]);

                $flight_seats = []; // Initialize the array

                // Start by creating the base array with default values
                $seat_entry = [];

                // Add Adult data
                $seat_entry['seat_type'] = ucwords(strtolower($info['totalPriceList'][0]['fd']['ADULT']['cc'] ?? ''));
                $seat_entry['person'] = $info['totalPriceList'][0]['fd'][0] ?? '';
                $seat_entry['baggage_check_in'] = $info['totalPriceList'][0]['fd']['ADULT']['bI']['iB'] ?? '';
                $seat_entry['baggage_cabin'] = $info['totalPriceList'][0]['fd']['ADULT']['bI']['cB'] ?? '';
                $seat_entry['number'] = 0;
                $seat_entry['max_passengers'] = $info['totalPriceList'][0]['fd']['ADULT']['sR'] ?? '';
                $seat_entry['price_html'] = isset($info['totalPriceList'][0]['fd']['ADULT']['fC']['TF']) ? format_money($info['totalPriceList'][0]['fd']['ADULT']['fC']['TF']) : '';
                $seat_entry['price'] = $info['totalPriceList'][0]['fd']['ADULT']['fC']['TF'] ?? '';

                // Add Child data if available
                if (isset($info['totalPriceList'][0]['fd']['CHILD'])) {
                    $seat_entry['Child_seat_type'] = ucwords(strtolower($info['totalPriceList'][0]['fd']['CHILD']['cc'] ?? ''));
                    $seat_entry['Child_person'] = $info['totalPriceList'][0]['fd']['CHILD'][0] ?? '';
                    $seat_entry['Child_baggage_check_in'] = $info['totalPriceList'][0]['fd']['CHILD']['bI']['iB'] ?? '';
                    $seat_entry['Child_baggage_cabin'] = $info['totalPriceList'][0]['fd']['CHILD']['bI']['cB'] ?? '';
                    $seat_entry['Child_number'] = 0;
                    $seat_entry['Child_max_passengers'] = $info['totalPriceList'][0]['fd']['CHILD']['sR'] ?? '';
                    $seat_entry['Child_price_html'] = isset($info['totalPriceList'][0]['fd']['CHILD']['fC']['TF']) ? format_money($info['totalPriceList'][0]['fd']['CHILD']['fC']['TF']) : '';
                    $seat_entry['Child_price'] = $info['totalPriceList'][0]['fd']['CHILD']['fC']['TF'] ?? '';
                }

                // Add Infants data if available
                if (isset($info['totalPriceList'][0]['fd']['INFANT'])) {
                    $seat_entry['Infants_seat_type'] = ucwords(strtolower($info['totalPriceList'][0]['fd']['INFANT']['cc'] ?? ''));
                    $seat_entry['Infants_person'] = $info['totalPriceList'][0]['fd']['INFANT'][0] ?? '';
                    $seat_entry['Infants_baggage_check_in'] = $info['totalPriceList'][0]['fd']['INFANT']['bI']['iB'] ?? '';
                    $seat_entry['Infants_baggage_cabin'] = $info['totalPriceList'][0]['fd']['INFANT']['bI']['cB'] ?? '';
                    $seat_entry['Infants_number'] = 0;
                    $seat_entry['Infants_max_passengers'] = $info['totalPriceList'][0]['fd']['INFANT']['sR'] ?? '';
                    $seat_entry['Infants_price_html'] = isset($info['totalPriceList'][0]['fd']['INFANT']['fC']['TF']) ? format_money($info['totalPriceList'][0]['fd']['INFANT']['fC']['TF']) : '';
                    $seat_entry['Infants_price'] = $info['totalPriceList'][0]['fd']['INFANT']['fC']['TF'] ?? '';
                }

                // Add the constructed entry to the flight_seats array
                $flight_seats[] = $seat_entry;

                // Now $flight_seats contains the data for all available passenger types in a single array


                $row->put('flight_seat', $flight_seats);
                $rows->push($row);
            }
        }
        return $rows;
    }

    public function bookFlight(Request $request, $flightDetail, $bookingDetail)
    {
        try {

            // dd($bookingDetail->api_id);
            $api_ids = json_decode($bookingDetail->api_id, true);
            if (is_array($api_ids) && !empty($api_ids)) {
                foreach ($api_ids as $index => $id) {
                    // dd($bookingDetail);
                    $total = json_decode($bookingDetail->each_flight_price, true);
                    
                    $params = $this->multiBookparams($request, $flightDetail, $bookingDetail, $id, $total[$index]);
                    $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('air/book', 'oms'), $params);
                    $bookingData = $response->json();
                    if ($response->successful()) {

                    } else {
                        $this->generateEmailLog('flight-book', $this->apiType, $response->status(), $response->body());
                        return [
                            'status' => false,
                            'msg' => $bookingData['errors'][0]['message'] ?? 'Something went wrong in booking flight'
                        ];
                    }
                }
                if ($bookingData['status']['httpStatus'] == 200) {
                    return [
                        'status' => true,
                        'msg' => 'Booking made successfully!'
                    ];
                }
            } else {
                $id = null;
                $params = $this->setBookParams($request, $flightDetail, $bookingDetail);
                $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('air/book', 'oms'), $params);
                $bookingData = $response->json();
                if ($response->successful()) {
                    if ($bookingData['status']['httpStatus'] == 200) {
                        return [
                            'status' => true,
                            'msg' => 'Booking made successfully!'
                        ];
                    }
                } else {
                    $this->generateEmailLog('flight-book', $this->apiType, $response->status(), $response->body());
                    return [
                        'status' => false,
                        'msg' => $bookingData['errors'][0]['message'] ?? 'Something went wrong in booking flight'
                    ];
                }
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('flight-book', $this->apiType, $e->getCode(), $e->getMessage());
            return [
                'status' => false,
                'msg' => 'Something went wrong with flight book API.'
            ];
        }
    }


    private function setBookParams($request, $flightDetail, $bookingDetail)
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
                    'pan' => $adult['pan'],
                    'pNum' => $adult['passport'],
                    "dob" => Carbon::now()->subYears($adult['dob'])->format('Y-m-d'),
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
                    'pan' => $child['pan'],
                    'pNum' => $child['passport'],
                    "dob" => Carbon::now()->subYears($child['dob']),
                    'ti' => 'Master',
                    "pNat" => "IN",
                    'pt' => 'CHILD',
                    "eD" => $child['eD'] ?? $user['passport_expiry_date'],
                    'pid' => $child['pid'] ?? "2005-08-09"
                ];
            }
        }

        // Process infants data if available
        if (!empty($infants)) {
            foreach ($infants as $infant) {
                $travellerInfo[] = [
                    'fN' => $infant['first_name'],
                    'lN' => $infant['last_name'],
                    "dob" => Carbon::now()->subYears($infant['dob']),
                    'ti' => 'Master',
                    "pNat" => "IN",
                    'pt' => 'INFANT'
                ];
            }
        }

        // Further processing of $travellerInfo if needed


        $response = [
            'bookingId' => $bookingDetail->api_id,
            'paymentInfos' => [
                    [
                        'amount' => $bookingDetail->total,
                    ]
                ],
            'travellerInfo' => $travellerInfo,
            'deliveryInfo' => [
                'emails' => [$user['email']],
                'contacts' => [$user['phone']],
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



    private function multiBookparams($request, $flightDetail, $bookingDetail, $id, $total)
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
                    'pan' => $adult['pan'],
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
                    'pan' => $child['pan'],
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

        // Process infants data if available
        if (!empty($infants)) {
            foreach ($infants as $infant) {
                $travellerInfo[] = [
                    'fN' => $infant['first_name'],
                    'lN' => $infant['last_name'],
                    "dob" => $infant['dob'],
                    'ti' => 'Master',
                    "pNat" => "IN",
                    'pt' => 'INFANT'
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
            'travellerInfo' => $travellerInfo,
            'deliveryInfo' => [
                'emails' => [$user['email']],
                'contacts' => [$user['phone']],
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

    public function bookingDetail($id)
    {
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->post($this->getEndpoint('booking-details', 'oms'), ['bookingId' => $id]);
            if ($response->successful()) {
                return $response->json();
            } else {
                // Log error and return empty array
                $this->generateEmailLog('booking-detail', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('booking-detail', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }

    public static function getDetailUrl($hotelId, $include_param = true)
    {
        return "#";
        $param = [];
        $urlDetail = app_get_locale(false, false, '/') . config('flight.flight_route_prefix') . "/" . $this->id;
        if (!empty($param)) {
            $urlDetail .= "?" . http_build_query($param);
        }
        return url($urlDetail);
    }

    public function getFlightDetailFromCache($flightId)
    {
        // Get the cached flights, return null if no cache is found
        $cachedFlights = Cache::get('flights', []);

        // Iterate over cached flights to find the one with the matching flight ID
        foreach ($cachedFlights as $flight) {
            if ($flight['sI'][0]['id'] == $flightId) {
                return $flight;
            }
        }

        // Return null if no matching flight is found
        return null;
    }

    public function getMultiFlightDetailFromCache(){
        $cachedFlights = Cache::get('flights', []);
        return $cachedFlights;
    }


    private function clearFlightCache()
    {
        if (Cache::has('flights*')) {
            $keys = Cache::getKeysMatching('flights*');
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
            'id' => $row['id'],
            'person_types' => [],
            'max' => 0,
            'open_hours' => [],
            'extra_price' => [],
            'minDate' => date('m/d/Y'),
            'max_guests' => $this->max_guests ?? 1,
            'buyer_fees' => [],
            'i18n' => [
                    'date_required' => __("Please select check-in and check-out date"),
                    "rooms" => __('rooms'),
                    "room" => __('room'),
                ],
            'start_date' => request()->input('start') ?? "",
            'start_date_html' => $date_html ?? __('Please select'),
            'end_date' => request()->input('end') ?? "",
            'deposit' => $this->isDepositEnable(),
            'deposit_type' => $this->getDepositType(),
            'deposit_amount' => $this->getDepositAmount(),
            'deposit_fomular' => $this->getDepositFomular(),
            'is_form_enquiry_and_book' => $this->isFormEnquiryAndBook(),
            'enquiry_type' => $this->getBookingEnquiryType(),
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
        $list_fees = setting_item_array('flight_booking_buyer_fees');
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
        if (!empty($this->enable_service_fee) and !empty($service_fee = $this->service_fee)) {
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
        
        $total_guests = 0;
        $total = 0;

        $discount = 0;
        if (!empty($request->flight['flight_seat'])) {
            foreach ($request->flight['flight_seat'] as $flight_seat) {
                $total_guests += $flight_seat['number'] ?? 0;
                $total += $flight_seat['number'] * $flight_seat['price'];
            }
        }

        $total_before_fees = $total;
        // $total_buyer_fee = 0;
        // if (!empty($list_buyer_fees = setting_item('flight_booking_buyer_fees'))) {
        //     $list_fees = json_decode($list_buyer_fees, true);
        //     $total_buyer_fee = $this->calculateServiceFees($list_fees , $total_before_fees , $total_guests);
        //     $total += $total_buyer_fee;
        // }

        $booking = new Booking;
        $booking->status = 'draft';
        $booking->travel_type = 'One Way';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->adults = $request->input('adults');
        $booking->children = $request->input('children');
        $booking->infants = $request->input('infants');
        $total = $request->input('total_price');
        $booking->vendor_id = 0;
        $booking->customer_id = Auth::id();
        $booking->total = $total;
        $booking->flightData = json_encode($request->flight);

        $booking->api_id = $request->flight['booking_id'];
        $booking->is_gst = $request->flight['is_gst'];
        $booking->title = $request->flight['title'];
        $booking->total_guests = $total_guests;

// Combine departure date and time
$departureDate = Carbon::parse($request->flight['departure_date_html']); 
$departureTime = Carbon::parse($request->flight['departure_time_html']);
$departureDateTime = $departureDate->setTimeFromTimeString($departureTime->format('H:i:s')); 

// Store the full departure datetime in the booking
$booking->start_date = $departureDateTime;

// Combine arrival date and time
$arrivalDate = Carbon::parse($request->flight['arrival_date_html']); 
$arrivalTime = Carbon::parse($request->flight['arrival_time_html']);
$arrivalDateTime = $arrivalDate->setTimeFromTimeString($arrivalTime->format('H:i:s'));

// Store the full arrival datetime in the booking
$booking->end_date = $arrivalDateTime;

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        $check = $booking->save();

        if (!empty($request->flight['arrival_time_html']) and !empty($request->flight['departure_time_html'])) {
            $departureTime = Carbon::parse($request->flight['departure_time_html']);
            $arrivalTime = Carbon::parse($request->flight['arrival_time_html']);
            $interval = $arrivalTime->diff($departureTime);
            $interval = $interval->format('%h');
        }

        if ($check) {
            Booking::clearDraftBookings();
            $booking->addMeta('duration', $booking->duration_nights);
            $booking->addMeta('base_price', $total);
            $booking->addMeta('sale_price', $total);
            $booking->addMeta('guests', $total_guests);
            $booking->addMeta('flight_seat', $request->flight['flight_seat']);
            // Add Room Booking
            if (!empty($request->flight['flight_seat'])) {
                $flight_seats = $request->flight['flight_seat'];
                foreach ($flight_seats as $flight_seat) {
                    for ($i = 1; $i <= $flight_seat['number']; $i++) {
                        $bookingPassengers = new BookingPassengers();
                        $bookingPassengers->fillByAttr([
                            'flight_id',
                            'flight_seat_id',
                            'booking_id',
                            'seat_type',
                            'person',
                            'baggage_check_in',
                            'baggage_cabin',
                            'max_passengers',
                            'email',
                            'first_name',
                            'last_name',
                            'phone',
                            'dob',
                            'price',
                            'id_card'
                        ], [
                            'flight_id' => $request->service_id,
                            'flight_seat_id' => 0,
                            'booking_id' => $booking->id,
                            'seat_type' => $flight_seat['seat_type'],
                            'person' => $flight_seat['person'],
                            'baggage_check_in' => $flight_seat['baggage_check_in'],
                            'baggage_cabin' => $flight_seat['baggage_cabin'],
                            'max_passengers' => $flight_seat['max_passengers'],
                            'email' => $booking->email,
                            'first_name' => $booking->first_name,
                            'last_name' => $booking->last_name,
                            'phone' => $booking->phone,
                            'dob' => '',
                            'price' => $flight_seat['price'] ?? 0,
                            'id_card' => ''
                        ]);
                        $bookingPassengers->save();
                    }

                }
            }

            return [
                'url' => $booking->getCheckoutUrl(),
                'booking_code' => $booking->code,
            ];
        }
    }

    public function MultiAddToCart(Request $request)
    {
        $total_guests = 0;
        $total = 0;
        $discount = 0;

        $booking = new Booking;
        $booking->status = 'draft';
        $booking->travel_type = 'Multicity';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = 0;
        $booking->customer_id = Auth::id();
        // dd($request->input());
        $booking->each_flight_price = $request->input('Each_Flight_Price');
        $booking->adults = $request->input('adults');
        $booking->children = $request->input('children');
        $booking->infants = $request->input('infants');
        $total = $request->input('total_price');
        $total_before_fees = $total;
        $booking->total = $total;
        $booking->flightData = json_encode($request->flight);
        
        $this->clearFlightCache();
        Cache::put('flights', $request->flight);

        $api_ids = [];
        $is_gsts = [];
        $titles = [];
        $return_end_dates = [];
        $flight_seats = [];
        $start_date = null;
$end_date = null;

        // Loop through the flights and populate the arrays
        foreach ($request->flight as $index => $flight) {


            $api_ids[] = $flight['booking_id'];
            $is_gsts[] = $flight['is_gst'];
            $titles[] = $flight['title'];
            
    // Parse departure date and time
    $departureDate = Carbon::parse($flight['departure_date_html']); 
    $departureTime = Carbon::parse($flight['departure_time_html']);
    $departureDateTime = $departureDate->setTimeFromTimeString($departureTime->format('H:i:s')); 

    // Parse arrival date and time
    $arrivalDate = Carbon::parse($flight['arrival_date_html']); 
    $arrivalTime = Carbon::parse($flight['arrival_time_html']);
    $arrivalDateTime = $arrivalDate->setTimeFromTimeString($arrivalTime->format('H:i:s'));

    // Determine the earliest start date and latest end date
    if ($start_date === null || $departureDateTime < $start_date) {
        $start_date = $departureDateTime;
    }

    if ($end_date === null || $arrivalDateTime > $end_date) {
        $end_date = $arrivalDateTime;
    }


            if (isset($flight['id'])) {
                $return_ids[] = $flight['id'];
            }

            if (!empty($flight['flight_seat'])) {
                $flight_seats = array_merge($flight_seats, $flight['flight_seat']);
            }
        }

        // Store arrays in booking columns
        $booking->api_id = json_encode($api_ids);
        $booking->is_gst = json_encode($is_gsts);
        $booking->title = json_encode($titles);
        $booking->start_date = $start_date;
        $booking->end_date = $end_date;

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        $check = $booking->save();

        if ($check) {
            Booking::clearDraftBookings();
            $booking->addMeta('duration', $booking->duration_nights);
            $booking->addMeta('base_price', $total);
            $booking->addMeta('sale_price', $total);
            $booking->addMeta('guests', $total_guests);
            $booking->addMeta('flight_seat', json_encode($flight_seats));

            return [
                'url' => $booking->getCheckoutUrl(),
                'booking_code' => $booking->code,
            ];
        }
    }
    public function returnAddToCart(Request $request)
    {
        // Add Booking
        $total_guests = 0;
        $total = 0;

        $discount = 0;
        foreach ($request->flight as $flight) {
            if (!empty($flight['flight_seat'])) {
                foreach ($flight['flight_seat'] as $flight_seat) {
                    $total_guests += $flight_seat['number'] ?? 0;
                    $total += $flight_seat['number'] * $flight_seat['price'];
                }
            }
        }



        $booking = new Booking;
        $booking->status = 'draft';
        $booking->travel_type = 'Round Trip';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = 0;
        $booking->customer_id = Auth::id();
        // dd($request->input());
        $booking->adults = $request->input('adults');
        $booking->children = $request->input('children');
        $booking->infants = $request->input('infants');
        $booking->flightData = json_encode($request->flight);
        $total = $request->input('total_price');
        $total_before_fees = $total;
        $booking->total = $total;
        $booking->api_id = $request->flight[0]['booking_id'];
        $booking->is_gst = $request->flight[0]['is_gst'];
        $booking->title = $request->flight[0]['title'] . ' - ' . $request->flight[1]['title'];
        $booking->total_guests = $total_guests;
       $departureDate = Carbon::parse($request->flight[0]['departure_date_html']); 
$departureTime = Carbon::parse($request->flight[0]['departure_time_html']);
$departureDateTime = $departureDate->setTimeFromTimeString($departureTime->format('H:i:s')); 

// Store the full departure datetime in the booking
$booking->start_date = $departureDateTime;

// Combine arrival date and time
$arrivalDate = Carbon::parse($request->flight[0]['arrival_date_html']); 
$arrivalTime = Carbon::parse($request->flight[0]['arrival_time_html']);
$arrivalDateTime = $arrivalDate->setTimeFromTimeString($arrivalTime->format('H:i:s'));

// Store the full arrival datetime in the booking
$booking->end_date = $arrivalDateTime;

        $booking->return_id = $request->flight[1]['id'];

        $departureDate = Carbon::parse($request->flight[1]['departure_date_html']); 
$departureTime = Carbon::parse($request->flight[1]['departure_time_html']);
$departureDateTime = $departureDate->setTimeFromTimeString($departureTime->format('H:i:s')); 

// Store the full departure datetime in the booking
$booking->return_start_date = $departureDateTime;

// Combine arrival date and time
$arrivalDate = Carbon::parse($request->flight[1]['arrival_date_html']); 
$arrivalTime = Carbon::parse($request->flight[1]['arrival_time_html']);
$arrivalDateTime = $arrivalDate->setTimeFromTimeString($arrivalTime->format('H:i:s'));

// Store the full arrival datetime in the booking
$booking->return_end_date = $arrivalDateTime;
        // $booking->return_start_date = Carbon::parse($request->flight[1]['departure_date_html'])->format('Y-m-d H:i');
        // $booking->return_end_date = Carbon::parse($request->flight[1]['arrival_date_html'])->format('Y-m-d H:i');

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        $check = $booking->save();

        if (!empty($request->flight[0]['arrival_time_html']) and !empty($request->flight[0]['departure_time_html'])) {
            $departureTime = Carbon::parse($request->flight[0]['departure_time_html']);
            $arrivalTime = Carbon::parse($request->flight[0]['arrival_time_html']);
            $interval = $arrivalTime->diff($departureTime);
            $interval = $interval->format('%h');
        }

        if ($check) {
            Booking::clearDraftBookings();
            $booking->addMeta('duration', $booking->duration_nights);
            $booking->addMeta('base_price', $total);
            $booking->addMeta('sale_price', $total);
            $booking->addMeta('guests', $total_guests);
            $booking->addMeta('flight_seat', array_merge($request->flight[0]['flight_seat'], $request->flight[1]['flight_seat']));
            foreach ($request->flight as $flight) {
                if (!empty($flight['flight_seat'])) {
                    $flight_seats = $flight['flight_seat'];
                    foreach ($flight_seats as $flight_seat) {
                        for ($i = 1; $i <= $flight_seat['number']; $i++) {
                            $bookingPassengers = new BookingPassengers();
                            $bookingPassengers->fillByAttr([
                                'flight_id',
                                'flight_seat_id',
                                'booking_id',
                                'seat_type',
                                'person',
                                'baggage_check_in',
                                'baggage_cabin',
                                'max_passengers',
                                'email',
                                'first_name',
                                'last_name',
                                'phone',
                                'dob',
                                'price',
                                'id_card'
                            ], [
                                'flight_id' => $request->service_id,
                                'flight_seat_id' => 0,
                                'booking_id' => $booking->id,
                                'seat_type' => $flight_seat['seat_type'],
                                'person' => $flight_seat['person'],
                                'baggage_check_in' => $flight_seat['baggage_check_in'],
                                'baggage_cabin' => $flight_seat['baggage_cabin'],
                                'max_passengers' => $flight_seat['max_passengers'],
                                'email' => $booking->email,
                                'first_name' => $booking->first_name,
                                'last_name' => $booking->last_name,
                                'phone' => $booking->phone,
                                'dob' => '',
                                'price' => $flight_seat['price'] ?? 0,
                                'id_card' => ''
                            ]);
                            $bookingPassengers->save();
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

    public static function getAirLineLogo($code, $isLogo = false)
    {
        if ($isLogo === true) {
            $airline = Airline::with('logo')->where('code', $code)->first();
            return $airline->logo->file_path ?? '';
        } else {
            return Airline::with('logo')->where('code', $code)->first();
        }
    }

    public function pairFlights($onwardFlights, $returnFlights)
    {
        $pairedFlights = [];

        foreach ($onwardFlights as $onward) {
            foreach ($returnFlights as $return) {
                // Here, you might want to add additional logic to ensure the return flight is after the onward flight
                if (strtotime($onward['sI'][0]['at']) < strtotime($return['sI'][0]['dt'])) {
                    $pairedFlights[] = [
                        'onward' => $onward,
                        'return' => $return
                    ];
                }
            }
        }
        return $pairedFlights;
    }

    public function pairComboFlights($combo)
    {
        $parsedCombos = [];


        foreach ($combo as $trip) {
            usort($trip['sI'], function ($a, $b) {
                return strtotime($a['dt']) - strtotime($b['dt']);
            });
            $parsedCombos[] = [
                'onward' => [
                    'sI' => [$trip['sI'][0]],
                    'totalPriceList' => [$trip['totalPriceList'][0]],
                ],
                'return' => [
                    'sI' => [$trip['sI'][1]],
                ],
            ];

            if (isset($trip['totalPriceList'][1])) {
                $parsedCombos[count($parsedCombos) - 1]['return']['totalPriceList'] = [$trip['totalPriceList'][1]];
            }
        }

        return $parsedCombos;
    }

    public static function isEnableEnquiry()
    {
        if (!empty(setting_item('booking_enquiry_for_hotel'))) {
            return true;
        }
        return false;
    }

    public static function isFormEnquiryAndBook()
    {
        $check = setting_item('booking_enquiry_for_hotel');
        if (!empty($check) and setting_item('booking_enquiry_type_hotel') == "booking_and_enquiry") {
            return true;
        }
        return false;
    }

    public static function getBookingEnquiryType()
    {
        $check = setting_item('booking_enquiry_for_hotel');
        if (!empty($check)) {
            if (setting_item('booking_enquiry_type_hotel') == "only_enquiry") {
                return "enquiry";
            }
        }
        return "book";
    }

    public static function isEnable()
    {
        return setting_item('flight_disable') == false;
    }

    public function isDepositEnable()
    {
        return (setting_item('flight_deposit_enable') and setting_item('flight_deposit_amount'));
    }

    public function getDepositAmount()
    {
        return setting_item('flight_deposit_amount');
    }

    public function getDepositType()
    {
        return setting_item('flight_deposit_type');
    }

    public function getDepositFomular()
    {
        return setting_item('flight_deposit_fomular', 'default');
    }
}