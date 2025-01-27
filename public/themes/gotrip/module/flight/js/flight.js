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
            onLoading: false,
            modal: null
        },
        computed: {
            hasTwoFlights() {
                return Array.isArray(this.flights) && this.flights.length === 2;
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
                $('#flightFormBookModal').modal('show');
                this.id = flightId;
                if (this.onSubmit) {
                    return false;
                }
                this.onSubmit = true;
                this.onLoading = true;
                $.ajax({
                    url: bookingCore.module.flight + '/getData/' + this.id,
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
                this.modal = new bootstrap.Modal('#flightFormBookModal');
                console.log("Modal initialized:", this.modal);
            } catch (error) {
                console.error("Error initializing modal:", error);
            }
            this.adults = window.initialData.adults || 0;
            this.children = window.initialData.children || 0;
            this.infants = window.initialData.infants || 0;
        }
    });
    
    window.flightFormBook = new Vue({
        el: '#flightFormBook',
        data: {
            selectedFlight: null,  // Store selected flight data here
            // Add other data properties as needed
        },
        methods: {
            openModalBook(flightId) {
                // Clear the previous data
                this.clearFlightData();
    
                // Proceed with opening the modal for the new flight
                flightFormBookModal.openModal(flightId);
            },
            clearFlightData() {
                // Reset the relevant data properties
                this.selectedFlight = null;
                // Reset other properties as needed
            }
        },
        created() {
            var me = this;
            $(document).on('click', '.btn-choose-flight', function() {
                me.openModalBook($(this).data('id'));
            });
        },
    });
    


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
    
    var flightFormSelectModalMulti = new Vue({
        el: '#flightFormSelectModalMulti',
        data: {
            id: [],
            buyer_fees: [],
            message: {
                content: '',
                type: false
            },
            adults: 0,
            children: 0,
            infants: 0,
            from_where:0,
            to_where:0,
            total_trips:0,
            flights: [],
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
                console.log('Infant Total Price Show:', total); 
                return total;
            },
            adult_total_price() {
                console.log("adult price called");
                let total = 0;
                    this.flights.forEach(flight => {
                        if (Array.isArray(flight.flight_seat)) {
                            flight.flight_seat.forEach(seat => {
                                if (seat.price) {
                                    total += this.adults * Number(seat.price);
                                }
                            });
                        }
                    });
                console.log('Adult Total Price:', total); // Debugging
                return total;
            },
            child_total_price() {
                let total = 0;
                    this.flights.forEach(flight => {
                        if (Array.isArray(flight.flight_seat)) {
                            flight.flight_seat.forEach(seat => {
                                if (seat.Child_price) {
                                    total += this.children *  Number(seat.Child_price);
                                }
                            });
                        }
                    });
                console.log('Child Total Price:', total); // Debugging
                return total;
            },
            infant_total_price() {
                let total = 0;
                    this.flights.forEach(flight => {
                        if (Array.isArray(flight.flight_seat)) {
                            flight.flight_seat.forEach(seat => {
                                if (seat.Infants_price) {
                                    total += this.infants *  Number(seat.Infants_price);
                                }
                            });
                        }});
                console.log('Infant Total Price:', total); // Debugging
                return total;
            },
            total_price() {
                let total = this.adult_total_price + this.child_total_price + this.infant_total_price;
                console.log('Total Price:', total); // Debugging
                return total;
            },
            total_price_html() {
                console.log("total price called");
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
            openSelectModalBook(flightId, index) {
                // this.onSubmit = true;
                console.log("Opening modal for flight ID:", flightId);
                console.log(index);

                if (!Array.isArray(this.id)) {
                    this.id = [];
                }
                const tripCounterDiv = document.getElementById('tripCounter');
            
                const tripCounter = tripCounterDiv.dataset.tripcounter;
                const numericTripCounter = parseInt(tripCounter, 10); // Convert to an integer
                // If the index already exists, update it; otherwise, create a new entry
                if (this.id[index]) {
                    
                    let element = document.querySelector(`a[id="${this.id[index]}"]`);
                    if (element) {
                        element.style.backgroundColor = 'white';
                        element.style.color = 'var(--color-dark-1) !important';
                        element.innerText = 'Select';
                    }
                    element = document.querySelector(`a[id="${flightId}"]`);
                    if (element) {
                        element.style.backgroundColor = 'var(--color-dark-1) !important';
                        element.style.color = 'white';
                        element.innerText = 'Selected';
                    }
                    

                    this.id[index] = flightId;
                    if(numericTripCounter){
                        let total_trips_are_selected = true;
                        for(let i = 0; i<numericTripCounter; i++){
                            if(!this.id[i]){
                                total_trips_are_selected = false;
                            }
                        }
                        if(total_trips_are_selected){
                            this.onSubmit = true;
                            this.ShowTheSelectedFlights();
                        }else{
                            this.onSubmit = false;
                        }
                    }
                } else {
                    this.id[index] = flightId;
                    element = document.querySelector(`a[id="${flightId}"]`);
                    element.innerText = 'Selected';
                    if (element) {
                        element.style.backgroundColor = 'var(--color-dark-1) !important';
                        element.style.color = 'white';
                        element.innerText = 'Selected';
                    }
                    if(numericTripCounter){
                        let total_trips_are_selected = true;
                        for(let i = 0; i<numericTripCounter; i++){
                            if(!this.id[i]){
                                total_trips_are_selected = false;
                            }
                        }
                        if(total_trips_are_selected){
                            this.onSubmit = true;
                            this.ShowTheSelectedFlights();
                        }else{
                            this.onSubmit = false;
                        }
                    }
                }
                // this.onSubmit = false;
                // $.ajax({
                //     url: bookingCore.module.flight + '/getData/' + flightId,
                //     data: this.form,
                //     dataType: 'json',
                //     method: 'post',
                //     success: (json) => {
                //         console.log('API Response:', json.data);
                //         if (json.status) {
                //             console.log('Success');
                            
                //             if (this.flights[index]) {
                //                 this.flights[index] = json.data[0];
                //             } else {
                //                 this.$set(this.flights, index, json.data[0]); // Use $set to ensure reactivity
                //             }

                //             this.$forceUpdate();


                //             if (!Array.isArray(this.id)) {
                //                 this.id = [];
                //             }
            
                //             // If the index already exists, update it; otherwise, create a new entry
                //             if (this.id[index]) {
                //                 this.id[index] = flightId;
                //             } else {
                //                 this.id[index] = flightId;
                //             }
            
                //             console.log("Updated flights:", this.flights);
                //             this.onSubmit = false;
                //             this.$nextTick(() => {
                //                 this.$forceUpdate();  // Ensure Vue re-renders the component
                //             });
                //         }
                //     },
                //     error: (e) => {
                //         this.onSubmit = false;
                //         console.error('API Error:', e); // Debugging
                //     }
                // });
            },
            ShowTheSelectedFlights(){
                this.onSubmit = true;
                $.ajax({
                    url: bookingCore.module.flight + '/getData/' + this.id,
                    data: this.form,
                    dataType: 'json',
                    method: 'post',
                    success: (json) => {

                        console.log('API Response:', json.data);
                        if (json.status) {
                            
                            console.log('Success');
                            this.flights = [];
                            json.data.forEach(element => {
                                this.flights.push(element);
                            });
                            
                            // if (this.flights[index]) {
                            //     this.flights[index] = json.data[0];
                            // } else {
                            //     this.$set(this.flights, index, json.data[0]); // Use $set to ensure reactivity
                            // }

                            this.$forceUpdate();


                            if (!Array.isArray(this.id)) {
                                this.id = [];
                            }
            
                            // If the index already exists, update it; otherwise, create a new entry
                            // if (this.id[index]) {
                            //     this.id[index] = flightId;
                            // } else {
                            //     this.id[index] = flightId;
                            // }
            
                            console.log("Updated flights:", this.flights);
                            this.onSubmit = false;
                            this.$nextTick(() => {
                                this.$forceUpdate();  // Ensure Vue re-renders the component
                            });
                        }
                    },
                    error: (e) => {
                        this.onSubmit = false;
                        console.error('API Error:', e); // Debugging
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
            getAssetUrl(code) {
                return `/uploads/${code}`;
            },
            MultiflightCheckOut() {
                this.message.content = '';
                const infantPrices = [];
                const adultPrices = [];
                const childrenPrices = [];
                const Each_flight_price = [];
                
                // Assuming flights is an array containing flight objects or data
                this.flights.forEach((flight, index) => {
                    infantPrices.push(this.infant_total_price_show_multiple(index));
                    adultPrices.push(this.adult_total_price_show_multiple(index));
                    childrenPrices.push(this.child_total_price_show_multiple(index));
                    Each_flight_price.push(this.each_total_price(index));
                });
                
                const infantsResult = infantPrices[0] === 0 ? null : JSON.stringify(infantPrices);
                const adultsResult = adultPrices[0] === 0 ? null : JSON.stringify(adultPrices);
                const childrenPricesResult = childrenPrices[0] === 0 ? null : JSON.stringify(childrenPrices);
                const Each_Flight_Price = Each_flight_price[0] === 0 ? null : JSON.stringify(Each_flight_price);

                    let params = {
                        adults: adultsResult,
                        children: childrenPricesResult,
                        infants: infantsResult,
                        Each_Flight_Price:Each_Flight_Price,
                        total_price: this.total_price,
                        service_id: this.flights[0].id,
                        service_type: 'flight',
                        flight: this.flights
                    };
                    console.log('Params:', params); // Debugging
                    if (this.onSubmit) {
                        return false;
                    }
                    this.onSubmit = true;
                    $.ajax({
                        url: bookingCore.url + '/flight/MultiaddToCart',
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

                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.price) {
                                total = `${this.adults} * ${window.bravo_format_money(seat.price)}`;
                            }
                        });
                    }
                
                return total;
            },
            child_total_price_show_multiple(index) {
                let total = 0;

                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.Child_price) {
                                total = `${this.children} * ${window.bravo_format_money(seat.Child_price)}`;
                            }
                        });
                    }
                
                return total;
            },
            infant_total_price_show_multiple(index) {
                let total = 0;
                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.Infants_price) {
                                total = `${this.infants} * ${window.bravo_format_money(seat.Infants_price)}`;
                            }
                        });
                }
                return total;
            },
            adult_total_price_each_multiple(index) {
                let total = 0;

                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.price) {
                                total += this.adults * Number(seat.price);
                            }
                        });
                    }
                
                return total;
            },
            child_total_price_each_multiple(index) {
                let total = 0;

                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.Child_price) {
                                total += this.children *  Number(seat.Child_price);
                            }
                        });
                    }
                return total;
            },
            infant_total_price_each_multiple(index) {
                let total = 0;
                    let flight = this.flights[index];
                    if (Array.isArray(flight.flight_seat)) {
                        flight.flight_seat.forEach(seat => {
                            if (seat.Infants_price) {
                                total += this.infants *  Number(seat.Infants_price);
                            }
                        });
                }
                return total;
            },
            each_total_price(index){
                let total = this.adult_total_price_each_multiple(index) + this.child_total_price_each_multiple(index) + this.infant_total_price_each_multiple(index);
                console.log('Total Price:', total); // Debugging
                return total;
            },
            each_price(index){
                console.log("Each total price called");
                let formattedPrice = window.bravo_format_money(this.each_total_price(index));
                console.log('Total Price HTML:', formattedPrice); // Debugging
                return formattedPrice;
            }
        },
        mounted() {
            try {
                this.modal = new bootstrap.Modal('#flightFormSelectModalMulti', {
                    backdrop: false
                });
                
                console.log("Modal initialized:", this.modal);
            } catch (error) {
                console.error("Error initializing modal:", error);
            }
            this.adults = window.initialData.adults || 0;
            this.children = window.initialData.children || 0;
            this.infants = window.initialData.infants || 0;
            this.from_where = window.initialData.from_where.split('|').pop().trim() || 0;
            this.to_where = window.initialData.to_where.split('|').pop().trim() || 0;
            const tripCounterDiv = document.getElementById('tripCounter');
            
            // Get the data-tripcounter value
            const tripCounter = tripCounterDiv.dataset.tripcounter;
            const numericTripCounter = parseInt(tripCounter, 10); // Convert to an integer
            console.log(numericTripCounter);
            this.total_trips = numericTripCounter;
        }
    });

    window.flightFormBookModalMulti = new Vue({
        el: '#flightFormBookModalMulti',
        data: {
            selectedFlight: null,  // Store selected flight data here
            // Add other data properties as needed
        },
        methods: {
            openSelectModalBook(flightId,index){
                this.clearFlightData();
    
                // Proceed with opening the modal for the new flight
                flightFormSelectModalMulti.openSelectModalBook(flightId,index);
            },
            openModalBook(flightId) {
                // Clear the previous data
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
            $(document).on('click', '.btn-Select-flight', function() {
                var id = $(this).data('id');

                var index = $(this).data('index');
                me.openSelectModalBook(id, index);
            });
        },
    });

    $(".bravo_filter .g-filter-item").each(function () {
        if($(window).width() <= 990){
            $(this).find(".item-title").toggleClass("e-close");
        }
        $(this).find(".item-title").on("click", function (e) {
            $(this).toggleClass("e-close");
            if($(this).hasClass("e-close")){
                $(this).closest(".g-filter-item").find(".item-content").slideUp();
            }else{
                $(this).closest(".g-filter-item").find(".item-content").slideDown();
            }
        });
        $(this).find(".btn-more-item").on("click", function (e) {
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
