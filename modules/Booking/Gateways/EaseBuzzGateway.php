<?php

namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Illuminate\Support\Facades\Log;

class EaseBuzzGateway extends EaseBuzzCheckout
{
    protected $id = 'easebuzz';

    public $name = 'Easebuzz Gateway';

    protected $base_url = 'https://testpay.easebuzz.in';

    protected $gateway;
}