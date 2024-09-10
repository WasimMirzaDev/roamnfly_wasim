(function ($) {
    var isEmpty = function isEmpty(f) {
        return (/^function[^{]+\{\s*\}/m.test(f.toString())
        );
    }

    var flightFormBookModal = new Vue({
        el: '#flightFormBookModal',
        data: {
            id: '',
            buyer_fees: [],
            message: {
                content: '',
                type: false
            },
            adults: 0,
            children: 0,
            infants: 0,
            flights: {
                airline: {},
                airport_from: {},
                airport_to: {},
                flight_seat: []
            },
            flight: {
                airline: {},
                airport_from: {},
                airport_to: {},
                flight_seat: []
            },
            html: '',
            onSubmit: false,
            step: 1,
            firstLoad: true,
            i18n: [],
            total_price_before_fee: 0,
            total_price_fee: 0,
            onLoading: false
        },
        computed: {
            adult_total_price_show() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.price) {
                            total = `${this.adults} * ${window.bravo_format_money(seat.price)}`;
                        }
                    });
                }
                console.log('Adult Total Price Show:', total); // Debugging
                return total;
            },
            child_total_price_show() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Child_price) {
                            total = `${this.children} * ${window.bravo_format_money(seat.Child_price)}`;
                        }
                    });
                }
                console.log('Child Total Price Show:', total); // Debugging
                return total;
            },
            infant_total_price_show() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Infants_price) {
                            total = `${this.infants} * ${window.bravo_format_money(seat.Infants_price)}`;
                        }
                    });
                }
                console.log('Infant Total Price:', total); // Debugging
                return total;
            },
            adult_total_price() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.price) {
                            total += this.adults * Number(seat.price);
                        }
                    });
                }
                console.log('Adult Total Price:', total); // Debugging
                return total;
            },
            child_total_price() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Child_price) {
                            total += this.children * Number(seat.Child_price);
                        }
                    });
                }
                console.log('Child Total Price:', total); // Debugging
                return total;
            },
            infant_total_price() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Infants_price) {
                            total += this.infants * Number(seat.Infants_price);
                        }
                    });
                }
                console.log('Infant Total Price:', total); // Debugging
                return total;
            },
            total_price() {
                let total = this.adult_total_price + this.child_total_price + this.infant_total_price;
                console.log('Total Price:', total); // Debugging
                return total;
            },
            total_price_html() {
                let formattedPrice = window.bravo_format_money(this.total_price);
                console.log('Total Price HTML:', formattedPrice); // Debugging
                return formattedPrice;
            },
            
            adult_total_price_show_multiple() {
                return (flightIndex) => {
                    console.log('Flight Index:', flightIndex);  // Logging the flight index
                    let total = 0;
                    if (Array.isArray(this.flights) && this.flights[flightIndex]) {
                        console.log('Flight Data:', this.flights[flightIndex]);  // Logging the flight data
                        this.flights[flightIndex].flight_seat.forEach(seat => {
                            if (seat.price) {
                                total = `${this.adults} * ${window.bravo_format_money(seat.price)}`;
                                console.log('Calculated Adult Price:', total);  // Logging the calculated price
                            }
                        });
                    }
                    return total;
                }
            },
            child_total_price_show_multiple() {
                return (flightIndex) => {
                    console.log('Flight Index:', flightIndex);  // Logging the flight index
                    let total = 0;
                    if (Array.isArray(this.flights) && this.flights[flightIndex]) {
                        console.log('Flight Data:', this.flights[flightIndex]);  // Logging the flight data
                        this.flights[flightIndex].flight_seat.forEach(seat => {
                            if (seat.Child_price) {
                                total = `${this.children} * ${window.bravo_format_money(seat.Child_price)}`;
                                console.log('Calculated Child Price:', total);  // Logging the calculated price
                            }
                        });
                    }
                    return total;
                }
            },
            infant_total_price_show_multiple() {
                return (flightIndex) => {
                    console.log('Flight Index:', flightIndex);  // Logging the flight index
                    let total = 0;
                    if (Array.isArray(this.flights) && this.flights[flightIndex]) {
                        console.log('Flight Data:', this.flights[flightIndex]);  // Logging the flight data
                        this.flights[flightIndex].flight_seat.forEach(seat => {
                            if (seat.Infants_price) {
                                total = `${this.infants} * ${window.bravo_format_money(seat.Infants_price)}`;
                                console.log('Calculated Infant Price:', total);  // Logging the calculated price
                            }
                        });
                    }
                    return total;
                }
            }
        },
        methods: {
            openModal(flightId) {
                this.clearFlightData(); // Clear data before opening the modal
                $('#flightFormBookModal').modal();
                var me = this;
                me.id = flightId;
                if (me.onSubmit == true) {
                    return false;
                }
                me.onSubmit = true;
                me.onLoading = true; // Show loading icon
                $.ajax({
                    url: bookingCore.module.flight + '/getData/' + me.id,
                    data: this.form,
                    dataType: 'json',
                    method: 'post',
                    success: (json) => {
                        console.log('API Response:', json); // Debugging
                        if (json.status) {
                            this.flight = json.data;
                            this.flights = json.data;
                            this.$nextTick(() => {
                                this.$forceUpdate();  // Ensure Vue re-renders the component
                            });
                        }
                        this.onSubmit = false;
                        this.onLoading = false;
                    },
                    error: (e) => {
                        console.error('API Error:', e); // Debugging
                        this.onSubmit = false;
                        this.onLoading = false;
                    }
                });
            },
            // clearFlightData() {
            //     // Reset all necessary data fields
            //     this.id = '';
            //     this.buyer_fees = [];
            //     this.message = {
            //         content: '',
            //         type: false
            //     };
            //     this.flight = {
            //         airline: {},
            //         airport_from: {},
            //         airport_to: {},
            //         flight_seat: []
            //     };
            //     this.html = '';
            //     this.onSubmit = false;
            //     this.step = 1;
            //     this.firstLoad = true;
            //     this.total_price_before_fee = 0;
            //     this.total_price_fee = 0;
            //     this.onLoading = false;
            // },
            flightCheckOut() {
                var me = this;
                me.message.content = '';
                var params = {
                    adults: this.adult_total_price_show,
                    children: this.child_total_price_show,
                    infants: this.infant_total_price_show,
                    total_price: this.total_price,
                    service_id: me.flight[0].id,
                    service_type: 'flight',
                    flight_seat: me.flight[0].flight_seat
                };
                if (me.onSubmit == true) {
                    return false;
                }
                me.onSubmit = true;
                $.ajax({
                    url: bookingCore.url + '/booking/addToCart',
                    data: params,
                    dataType: 'json',
                    method: 'post',
                    success: function(json) {
                        if (!json.status) {
                            me.onSubmit = false;
                        }
                        if (json.message) {
                            me.message.content = json.message;
                            me.message.type = json.status;
                        }
                        if (json.url) {
                            window.location.href = json.url;
                        }

                        
                        if (json.errors && typeof json.errors == 'object') {
                            var html = '';
                            for (var i in json.errors) {
                                html += json.errors[i] + '<br>';
                            }
                            me.message.content = html;
                            bookingCoreApp.showError(html);
                        }
                        me.onSubmit = false;
                    },
                    error: function(e) {
                        me.onSubmit = false;
                        bravo_handle_error_response(e);
                        if (e.status == 401) {
                            $('#flightFormBookModal').modal('hide');
                        }
                        if (e.status != 401 && e.responseJSON) {
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        }
                        me.onSubmit = false;
                    }
                });
            },
            minusNumberFlightSeat(flightSeat) {
                if (flightSeat.number <= 0) {
                    flightSeat.number = 0;
                } else {
                    flightSeat.number--;
                }
            },
            addNumberFlightSeat(flightSeat) {
                if (flightSeat.number >= flightSeat.max_passengers) {
                    flightSeat.number = flightSeat.max_passengers;
                } else {
                    flightSeat.number++;
                }
            },
            updateNumberFlightSeat(flightSeat) {
                if (flightSeat.number >= flightSeat.max_passengers) {
                    flightSeat.number = flightSeat.max_passengers;
                }
            }
        },
        mounted() {
            this.adults = window.initialData.adults || 0;
            this.children = window.initialData.children || 0;
            this.infants = window.initialData.infants || 0;
        }
    });

    var flightFormBook = new Vue({
        el:'#flightFormBook',
        data:{
        },
        methods:{
            openModalBook(flightId){
                flightFormBookModal.openModal(flightId);
            }
        },
        mounted(){
            var me = this;
            $(document).on('click','.btn-choose-flight',function(){
                me.openModalBook($(this).data('id'));
            })
        }
    })
    



    var flightFormBookModalMulti = new Vue({
        el: '#flightFormBookModalMulti',
        data: {
            id: '',
            buyer_fees: [],
            message: {
                content: '',
                type: false
            },
            adults: 0,
            children: 0,
            infants: 0,
            flights: {
                airline: {},
                airport_from: {},
                airport_to: {},
                flight_seat: []
            },
            flight: {
                airline: {},
                airport_from: {},
                airport_to: {},
                flight_seat: []
            },
            html: '',
            onSubmit: false,
            step: 1,
            firstLoad: true,
            i18n: [],
            total_price_before_fee: 0,
            total_price_fee: 0,
            onLoading: false,
            modal: null
        },
        computed: {
            hasTwoFlights() {
                return Array.isArray(this.flights) && this.flights.length >= 2;
            },
            hasOneFlight() {
                return Array.isArray(this.flights) && this.flights.length === 1;
            },
            adult_total_price_show() {
                let total = 0;
                
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.price) {
                            total = `${this.adults} * ${window.bravo_format_money(seat.price)}`;
                        }
                    });
                }
                console.log('Adult Total Price Show:', total); // Debugging
                return total;
            },
            child_total_price_show() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Child_price) {
                            total = `${this.children} * ${window.bravo_format_money(seat.Child_price)}`;
                        }
                    });
                }
                console.log('Child Total Price Show:', total); // Debugging
                return total;
            },
            infant_total_price_show() {
                let total = 0;
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Infants_price) {
                            total = `${this.infants} * ${window.bravo_format_money(seat.Infants_price)}`;
                        }
                    });
                }
                console.log('Infant Total Price:', total); 
                return total;
            },
            adult_total_price() {
                let total = 0;
                if(this.hasTwoFlights){
                    this.flights.forEach(flight => {
                        if (Array.isArray(flight.flight_seat)) {
                            flight.flight_seat.forEach(seat => {
                                if (seat.price) {
                                    total += this.adults * Number(seat.price);
                                }
                            });
                        }
                    });
                }
                else{
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.price) {
                            total += this.adults * Number(seat.price);
                        }
                    });
                }
                }
                console.log('Adult Total Price:', total); // Debugging
                return total;
            },
            child_total_price() {
                let total = 0;
                if(this.hasTwoFlights){
                    this.flights.forEach(flight => {
                        if (Array.isArray(flight.flight_seat)) {
                            flight.flight_seat.forEach(seat => {
                                if (seat.Child_price) {
                                    total += this.children *  Number(seat.Child_price);
                                }
                            });
                        }
                    });
                }
                else{
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Child_price) {
                            total += this.children * Number(seat.Child_price);
                        }
                    });
                }
                }
                console.log('Child Total Price:', total); // Debugging
                return total;
            },
            infant_total_price() {
                let total = 0;
                if(this.hasTwoFlights){
                    this.flights.forEach(flight => {
                        if (Array.isArray(flight.flight_seat)) {
                            flight.flight_seat.forEach(seat => {
                                if (seat.Infants_price) {
                                    total += this.infants *  Number(seat.Infants_price);
                                }
                            });
                        }
                    });
                }
                else{
                if (Array.isArray(this.flight.flight_seat)) {
                    this.flight.flight_seat.forEach(seat => {
                        console.log('Seat:', seat); // Debugging
                        if (seat.Infants_price) {
                            total += this.infants * Number(seat.Infants_price);
                        }
                    });
                }
                }
                console.log('Infant Total Price:', total); // Debugging
                return total;
            },
            total_price() {
                let total = this.adult_total_price + this.child_total_price + this.infant_total_price;
                console.log('Total Price:', total); // Debugging
                return total;
            },
            total_price_html() {
                let formattedPrice = window.bravo_format_money(this.total_price);
                console.log('Total Price HTML:', formattedPrice); // Debugging
                return formattedPrice;
            },
            // adult_total_price_show_multiple() {
            //     return (flightIndex) => {
            //         console.log('Flight Index:', flightIndex);  // Logging the flight index
            //         let total = 0;
            //         if (Array.isArray(this.flights) && this.flights[flightIndex]) {
            //             console.log('Flight Data:', this.flights[flightIndex]);  // Logging the flight data
            //             this.flights[flightIndex].flight_seat.forEach(seat => {
            //                 if (seat.price) {
            //                     total = `${this.adults} * ${window.bravo_format_money(seat.price)}`;
            //                     console.log('Calculated Adult Price:', total);  // Logging the calculated price
            //                 }
            //             });
            //         }
            //         return total;
            //     }
            // },
            // child_total_price_show_multiple() {
            //     return (flightIndex) => {
            //         console.log('Flight Index:', flightIndex);  // Logging the flight index
            //         let total = 0;
            //         if (Array.isArray(this.flights) && this.flights[flightIndex]) {
            //             console.log('Flight Data:', this.flights[flightIndex]);  // Logging the flight data
            //             this.flights[flightIndex].flight_seat.forEach(seat => {
            //                 if (seat.Child_price) {
            //                     total = `${this.children} * ${window.bravo_format_money(seat.Child_price)}`;
            //                     console.log('Calculated Child Price:', total);  // Logging the calculated price
            //                 }
            //             });
            //         }
            //         return total;
            //     }
            // },
            // infant_total_price_show_multiple() {
            //     return (flightIndex) => {
            //         console.log('Flight Index:', flightIndex);  // Logging the flight index
            //         let total = 0;
            //         if (Array.isArray(this.flights) && this.flights[flightIndex]) {
            //             console.log('Flight Data:', this.flights[flightIndex]);  // Logging the flight data
            //             this.flights[flightIndex].flight_seat.forEach(seat => {
            //                 if (seat.Infants_price) {
            //                     total = `${this.infants} * ${window.bravo_format_money(seat.Infants_price)}`;
            //                     console.log('Calculated Infant Price:', total);  // Logging the calculated price
            //                 }
            //             });
            //         }
            //         return total;
            //     }
            // }
        },
        methods: {
            openModal(flightId) {
                console.log("Opening modal for flight ID:", flightId);
                this.modal.show();
                this.id = flightId;
                if (this.onSubmit) {
                    return false;
                }
                this.onSubmit = true;
                this.onLoading = true;
                $.ajax({
                    url: bookingCore.module.flight + '/getMultiData/' + this.id,
                    data: this.form,
                    dataType: 'json',
                    method: 'post',
                    success: (json) => {
                        console.log('API Response:', json.data); // Debugging
                        // if(json.data == undefined){
                        //     this.flight.message =  "Please try another flight";
                        // }
                        if (json.status) {
                            this.flight = json.data[0];
                            this.flights = json.data;
                            this.$nextTick(() => {
                                this.$forceUpdate();  // Ensure Vue re-renders the component
                            });
                        }
                        this.onSubmit = false;
                        this.onLoading = false;
                    },
                    error: (e) => {
                        console.error('API Error:', e); // Debugging
                        this.onSubmit = false;
                        this.onLoading = false;
                    }
                });
            },
            clearFlightData() {
                // Reset all necessary data fields
                this.id = '';
                this.buyer_fees = [];
                this.message = {
                    content: '',
                    type: false
                };
                this.flight = {
                    airline: {},
                    airport_from: {},
                    airport_to: {},
                    flight_seat: []
                };
                this.html = '';
                this.onSubmit = false;
                this.step = 1;
                this.firstLoad = true;
                this.total_price_before_fee = 0;
                this.total_price_fee = 0;
                this.onLoading = false;
            },
            getAssetUrl(code) {
                return `/uploads/${code}`;
            },
            flightCheckOut() {
                this.message.content = '';
                if(this.hasTwoFlights){
                    const infantPrices = [
                        this.infant_total_price_show_multiple(0),
                        this.infant_total_price_show_multiple(1)
                    ];
                    
                    // Check if the first element is 0 and adjust the result accordingly
                    const infantsresult = infantPrices[0] === 0 ? null : JSON.stringify(infantPrices);
                    const adultPrices = [
                        this.adult_total_price_show_multiple(0),
                        this.adult_total_price_show_multiple(1)
                    ];
                    
                    // Check if the first element is 0 and adjust the result accordingly
                    const adultsresult = adultPrices[0] === 0 ? null : JSON.stringify(adultPrices);
                    const childrenPrices = [
                        this.child_total_price_show_multiple(0),
                        this.child_total_price_show_multiple(1)
                    ];
                    
                    // Check if the first element is 0 and adjust the result accordingly
                    const childrenPriceresult = childrenPrices[0] === 0 ? null : JSON.stringify(childrenPrices);
                    let params = {
                        adults: adultsresult,
                        children: childrenPriceresult,
                        infants: infantsresult,
                        total_price: this.total_price,
                        service_id: this.flights[0].id,
                        service_type: 'flight',
                        flight: this.flights
                    };
                    if (this.onSubmit) {
                        return false;
                    }
                    this.onSubmit = true;
                    $.ajax({
                        url: bookingCore.url + '/flight/addToCart',
                        data: params,
                        dataType: 'json',
                        method: 'post',
                        success: (json) => {
                            if (!json.status) {
                                this.onSubmit = false;
                            }
                            if (json.message) {
                                this.message.content = json.message;
                                this.message.type = json.status;
                            }
                            if (json.url) {
                                window.location.href = json.url;
                            }
                            if (json.errors && typeof json.errors === 'object') {
                                let html = '';
                                for (let i in json.errors) {
                                    html += json.errors[i] + '<br>';
                                }
                                this.message.content = html;
                                bookingCoreApp.showError(html);
                            }
                            this.onSubmit = false;
                        },
                        error: (e) => {
                            this.onSubmit = false;
                            bravo_handle_error_response(e);
                            if (e.status === 401) {
                                this.modal.hide();
                            }
                            if (e.status !== 401 && e.responseJSON) {
                                this.message.content = e.responseJSON.message ? e.responseJSON.message : 'Cannot book';
                                this.message.type = false;
                            }
                            this.onSubmit = false;
                        }
                    });
                }
                else{
                    let params = {
                        adults: this.adult_total_price_show,
                        children: this.child_total_price_show,
                        infants: this.infant_total_price_show,
                        total_price: this.total_price,
                        service_id: this.flight.id,
                        service_type: 'flight',
                        flight: this.flight
                    };
                    if (this.onSubmit) {
                        return false;
                    }
                    this.onSubmit = true;
                    $.ajax({
                        url: bookingCore.url + '/flight/addToCart',
                        data: params,
                        dataType: 'json',
                        method: 'post',
                        success: (json) => {
                            if (!json.status) {
                                this.onSubmit = false;
                            }
                            if (json.message) {
                                this.message.content = json.message;
                                this.message.type = json.status;
                            }
                            if (json.url) {
                                window.location.href = json.url;
                            }
                            if (json.errors && typeof json.errors === 'object') {
                                let html = '';
                                for (let i in json.errors) {
                                    html += json.errors[i] + '<br>';
                                }
                                this.message.content = html;
                                bookingCoreApp.showError(html);
                            }
                            this.onSubmit = false;
                        },
                        error: (e) => {
                            this.onSubmit = false;
                            bravo_handle_error_response(e);
                            if (e.status === 401) {
                                this.modal.hide();
                            }
                            if (e.status !== 401 && e.responseJSON) {
                                this.message.content = e.responseJSON.message ? e.responseJSON.message : 'Cannot book';
                                this.message.type = false;
                            }
                            this.onSubmit = false;
                        }
                    });
            }
            },
            minusNumberFlightSeat(flightSeat) {
                if (flightSeat.number <= 0) {
                    flightSeat.number = 0;
                } else {
                    flightSeat.number--;
                }
            },
            addNumberFlightSeat(flightSeat) {
                if (flightSeat.number >= flightSeat.max_passengers) {
                    flightSeat.number = flightSeat.max_passengers;
                } else {
                    flightSeat.number++;
                }
            },
            updateNumberFlightSeat(flightSeat) {
                if (flightSeat.number >= flightSeat.max_passengers) {
                    flightSeat.number = flightSeat.max_passengers;
                }
            },
            adult_total_price_show_multiple(index) {
                let total = 0;
                if (this.hasTwoFlights) {
                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.price) {
                                total = `${this.adults} * ${window.bravo_format_money(seat.price)}`;
                            }
                        });
                    }
                }
                return total;
            },
            child_total_price_show_multiple(index) {
                let total = 0;
                if (this.hasTwoFlights) {
                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.Child_price) {
                                total = `${this.children} * ${window.bravo_format_money(seat.Child_price)}`;
                            }
                        });
                    }
                }
                return total;
            },
            infant_total_price_show_multiple(index) {
                let total = 0;
                if (this.hasTwoFlights) {
                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.Infants_price) {
                                total = `${this.infants} * ${window.bravo_format_money(seat.Infants_price)}`;
                            }
                        });
                    }
                }
                return total;
            }

            
        },
        mounted() {
            try {
                this.modal = new bootstrap.Modal('#flightFormBookModalMulti');
                console.log("Modal initialized:", this.modal);
            } catch (error) {
                console.error("Error initializing modal:", error);
            }
            this.adults = window.initialData.adults || 0;
            this.children = window.initialData.children || 0;
            this.infants = window.initialData.infants || 0;
        }
    });
    
    window.flightFormBookModalMulti = new Vue({
        el: '#flightFormBookModalMulti',
        data: {
            selectedFlight: null,  // Store selected flight data here
            // Add other data properties as needed
        },
        methods: {
            openModalBook(flightId) {
                
                this.clearFlightData();
                // Proceed with opening the modal for the new flight
                flightFormBookModalMulti.openModal(flightId);
            },
            clearFlightData() {
                // Reset the relevant data properties
                this.selectedFlight = null;
                // Reset other properties as needed
            }
        },
        created() {
            var me = this;
            $(document).on('click', '.btn-choose-flight-multi', function() {
                me.openModalBook($(this).data('id'));
            });
            $(document).on('click', '.btn-choose-flight-multi', function() {
                me.openModalBook($(this).data('id'));
            });
        },
    });
    

    $(".bravo_filter .g-filter-item").each(function () {
        if($(window).width() <= 990){
            $(this).find(".item-title").toggleClass("e-close");
        }
        $(this).find(".item-title").click(function () {
            $(this).toggleClass("e-close");
            if($(this).hasClass("e-close")){
                $(this).closest(".g-filter-item").find(".item-content").slideUp();
            }else{
                $(this).closest(".g-filter-item").find(".item-content").slideDown();
            }
        });
        $(this).find(".btn-more-item").click(function () {
            $(this).closest(".g-filter-item").find(".hide").removeClass("hide");
            $(this).addClass("hide");
        });
        $(this).find(".bravo-filter-price").each(function () {
            var input_price = $(this).find(".filter-price");
            var min = input_price.data("min");
            var max = input_price.data("max");
            var from = input_price.data("from");
            var to = input_price.data("to");
            var symbol = input_price.data("symbol");
            input_price.ionRangeSlider({
                type: "double",
                grid: true,
                min: min,
                max: max,
                from: from,
                to: to,
                prefix: symbol
            });
        });
    });
    $(".bravo_form_filter input[type=checkbox]").change(function () {
        $(this).closest(".bravo_form_filter").submit();
    });

})(jQuery);
