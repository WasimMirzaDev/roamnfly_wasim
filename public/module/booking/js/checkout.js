(function ($) {
    new Vue({
        el: '#bravo-checkout-page',
        data: {
            onSubmit: false,
            message: {
                content: '',
                type: false
            },
            razorpayLoaded: false,
            easebuzzLoaded: false
        },
        methods: {
            loadEasebuzzScript(callback) {
                if (!this.easebuzzLoaded) {
                    let script = document.createElement('script');
                    script.src = "https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/v2.0.0/easebuzz-checkout-v2.min.js"; // Corrected URL
                    script.onload = () => {
                        this.easebuzzLoaded = true;
                        callback();
                    };
                    document.head.appendChild(script);
                } else {
                    callback();
                }
            },
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
                // Serialized form data
                const serializedData = $('.booking-form').find('input,textarea,select').serialize();
                
                // Use URLSearchParams to parse the serialized string
                const params = new URLSearchParams(serializedData);
                
                // Access the 'payment_gateway' value
                const paymentGateway = params.get('payment_gateway');
                console.log("Payment Gateway:", paymentGateway);

            if(paymentGateway == "razor_pay"){
                    
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
                                me.proceedToPaymentRazerPay(res.order_id, res.key, res.amount , res.booking_code , res.UserData);
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
            }else{
                $.ajax({
                    url: bookingCore.routes.checkout,
                    data: $('.booking-form').find('input,textarea,select').serialize(),
                    method: "post",
                    success: function (res) {
                        // Check if response contains payment data
                        if (res.payment_data) {
                            me.loadEasebuzzScript(() => {
                                me.proceedToPaymentEasebuzz(res.payment_data); // Pass payment data to proceed with payment
                            });
                        } else {
                            me.onSubmit = false;
                        }
                    },
                    error: function (e) {
                        me.onSubmit = false;
                    }
                });
            }
            },
            proceedToPaymentEasebuzz(transactionData) {
                console.log(transactionData.response.data);
                const options = {
                    key:transactionData.key,
                    access_key: transactionData.response.data, // Easebuzz Key
                    onResponse: (response) => {
                        console.log(response);
                        this.verifyPaymentEasebuzz(response,transactionData.booking_code);
                    },
                    theme: "#123456", // color hex,
                };
                const easebuzz = new EasebuzzCheckout(options.key,'test'); // Use window.Easebuzz
                easebuzz.initiatePayment(options);
            
           

            // easebuzz.open();
            
            // Initialize Easebuzz payment gateway
            //   if (typeof Easebuzz !== 'undefined') {
            //     const easebuzz = new window.Easebuzz(options); // Use window.Easebuzz
            //     easebuzz.open();
            //   } else {
            //     // Handle the case where Easebuzz is not loaded
            //     console.error("Easebuzz library is not loaded!");
            //   }
        },
            proceedToPaymentRazerPay(orderId, key, amount,booking_code,UserData) {
                
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
            },
            verifyPaymentEasebuzz(response, booking_code) {
                // Construct the URL with query parameters for verification
                const verificationUrl = `${bookingCore.url}/booking/confirm/ease_buzz?c=${booking_code}&txnid=${response.txnid}&status=${response.status}&hash=${response.hash}&firstname=${response.firstname}&email=${response.email}`;
                
                // Redirect the user to the constructed URL to verify the payment
                window.location.href = verificationUrl;
            }
        }
    });
})(jQuery);
