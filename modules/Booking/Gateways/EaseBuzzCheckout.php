<?php

namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Exception;

class EaseBuzzCheckout extends BaseGateway
{
    protected $id = 'easebuzz';

    public $name = 'Easebuzz Gateway';

    protected $base_url = 'https://testpay.easebuzz.in'; // Use demo URL for testing, change for production.

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Easebuzz Gateway?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Easebuzz"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'input',
                'id'    => 'easebuzz_key',
                'label' => __('API Key'),
            ],
            [
                'type'  => 'input',
                'id'    => 'easebuzz_salt',
                'label' => __('Salt'),
            ],
        ];
    }

    public function process(Request $request, $booking, $service)
    {
        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::CANCELLED
        ])) {
            throw new Exception(__("Booking status does not need to be paid"));
        }
        if (!$booking->pay_now) {
            throw new Exception(__("Booking total is zero. Cannot process payment gateway!"));
        }

        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $payment->amount = (float) $booking->pay_now;

// Prepare the payment data
$payment_data = [
    'key'          => $this->getOption('easebuzz_key'),
    'txnid'        => $booking->code,
    'amount'       => (float)$booking->pay_now,
    'productinfo'  => 'Booking Payment',
    'firstname'    => $request->input('adults')[0]['first_name'],
    'email'        => $request->input('email'),
    'phone'        => $request->input('phone'),
    'surl'         => route('booking.checkout', ['code' => $booking->id]),
    'furl'         => route('booking.checkout', ['code' => $booking->id]),
];

// Calculate hash (this can vary based on the EaseBuzz documentation, but here's a common way)
$payment_data['hash'] = $this->generateHash($payment_data);
// Prepare the cURL request
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://testpay.easebuzz.in/payment/initiateLink",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => http_build_query($payment_data), // Use http_build_query to send the data as application/x-www-form-urlencoded
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Content-Type: application/x-www-form-urlencoded"
    ],
]);

// Execute the cURL request
$response = curl_exec($curl);
$err = curl_error($curl);

// Close the cURL session
curl_close($curl);

// Check if there were any errors
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // Handle the response here (you may want to log or process the response data)
    $payment_data['response'] =json_decode($response, true);
    // dd($response);
    // You can return or process the $response as needed
}


        // $payment_data['hash'] = $this->generateHash($payment_data);

        $payment->addMeta('easebuzz_order_data', $payment_data);
        $payment->save();

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->save();

        try {
            event(new BookingCreatedEvent($booking));
        } catch (\Swift_TransportException $e) {
            Log::warning($e->getMessage());
        }

        $payment_data['booking_code'] = $booking->code;

        return response()->json([
            'action_url' => $this->base_url . '/easecheckout',
            'payment_data' => $payment_data,
        ])->send();
    }

    private function generateHash($data)
    {
        $hash_sequence = implode('|', [
            $this->getOption('easebuzz_key'),
            $data['txnid'],
            $data['amount'],
            $data['productinfo'],
            $data['firstname'],
            $data['email'],
            '', '', '', '', '', '', '', '', '', '' // Placeholders for UDF fields
        ]) . '|' . $this->getOption('easebuzz_salt'); // Append the salt at the end
    
        return hash('sha512', $hash_sequence);
    }
    
    public function confirmPayment(Request $request)
    {
        $txnid = $request->query('c');
        $booking = Booking::where('code', $txnid)->first();
        
        if (!$booking) {
            // dd("booking error");
            return redirect($booking->getDetailUrl(false))->with('error', __("Booking not found."));
        }

        $status = $request->query('status');
        $easebuzz_hash = $request->query('hash');

        $calculated_hash = $this->generateHash([
            'key'       => $this->getOption('easebuzz_key'),
            'txnid'     => $request->query('txnid'),
            'amount'    => (float)$booking->pay_now,
            'productinfo' => 'Booking Payment',
            'firstname' => $request->query('firstname'),
            'email'     => $request->query('email'),
            'status'    => $status
        ]);

        // if ($calculated_hash !== $easebuzz_hash) {
        //     dd("hash error");
        //     return redirect($booking->getDetailUrl(false))->with('error', __("Payment failed"));
        // }

        if ($request->query('status') == 'success') {
            // dd("success error");
            $booking->paid += (float)$booking->pay_now;
            $booking->markAsPaid();
            // dd($request->query('status'));
            return redirect($booking->getDetailUrl(false))->with('success', __("Payment successful"));
        }
        // dd("simple error");
        return redirect($booking->getDetailUrl(false))->with('error', __("Booking not found or already paid"));
    }

    public function callbackPayment(Request $request)
    {
        // Add webhook handling here, if supported by Easebuzz.
        Log::info('Easebuzz Webhook received:', $request->all());
        return response()->json(['message' => 'Webhook processed'], 200);
    }

    public function getPublicKey()
    {
        return $this->getOption('easebuzz_key');
    }

    public function getSecretKey()
    {
        return $this->getOption('easebuzz_salt');
    }
}
