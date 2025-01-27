<?php

namespace Modules\Booking\Controllers;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Hotel\Services\HotelService;
use Modules\Flight\Services\FlightService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Events\EnquirySendEvent;
use Modules\Booking\Events\SetPaidAmountEvent;
use Modules\Booking\Models\BookingPassenger;
use Modules\User\Events\SendMailUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Models\Booking;
use Modules\Hotel\Models\HotelRoomBooking;
use Modules\Flight\Models\BookingPassengers;
use Modules\Booking\Models\Enquiry;
use App\Helpers\ReCaptchaEngine;

class BookingController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests;

    protected $booking;
    protected $enquiryClass;
    protected $bookingInst;

    public function __construct(Booking $booking, Enquiry $enquiryClass, protected HotelService $hotelService, protected FlightService $flightService)
    {
        $this->booking = $booking;
        $this->enquiryClass = $enquiryClass;
    }

    protected function validateCheckout($code)
    {

        if (!is_enable_guest_checkout() and !Auth::check()) {
            $error = __("You have to login in to do this");
            if (\request()->isJson()) {
                return $this->sendError($error)->setStatusCode(401);
            }
            return redirect(route('login', ['redirect' => \request()->fullUrl()]))->with('error', $error);
        }

        $booking = $this->booking::where('code', $code)->first();

        $this->bookingInst = $booking;

        if (empty($booking)) {
            abort(404);
        }
        if (!is_enable_guest_checkout() and $booking->customer_id != Auth::id()) {
            abort(404);
        }
        return true;
    }

    public function checkout($code)
    {
        $res = $this->validateCheckout($code);
        if ($res !== true) return $res;

        $booking = $this->bookingInst;

        if (!in_array($booking->status, ['draft', 'unpaid'])) {
            return redirect('/');
        }

        $is_api = request()->segment(1) == 'api';
        
        if($booking->object_model == 'hotel'){
            $checkout_form_file=null;
            $checkout_booking_detail_file=HotelService::$checkout_booking_detail_file;
            $service = $this->hotelService->getHotelDetailFromCache($booking->api_id);
        } else if($booking->object_model == 'flight'){
            $checkout_form_file=null;
            if($booking->travel_type == 'Round Trip'){
                $checkout_booking_detail_file=FlightService::$checkout_return_booking_detail_file;
                $service[] = $this->flightService->getFlightDetailFromCache($booking->object_id);
                $service[] = $this->flightService->getFlightDetailFromCache($booking->return_id);
            }
            elseif($booking->travel_type == 'Multicity'){
                $checkout_booking_detail_file=FlightService::$checkout_multi_booking_detail_file;
                $service[] = $this->flightService->getMultiFlightDetailFromCache();
            }
            else{
                $checkout_booking_detail_file=FlightService::$checkout_booking_detail_file;
                $service = $this->flightService->getFlightDetailFromCache($booking->object_id);
            }
        }else{
            $checkout_form_file= $service->checkout_form_file;
            $checkout_booking_detail_file= $service->checkout_booking_detail_file;
            $service = $booking->service;
        }
        $data = [
            'page_title' => __('Checkout'),
            'booking'    => $booking,   
            'checkout_form_file' => $checkout_form_file ,
            'checkout_booking_detail_file' => $checkout_booking_detail_file,
            'service' => $service,
            'gateways' => get_available_gateways(),
            'user'       => auth()->user(),
            'is_api'     => $is_api
        ];
        return view('Booking::frontend/checkout', $data);
    }

    public function checkStatusCheckout($code)
    {
        $booking = $this->booking::where('code', $code)->first();
        $data = [
            'error'    => false,
            'message'  => '',
            'redirect' => ''
        ];
        if (empty($booking)) {
            $data = [
                'error'    => true,
                'redirect' => url('/')
            ];
        }
        if (!is_enable_guest_checkout() and $booking->customer_id != Auth::id()) {
            $data = [
                'error'    => true,
                'redirect' => url('/')
            ];
        }
        if (!in_array($booking->status, ['draft', 'unpaid'])) {
            $data = [
                'error'    => true,
                'redirect' => url('/')
            ];
        }
        return response()->json($data, 200);
    }

    protected function validateDoCheckout()
    {

        $request = \request();
        if (!is_enable_guest_checkout() and !Auth::check()) {
            return $this->sendError(__("You have to login in to do this"))->setStatusCode(401);
        }

        if (auth()->user() && !auth()->user()->hasVerifiedEmail() && setting_item('enable_verify_email_register_user') == 1) {
            return $this->sendError(__("You have to verify email first"), ['url' => url('/email/verify')]);
        }
        /**
         * @param Booking $booking
         */
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }
        $code = $request->input('code');

        $booking = $this->booking::where('code', $code)->first();
        $this->bookingInst = $booking;

        if (empty($booking)) {
            abort(404);
        }
        if (!is_enable_guest_checkout() and $booking->customer_id != Auth::id()) {
            abort(404);
        }
        return true;
    }

    public function doCheckout(Request $request)
    {
        /**
         * @var $booking Booking
         * @var $user User
         */
        
        $res = $this->validateDoCheckout();
        if ($res !== true) return $res;
        $user = auth()->user();

        $booking = $this->bookingInst;

        if (!in_array($booking->status, ['draft', 'unpaid'])) {
            return $this->sendError('', [
                'url' => $booking->getDetailUrl()
            ]);
        }

        if($request->type == 'hotel' || $request->type == 'flight'){
            $service = $request->type;
        }else{
            $service = $booking->service;
        }
        if (empty($service)) {
            return $this->sendError(__("Service not found"));
        }
        $is_api = request()->segment(1) == 'api';

        /**
         * Google ReCapcha
         */
        if (!$is_api and ReCaptchaEngine::isEnable() and setting_item("booking_enable_recaptcha")) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                return $this->sendError(__("Please verify the captcha"));
            }
        }

        $messages = [];
        $rules = [
            'email'           => 'string|email|max:255',
            'phone'           => 'string|max:255',
            'country'         => 'required',
            'term_conditions' => 'required',
        ];

        $confirmRegister = $request->input('confirmRegister');
        if (!empty($confirmRegister)) {
            $rules['password'] = 'required|string|confirmed|min:6|max:255';
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')];
            $messages['password.confirmed'] = __('The password confirmation does not match');
            $messages['password.min'] = __('The password must be at least 6 characters');
        }

        $how_to_pay = $request->input('how_to_pay', '');
        $credit = $request->input('credit', 0);
        $payment_gateway = $request->input('payment_gateway');

        // require payment gateway except pay full
        if (empty(floatval($booking->deposit)) || $how_to_pay == 'deposit' || !auth()->check()) {
            $rules['payment_gateway'] = 'required';
        }

        if (auth()->check()) {
            if ($credit > $user->balance) {
                return $this->sendError(__("Your credit balance is :amount", ['amount' => $user->balance]));
            }
        } else {
            // force credit to 0 if not login
            $credit = 0;
        }

        if($service != 'hotel' && $service != 'flight'){
            $rules = $service->filterCheckoutValidate($request, $rules);
            if (!empty($rules)) {
    
                $messages['term_conditions.required'] = __('Term conditions is required field');
                $messages['payment_gateway.required'] = __('Payment gateway is required field');
    
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return $this->sendError('', ['errors' => $validator->errors()]);
                }
            }
        }else{
            $messages['term_conditions.required'] = __('Term conditions is required field');
            $messages['payment_gateway.required'] = __('Payment gateway is required field');

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->sendError('', ['errors' => $validator->errors()]);
            }
        }
        $isBooked=false;
        if($service == 'hotel'){
            $rooms = HotelRoomBooking::where('booking_id',$booking->id)->get();
            foreach($rooms as $room){
                $isBooked = $this->hotelService->bookRoom($request, $room, $booking);
                $updateRoom = HotelRoomBooking::find($room->id);
                if($isBooked['status'] == true){
                    $updateRoom->api_booking_id = $this->hotelService->getRoomDetailFromCache($room->api_room_id)['bookingId'];
                    $updateRoom->save();
                    // if($isBooked['order']['status'] == 'SUCCESS'){
                    // }else{
                    //     return $this->sendError(__($updateRoom->title.' is '.$isBooked['order']['status'].' for now.'));
                    // }
                }else{
                    return $this->sendError(__($updateRoom->title.'. '.$isBooked['msg']));
                }
            }
            $isBooked = true;
        }
        // dd("from modules");
        if($service == 'flight'){
            $passengers = BookingPassengers::where('booking_id',$booking->id)->get();
            // foreach($passengers as $passenger){
                
            $isBooked = $this->flightService->bookFlight($request, $passengers, $booking);
            
            if($isBooked['status'] == true){
                // if($isBooked['order']['status'] == 'SUCCESS'){
                    // }else{
                        //     return $this->sendError(__($updateRoom->title.' is '.$isBooked['order']['status'].' for now.'));
                        // }
                    }else{
                        return $this->sendError(__($isBooked['msg']));
                    }
                    // dd ($request->input());
            // }
            $isBooked = true;
        }
        
        
        if($isBooked){
            $wallet_total_used = credit_to_money($credit);
            if ($wallet_total_used > $booking->total) {
                $credit = money_to_credit($booking->total, true);
                $wallet_total_used = $booking->total;
            }
            if($service != 'hotel' && $service != 'flight'){
                if ($res = $service->beforeCheckout($request, $booking)) {
                    return $res;
                }
            }
            if ($how_to_pay == 'full' and !empty($booking->deposit)) {
                $booking->addMeta('old_deposit', $booking->deposit ?? 0);
            }
            $oldDeposit = $booking->getMeta('old_deposit', 0);
            if (empty(floatval($booking->deposit)) and !empty(floatval($oldDeposit))) {
                $booking->deposit = $oldDeposit;
            }
    
            // Normal Checkout
            
            $adults = $request->input('adults');
            $children = $request->input('children');
            $infants = $request->input('infants');
// return ($request->input);

            $booking->first_name = $adults[0]['first_name'];
            $booking->last_name = $adults[0]['last_name'];
            $booking->Traveller_Details = json_encode([
                'adults' => $adults,   // Include adults with proper keys
                'children' => $children,
                'infants' => $infants
            ]);
            $booking->email = $request->input('email');
            $booking->phone = $request->input('phone');
            $booking->address = $request->input('address_line_1');
            $booking->address2 = $request->input('address_line_2');
            $booking->city = $request->input('city');
            $booking->state = $request->input('state');
            $booking->zip_code = $request->input('zip_code');
            $booking->country = $request->input('country');
            $booking->customer_notes = $request->input('customer_notes');
            $booking->gateway = $payment_gateway;
            $booking->wallet_credit_used = floatval($credit);
            $booking->wallet_total_used = floatval($wallet_total_used);
            $booking->pay_now = floatval((int)$booking->deposit == null ? $booking->total : (int)$booking->deposit);
    
            // If using credit
            if ($booking->wallet_total_used > 0) {
                $booking->pay_now = max(0, $booking->pay_now - $wallet_total_used);
                $booking->paid = $booking->wallet_total_used;
            } else {
                if ($how_to_pay == 'full') {
                    $booking->deposit = 0;
                    $booking->pay_now = $booking->total;
                }
            }
            
    
            $gateways = get_payment_gateways();
            if ($booking->pay_now > 0) {
                $gatewayObj = new $gateways[$payment_gateway]($payment_gateway);
                if (!empty($rules['payment_gateway'])) {
                    if (empty($gateways[$payment_gateway]) or !class_exists($gateways[$payment_gateway])) {
                        return $this->sendError(__("Payment gateway not found"));
                    }
                    if (!$gatewayObj->isAvailable()) {
                        return $this->sendError(__("Payment gateway is not available"));
                    }
                }
            }
    
            if ($booking->wallet_credit_used && auth()->check()) {
                try {
                    $transaction = $user->withdraw($booking->wallet_credit_used, [
                        'wallet_total_used' => $booking->wallet_total_used
                    ], $booking->id);
    
                } catch (\Exception $exception) {
                    return $this->sendError($exception->getMessage());
                }
                $booking->wallet_transaction_id = $transaction->id;
            }
            $booking->save();
    
    //        event(new VendorLogPayment($booking));
    
    
            $booking->addMeta('locale', app()->getLocale());
            $booking->addMeta('how_to_pay', $how_to_pay);


            $this->savePassengers($booking, $request);
    
            if($service != 'hotel' && $service != 'flight'){
    
                if ($res = $service->afterCheckout($request, $booking)) {
                    return $res;
                }
            }
    
            if ($booking->pay_now > 0) {
                try {
                    $gatewayObj->process($request, $booking, $service);
                } catch (Exception $exception) {
                    return $this->sendError($exception->getMessage());
                }
            } else {
                if ($booking->paid < $booking->total) {
                    $booking->status = $booking::PARTIAL_PAYMENT;
                } else {
                    $booking->status = $booking::PAID;
                }
    
                if (!empty($booking->coupon_amount) and $booking->coupon_amount > 0 and $booking->total == 0) {
                    $booking->status = $booking::PAID;
                }
    
                $booking->save();
                event(new BookingCreatedEvent($booking));
                return $this->sendSuccess([
                    'url' => $booking->getDetailUrl()
                ], __("You payment has been processed successfully"));
            }
            
        }else{
            return $this->sendError([
                    'url' => ''
                ], __("There is some issue in bookings. Please try again later."));
        }
    }

    protected function savePassengers(Booking $booking, Request $request)
    {
        if ($totalPassenger = $booking->calTotalPassenger()) {
            $booking->passengers()->delete();
            $input = $request->input('passengers', []);
            for ($i = 1; $i <= $totalPassenger; $i++) {
                $passenger = new BookingPassenger();
                $data = [
                    'booking_id' => $booking->id,
                    'first_name' => $input[$i]['first_name'] ?? '',
                    'last_name'  => $input[$i]['last_name'] ?? '',
                    'email'      => $input[$i]['email'] ?? '',
                    'phone'      => $input[$i]['phone'] ?? '',
                ];
                $passenger->fillByAttr(array_keys($data), $data);
                $passenger->save();
            }
        }
    }

    public function confirmPayment(Request $request, $gateway)
    {

        $gateways = get_payment_gateways();
        // dd($gateways);
        if (empty($gateways[$gateway]) or !class_exists($gateways[$gateway])) {
            return $this->sendError(__("Payment gateway not found"));
        }
        $gatewayObj = new $gateways[$gateway]($gateway);
        if (!$gatewayObj->isAvailable()) {
            return $this->sendError(__("Payment gateway is not available"));
        }
        return $gatewayObj->confirmPayment($request);
    }

    public function callbackPayment(Request $request, $gateway)
    {
        $gateways = get_payment_gateways();
        if (empty($gateways[$gateway]) or !class_exists($gateways[$gateway])) {
            return $this->sendError(__("Payment gateway not found"));
        }
        $gatewayObj = new $gateways[$gateway]($gateway);
        if (!$gatewayObj->isAvailable()) {
            return $this->sendError(__("Payment gateway is not available"));
        }
        if (!empty($request->input('is_normal'))) {
            return $gatewayObj->callbackNormalPayment();
        }
        return $gatewayObj->callbackPayment($request);
    }

    public function cancelPayment(Request $request, $gateway)
    {

        $gateways = get_payment_gateways();
        if (empty($gateways[$gateway]) or !class_exists($gateways[$gateway])) {
            return $this->sendError(__("Payment gateway not found"));
        }
        $gatewayObj = new $gateways[$gateway]($gateway);
        if (!$gatewayObj->isAvailable()) {
            return $this->sendError(__("Payment gateway is not available"));
        }
        return $gatewayObj->cancelPayment($request);
    }

    /**
     * @param Request $request
     * @return string json
     * @todo Handle Add To Cart Validate
     *
     */
    public function addToCart(Request $request)
    {
        if (!is_enable_guest_checkout() and !Auth::check()) {
            return $this->sendError(__("You have to login in to do this"))->setStatusCode(401);
        }
        if (auth()->user() && !auth()->user()->hasVerifiedEmail() && setting_item('enable_verify_email_register_user') == 1) {
            return $this->sendError(__("You have to verify email first"), ['url' => url('/email/verify')]);
        }
        $validator = Validator::make($request->all(), [
            'service_id'   => 'required|integer',
            'service_type' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }
        $service_type = $request->input('service_type');
        $service_id = $request->input('service_id');
        $allServices = get_bookable_services();
        if (empty($allServices[$service_type])) {
            return $this->sendError(__('Service type not found'));
        }
        $module = $allServices[$service_type];
        $service = $module::find($service_id);
        if (empty($service) or !is_subclass_of($service, '\\Modules\\Booking\\Models\\Bookable')) {
            return $this->sendError(__('Service not found'));
        }
        if (!$service->isBookable()) {
            return $this->sendError(__('Service is not bookable'));
        }

        if (\auth()->user() && Auth::id() == $service->author_id) {
            return $this->sendError(__('You cannot book your own service'));
        }

        return $service->addToCart($request);
    }

    public function detail(Request $request, $code)
    {
        if (!is_enable_guest_checkout() and !Auth::check()) {
            return $this->sendError(__("You have to login in to do this"))->setStatusCode(401);
        }

        $booking = $this->booking::where('code', $code)->first();
        if (empty($booking)) {
            abort(404);
        }

        if ($booking->status == 'draft') {
            return redirect($booking->getCheckoutUrl());
        }
        if (!is_enable_guest_checkout() and $booking->customer_id != Auth::id()) {
            abort(404);
        }

        $is_api = request()->segment(1) == 'api';
        
        if($booking->object_model == 'hotel'){
            $service = $this->hotelService->getHotelDetailFromCache($booking->api_id);
        }else if($booking->object_model == 'flight'){
            $checkout_form_file=null;
            if($booking->travel_type == 'Round Trip'){
                $service[] = $this->flightService->getFlightDetailFromCache($booking->object_id);
                $service[] = $this->flightService->getFlightDetailFromCache($booking->return_id);
            }
            elseif($booking->travel_type == 'Multicity'){
                $checkout_booking_detail_file=FlightService::$checkout_multi_booking_detail_file;
                $service[] = $this->flightService->getMultiFlightDetailFromCache();
            }else{
                $service = $this->flightService->getFlightDetailFromCache($booking->api_id);
            }
        }else{
            $service = $booking->service;
        }
        
        $data = [
            'page_title' => __('Booking Details'),
            'booking'    => $booking,
            'service'    => $service,
        ];
        if ($booking->gateway) {
            $data['gateway'] = get_payment_gateway_obj($booking->gateway);
        }
        return view('Booking::frontend/detail', $data);
    }

    public function exportIcal($type, $id = false)
    {
        if (empty($type) or empty($id)) {
            return $this->sendError(__('Service not found'));
        }

        $allServices = get_bookable_services();
        $allServices['room'] = 'Modules\Hotel\Models\HotelRoom';
        if (empty($allServices[$type])) {
            return $this->sendError(__('Service type not found'));
        }
        $module = $allServices[$type];

        $path = '/ical/';
        $fileName = 'booking_' . $type . '_' . $id . '.ics';
        $fullPath = $path . $fileName;

        $content = $this->booking::getContentCalendarIcal($type, $id, $module);
        Storage::disk('uploads')->put($fullPath, $content);
        $file = Storage::disk('uploads')->get($fullPath);

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');

        echo $file;
    }

    public function addEnquiry(Request $request)
    {
        $rules = [
            'service_id'    => 'required|integer',
            'service_type'  => 'required',
            'enquiry_name'  => 'required',
            'enquiry_note'  => 'required',
            'enquiry_email' => [
                'required',
                'email',
                'max:255',
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }
        
        if (setting_item('booking_enquiry_enable_recaptcha')) {
            $codeCapcha = trim($request->input('g-recaptcha-response'));
            if (empty($codeCapcha) or !ReCaptchaEngine::verify($codeCapcha)) {
                return $this->sendError(__("Please verify the captcha"));
            }
        }
        
        $service_type = $request->input('service_type');
        $service_id = $request->input('service_id');
        $allServices = get_bookable_services();
        if (empty($allServices[$service_type])) {
            return $this->sendError(__('Service type not found'));
        }
        $module = $allServices[$service_type];
        $service = $module::find($service_id);
        if (empty($service) or !is_subclass_of($service, '\\Modules\\Booking\\Models\\Bookable')) {
            return $this->sendError(__('Service not found'));
        }
        $row = new $this->enquiryClass();
        $row->fill([
            'name'  => $request->input('enquiry_name'),
            'email' => $request->input('enquiry_email'),
            'phone' => $request->input('enquiry_phone'),
            'note'  => $request->input('enquiry_note'),
        ]);
        $row->object_id = $request->input("service_id");
        $row->object_model = $request->input("service_type");
        $row->status = "pending";
        $row->vendor_id = $service->author_id;
        $row->save();
        event(new EnquirySendEvent($row));
        // dd($request);
        return $this->sendSuccess([
            'message' => __("Thank you for contacting us! We will be in contact shortly.")
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPaidAmount(Request $request)
    {
        $rules = [
            'remain' => 'required',
            'id'     => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }


        $id = $request->input('id');
        $remain = floatval($request->input('remain'));

        if ($remain < 0) {
            return $this->sendError(__('Remain can not smaller than 0'));
        }

        $booking = Booking::where('id', $id)->first();
        if (empty($booking)) {
            return $this->sendError(__('Booking not found'));
        }

        if (!Auth::user()->hasPermission('dashboard_vendor_access')) {
            if ($booking->vendor_id != Auth()->id()) {
                return $this->sendError(__("You don't have access."));
            }
        }
        
        $booking->pay_now = $remain;
        $booking->paid = floatval($booking->total) - $remain;
        event(new SetPaidAmountEvent($booking));
        if ($remain == 0 || $remain == 0.00) {
            $booking->status = $booking::PAID;
//            $booking->sendStatusUpdatedEmails();
            event(new BookingUpdatedEvent($booking));
        }

        $booking->save();

        return $this->sendSuccess([
            'message' => __("You booking has been changed successfully")
        ]);
    }

    public function modal(Booking $booking)
    {
        if (!is_admin() and $booking->vendor_id != auth()->id() and $booking->customer_id != auth()->id()) abort(404);
        
        if($booking->object_model == 'hotel'){
            $service = $this->hotelService->searchHotelDetail([['id' => $booking->api_id]], true)[0];
        }else if ($booking->object_model == 'flight'){
            dd("bookingDetails");
            $service = $this->flightService->bookingDetail($booking->api_id)['itemInfos']['AIR']['tripInfos'][0];
        }else{
            $service = $booking->service;
        }
        return view('Booking::frontend.detail.modal', ['booking' => $booking, 'service' => $service]);
    }
}