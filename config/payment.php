<?php
return [
    'gateways'=>[
        'offline_payment'=>Modules\Booking\Gateways\OfflinePaymentGateway::class,
        'paypal'=>Modules\Booking\Gateways\PaypalGateway::class,
        'stripe'=>Modules\Booking\Gateways\StripeGateway::class,
        'razor_pay'=>Modules\Booking\Gateways\RazorPayGateway::class,
        'ease_buzz'=>Modules\Booking\Gateways\EaseBuzzGateway::class,
        'payrexx'=>Modules\Booking\Gateways\PayrexxGateway::class,
        'paystack'=>Modules\Booking\Gateways\PaystackGateway::class,
    ],
];
