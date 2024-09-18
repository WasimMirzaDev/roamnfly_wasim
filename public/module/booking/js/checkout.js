(function ($) {
    new Vue({
        el: '#bravo-checkout-page',
        data: {
            onSubmit: false,
            message: {
                content: '',
                type: false
            },
            razorpayLoaded: false
        },
        methods: {
            loadRazorpayScript(callback) {
                if (!this.razorpayLoaded) {
                    let script = document.createElement('script');
                    script.src = "https://checkout.razorpay.com/v1/checkout.js";
                    script.onload = () => {
                        this.razorpayLoaded = true;
                        callback();
                    };
                    document.head.appendChild(script);
                } else {
                    callback();
                }
            },
            doCheckout() {
                var me = this;
    
                if (this.onSubmit) return false;
    
                // Uncomment the line below to enable validation logic
                // if (!this.validate()) return false;
    
                this.onSubmit = true;
                console.log('Request to be sent');
                
                $.ajax({
                    url: bookingCore.routes.checkout,
                    data: $('.booking-form').find('input,textarea,select').serialize(),
                    method: "post",
                    success: function (res) {
                        if (!res.status && !res.url) {
                            me.onSubmit = false;
                        }
                        console.log('Response :', res);
    
                        // Check if Razorpay order ID is received in the response
                        if (res.order_id && res.key) {
                            // Load Razorpay script and then proceed to payment
                            me.loadRazorpayScript(() => {
                                me.proceedToPayment(res.order_id, res.key, res.amount , res.booking_code , res.UserData);
                            });
                        }
    
                        if (res.elements) {
                            for (var k in res.elements) {
                                $(k).html(res.elements[k]);
                            }
                        }
    
                        if (res.message) {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }
    
                        if (res.url) {
                            window.location.href = res.url;
                        }
    
                        if (res.errors && typeof res.errors == 'object') {
                            var html = '';
                            for (var i in res.errors) {
                                html += res.errors[i] + '<br>';
                            }
                            me.message.content = html;
                        }
                        
                        if (typeof BravoReCaptcha != "undefined") {
                            BravoReCaptcha.reset('booking');
                        }
                    },
                    error: function (e) {
                        me.onSubmit = false;
                        if (e.responseJSON) {
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Cannot complete booking';
                            me.message.type = false;
                        } else {
                            if (e.responseText) {
                                me.message.content = e.responseText;
                                me.message.type = false;
                            }
                        }
                        if (typeof BravoReCaptcha != "undefined") {
                            BravoReCaptcha.reset('booking');
                        }
                    }
                });
            },
            proceedToPayment(orderId, key, amount,booking_code,UserData) {
                
                var me = this;
                var convertedAmount = amount * 100; // Convert amount to the smallest currency unit
                var options = {
                    "key": key, // Enter the Key ID generated from the Dashboard
                    "amount": convertedAmount, // Amount is in currency subunits (e.g., paisa for INR)
                    "currency": "INR",
                    "name": "Goflyhabibi",
                    "description": "Booking Payment",
                    "order_id": orderId,
                    "handler": function (response) {
                        console.log(response);
                        me.verifyPayment(response,booking_code);
                    },
                    "prefill": {
                        "name": UserData.name, // Customer name
                        "email": UserData.email, // Customer email
                        "contact": UserData.phone // Customer phone number
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };
    
                var rzp = new Razorpay(options);
                rzp.open();
            },
            verifyPayment(response, booking_code) {
                // Construct the URL with query parameters for verification
                const verificationUrl = `${bookingCore.url}/booking/confirm/razor_pay?c=${booking_code}&razorpay_payment_id=${response.razorpay_payment_id}&razorpay_order_id=${response.razorpay_order_id}&razorpay_signature=${response.razorpay_signature}`;
                
                // Redirect the user to the constructed URL to verify the payment
                window.location.href = verificationUrl;
            }
            
        }
    });
})(jQuery);
