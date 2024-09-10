<div class="modal fade" id="flightFormBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="font-size: 28px; font-size: 28px;
    padding: 0 10px;
    background: --color-dark-1;
    margin-bottom: 10px !important;
}">&times;</span>
				</button>
				<div v-show="onLoading" >
<div class="icon-loading d-flex flex-horizontal-center flex-content-center" style="font-size: 100px; justify-content:center; margin: 20px auto;">
    <i class="fa fa-spin icofont-spinner-alt-6"></i>
</div>
				</div>
				
				<div class="card" v-show="!onLoading && hasOneFlight ">
					<!-- Header -->
					<header class="card-header border-bottom-light">
						<div class="row text-center">
							<div class="col-md-2">
								<div class="d-flex  aligh-items-center flex-column" >
									{{-- <img v-if="flight.code" :src="getAssetUrl(flight.logo)" class="img-fluid mr-10" alt="Image-Description"> --}}
									<img v-if="flight.code" width="30px" src="{{asset('images/a.png')}}" class="img-fluid mr-10" alt="Image-Description">
									<div class="text-14 logo-name mt-1 text-black" style="text-align: start !important;">@{{flight.title}} | @{{flight.code}}</div>
								</div>
							</div>
							<div class="col-md-4 d-flex" style="gap: 5px !important;">
								{{-- <h6 class="text-left">Depart:</h6> --}}
								<div class="d-flex align-items-center" style="gap: 5px !important;">
									<div class="mr-15">
										<i class="icofont-airplane text-22 text-dark-4"></i>
									</div>
									<div class="text-left">
										<div class=" date-time d-flex align-items-end text-black" style="gap: 10px !important ">
											<h6 class="fw-500 text-22 text-gray-5 mb-0" v-html="flight.departure_time_html"></h6>
											<div class="text-14 text-gray-5" v-html="flight.departure_date_html"></div>
										</div>
										
										<span class="text-14 text-gray-1 text-black" v-html="flight.airport_from"></span>
									</div>
								</div>
							</div>
							<div class="col-md-2 d-flex">
								<div class="d-flex align-items-center text-black">
									<h6 class="text-14 fw-500 text-gray-5 mb-0" v-html="flight.duration +' hrs'"></h6>
									<div class="width-60 border-top border-primary border-width-2 my-1"></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mx-2 d-flex align-items-center" style="gap: 5px !important;">
									<div class="mr-15">
										<i class="d-block rotate-90 icofont-airplane-alt text-22 text-dark-4"></i>
									</div>
									<div class="text-left">
									<div class="date-time  d-flex align-items-end text-black" style="gap: 10px !important ">
										<h6 class="fw-500 text-22 text-gray-5 mb-0" v-html="flight.arrival_time_html"></h6>
										<div class="text-14 text-gray-5" v-html="flight.arrival_date_html"></div>
									</div>
										<span class="text-14 text-gray-1 text-black" v-html="flight.airport_to"></span>
									</div>
								</div>
							</div>
						</div>
					</header>
					<div class="card-body p-4">
						<div class="row">
							<div class="col-12 mb-1">
								
								<ul class="d-flex justify-content-between list-group list-group-borderless list-group-horizontal list-group-flush no-gutters text-black " v-for="(flight_seat,key) in flight.flight_seat" :key="key" v-if="flight_seat.max_passengers > 0">
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Seat type')}}</div>
										<span class="text-gray-1 text-capitalize" v-html="flight_seat.seat_type"></span>
									</li>
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Baggage')}}</div>
										<span class="text-gray-1 text-capitalize" v-html="flight_seat.person"></span>
									</li>
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Check-in')}}</div>
										<span class="text-gray-1" v-html="flight_seat.baggage_check_in"></span>
									</li>
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Cabin')}}</div>
										<span class="text-gray-1" v-html="flight_seat.baggage_cabin"></span>
									</li>
									<li id="adult-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Adult Price')}}</div>
										<span id="adult-price" class="text-gray-1" v-html="adult_total_price_show"></span>
									</li>
									
									<li id="child-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0" v-if="flight_seat.Child_price_html">
										<div class="fw-500 text-dark">{{__('Child Price')}}</div>
										<span id="child-price" class="text-gray-1" v-html="child_total_price_show"></span>
									</li>
									
									<li id="infant-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0" v-if="flight_seat.Infants_price_html">
										<div class="fw-500 text-dark">{{__('Infants Price')}}</div>
										<span id="infant-price" class="text-gray-1" v-html="infant_total_price_show"></span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- End Body -->
				</div>
				<div class="card" v-show="!onLoading && hasTwoFlights"  v-for="(flight, index) in flights" :key="index">
					<!-- Header -->
					<header class="card-header border-bottom-light">
						<div class="row text-center">
							<div class="col-md-2">
								<div class="d-flex align-items-start flex-column">
									<img v-if="flight.code" src="{{asset('images/a.png')}}" class="img-fluid mr-10" alt="Image-Description">
									<div class="text-14 text-black">@{{flight.title}} | @{{flight.code}}</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-flex align-items-center" style="gap: 10px !important;">
									<div class="mr-15">
										<i class="icofont-airplane text-22 text-dark-4"></i>
									</div>
									<div class="text-left">
								<div class="date-time d-flex text-black" style="gap: 10px !important;">
									<h6 class="fw-500 text-22 text-gray-5 mb-0" v-html="flight.departure_time_html"></h6>
									<div class="text-14 text-gray-5" v-html="flight.departure_date_html"></div>
								</div>
										<span class="text-14 text-gray-1 text-black" v-html="flight.airport_from"></span>
									</div>
								</div>
							</div>
							<div class="col-md-2 d-flex">
								<div class="d-flex align-items-center">
									<h6 class="text-14 fw-500 text-gray-5 mb-0" v-html="flight.duration +' hrs'"></h6>
									<div class="width-60 border-top border-primary border-width-2 my-1"></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mx-2 d-flex">
									<div class="mr-15">
										<i class="d-block rotate-90 icofont-airplane-alt text-22 text-dark-4"></i>
									</div>
									<div class="text-left">
									<div class="date-time d-flex text-black" style="gap: 10px !important;">
										<h6 class="fw-500 text-22 text-gray-5 mb-0" v-html="flight.arrival_time_html"></h6>
										<div class="text-14 text-gray-5" v-html="flight.arrival_date_html"></div>
									</div>
										<span class="text-14 text-gray-1 text-black" v-html="flight.airport_to"></span>
									</div>
								</div>
							</div>
						</div>
					</header>
					<div class="card-body p-4">
						<div class="row">
							<div class="col-12 mb-3">
								
								<ul class="d-flex justify-content-between list-group list-group-borderless list-group-horizontal list-group-flush no-gutters " v-for="(flight_seat,key) in flight.flight_seat" :key="key" v-if="flight_seat.max_passengers > 0">
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Seat type')}}</div>
										<span class="text-gray-1 text-capitalize" v-html="flight_seat.seat_type"></span>
									</li>
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Baggage')}}</div>
										<span class="text-gray-1 text-capitalize" v-html="flight_seat.person"></span>
									</li>
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Check-in')}}</div>
										<span class="text-gray-1" v-html="flight_seat.baggage_check_in"></span>
									</li>
									<li class="mb-3 mt-3  justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Cabin')}}</div>
										<span class="text-gray-1" v-html="flight_seat.baggage_cabin"></span>
									</li>
									<li id="adult-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0">
										<div class="fw-500 text-dark">{{__('Adult Price')}}</div>
										<span id="adult-price" class="text-gray-1" v-html="adult_total_price_show_multiple(index)"></span>
									</li>
									
									<li id="child-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0" v-if="flight_seat.Child_price_html">
										<div class="fw-500 text-dark">{{__('Child Price')}}</div>
										<span id="child-price" class="text-gray-1" v-html="child_total_price_show_multiple(index)"></span>
									</li>
									
									<li id="infant-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0" v-if="flight_seat.Infants_price_html">
										<div class="fw-500 text-dark">{{__('Infants Price')}}</div>
										<span id="infant-price" class="text-gray-1" v-html="infant_total_price_show_multiple(index)"></span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- End Body -->
				</div>
				<div class="col-12  col-lg-6 offset-lg-3">
					<div class="alert-text mt-3 text-left" v-show="message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></div>
					<div class="min-width-250">
						<ul class="list-unstyled font-size-1 mb-0 font-size-16">
							<li class="d-flex justify-content-between py-2">
								<span class="fw-500">{{__('Pay Amount')}}</span>
								<span class="fw-500" v-html="total_price_html"></span>
							</li>
							<li class="d-flex justify-content-center py-2 font-size-17 font-weight-bold">
								<a @click="flightCheckOut()" class="button h-60 px-24 -dark-1 bg-blue-1 text-white">
									{{__('Book Now')}}
									<div class="icon-arrow-top-right ml-15"></div>
									<i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
