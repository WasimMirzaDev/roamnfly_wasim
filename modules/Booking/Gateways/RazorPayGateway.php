<?php

namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Illuminate\Support\Facades\Log;

class RazorPayGateway extends RazorPayCheckout
{
    protected $id = 'razorpay';
    public $name = 'RazorPay Checkout';

    protected $gateway;
}