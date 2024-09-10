<?php

namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Razorpay\Api\Api;
use Exception;

class RazorPayCheckout extends BaseGateway
{
    protected $id = 'razorpay';

    public $name = 'Razorpay Gateway';

    protected $api;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Razorpay Gateway?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Razorpay"),
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
                'id'    => 'razorpay_key_id',
                'label' => __('Key ID'),
            ],
            [
                'type'  => 'input',
                'id'    => 'razorpay_key_secret',
                'label' => __('Key Secret'),
            ]
        ];
    }

    public function setupRazorpay()
    {
        $this->api = new Api($this->getOption('razorpay_key_id'), $this->getOption('razorpay_key_secret'));
    }

    public function process(Request $request, $booking, $service)
    {
        $this->setupRazorpay();

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

        $razorpayOrder = $this->api->order->create([
            'receipt'         => $booking->code,
            'amount'          => (float) $booking->pay_now * 100, // amount in the smallest currency unit
            'currency'        => setting_item('currency_main'),
            'payment_capture' => 1 // auto-capture
        ]);

        $payment->addMeta('razorpay_order_id', $razorpayOrder['id']);
        $payment->save();

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->save();

        try {
            event(new BookingCreatedEvent($booking));
        } catch (\Swift_TransportException $e) {
            Log::warning($e->getMessage());
        }

        $booking->addMeta('razorpay_order_id', $razorpayOrder['id']);

        return response()->json(['order_id' => $razorpayOrder['id'], 'key' => $this->getOption('razorpay_key_id')])->send();
    }

    public function confirmPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        $this->setupRazorpay();

        if (!empty($booking) && in_array($booking->status, [$booking::UNPAID])) {
            $payment_id = $request->input('razorpay_payment_id');
            $order_id = $booking->getMeta('razorpay_order_id');

            try {
                $payment = $this->api->payment->fetch($payment_id);

                if ($payment['status'] == 'captured') {
                    $booking->paid += (float)$booking->pay_now;
                    $booking->markAsPaid();
                    $booking->addMeta('razorpay_payment_id', $payment_id);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect($booking->getDetailUrl(false))->with('error', __("Payment failed"));
            }

            return redirect($booking->getDetailUrl(false))->with('success', __("Payment successful"));
        }

        return redirect($booking->getDetailUrl(false))->with('error', __("Booking not found or already paid"));
    }

    public function callbackPayment(Request $request)
    {
        // Handle Razorpay Webhook here
        $this->setupRazorpay();
        $payload = @file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'];

        try {
            $this->api->utility->verifyWebhookSignature($payload, $signature, $this->getOption('razorpay_webhook_secret'));
            $event = json_decode($payload);

            if ($event->event == 'payment.captured') {
                $payment = Payment::whereHas('meta', function ($query) use ($event) {
                    $query->where('razorpay_payment_id', $event->payload->payment->entity->id);
                })->first();

                if ($payment) {
                    $booking = $payment->booking;
                    if ($booking) {
                        $booking->paid += (float)$event->payload->payment->entity->amount / 100;
                        $booking->markAsPaid();
                        $payment->status = 'completed';
                        $payment->save();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => __('Webhook error while validating signature.')], 400);
        }

        return response()->json(['message' => __('Webhook processed successfully.')], 200);
    }

    public function getPublicKey()
    {
        return $this->getOption('razorpay_key_id');
    }

    public function getSecretKey()
    {
        return $this->getOption('razorpay_key_secret');
    }
}
