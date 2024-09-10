<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

<section class="contact-section">
    <h1>Contact Us</h1>
</section>
<style>
.contact-section {
    position: relative; /* Needed for the pseudo-element positioning */
    background-image: url('{{ asset('/images/bgcontactus.jpg') }}'); /* Replace with your image URL */
    background-size: cover;
    height: 90vh; /* Full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white; /* Text color */
    overflow: hidden; /* Ensure no overflow from the pseudo-element */
}

.contact-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
    z-index: 1; /* Place it below the content */
}

.contact-section h1 {
    font-size: 12rem; /* Adjust size as needed */
    font-family: playfair-display-500;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adds shadow for better readability */
    z-index: 2; /* Ensure it is above the overlay */
    position: relative; /* Needed to position content above the overlay */
}
.header-margin{
    margin-top: 0px !important;
}
.custom-header{
    position: absolute !important;
    background: transparent !important;
}
.map-form {
    margin-top: 0px !important;
}

@media (max-width: 1000px) {
    .contact-section h1 {
    font-size: 9rem; /* Adjust size as needed */
    font-family: playfair-display-500;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adds shadow for better readability */
    z-index: 2; /* Ensure it is above the overlay */
    position: relative; /* Needed to position content above the overlay */
}
}

@media (max-width: 700px) {
    .contact-section h1 {
    font-size: 4rem; /* Adjust size as needed */
    font-family: playfair-display-500;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adds shadow for better readability */
    z-index: 2; /* Ensure it is above the overlay */
    position: relative; /* Needed to position content above the overlay */
}
}
</style>
<div class="bravo-contact-block">
    <div class="row">
    <div class="col-lg-7 col-sm-12 ratio ratio-16:9">
        <div class="map-ratio">
            <div class="iframe_map">
                {!! ( setting_item("page_contact_iframe_google_map")) !!}
            </div>
        </div>
    </div>
    <section class="col-lg-5 col-sm-12">
        <div class="relative container">
            <div class="row">
                <div>
                    <form method="post" action="{{ route("contact.store") }}" class="bravo-contact-block-form">
                        {{csrf_field()}}
                        <div style="display: none;">
                            <input type="hidden" name="g-recaptcha-response" value="">
                        </div>
                        <div
                            class="map-form px-40 pt-40 pb-30 lg:px-30 lg:py-30 md:px-24 md:py-24 bg-white rounded-4 shadow-4">
                            <div class="text-22 fw-500">
                                {{ __("Send a message") }}
                            </div>
                            <div class="row y-gap-20 pt-20">
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input type="text" required name="name">
                                        <label class="lh-1 text-16 text-light-1">{{ __("Full Name") }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input type="text" required name="email">
                                        <label class="lh-1 text-16 text-light-1">{{ __("Email") }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <textarea required rows="4" name="message"></textarea>
                                        <label class="lh-1 text-16 text-light-1">{{ __('Your Messages') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{recaptcha_field('contact')}}
                                </div>
                                <div class="col d-flex justify-content-lg-start">
                                    <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white">
                                        {{ __("Send a Messsage") }}
                                        <i class="fa fa-spinner fa-pulse fa-fw d-none"></i>
                                        <div class="icon-arrow-top-right ml-15"></div>
                                    </button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-mess"></div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
<section data-anim="slide-up delay-1" class="layout-pt-md layout-pb-md">
    <div class="container">
        <div class="row ml-0 mr-0 items-center justify-between">
            <div class="col-xl-5 px-0">
                <img src="{{asset('/uploads/GoTrip/general/subscribe.png')}}" alt="image" data-src="{{asset('/uploads/GoTrip/general/subscribe.png')?? "" }}" class="js-lazy col-12 h-400">
            </div>

            <div class="col px-0">
                <div class="d-flex justify-center flex-column h-400 px-80 py-40 md:px-30 bg-light-2">
                    {{-- <div class="icon-newsletter text-60 sm:text-40 text-dark-1"></div> --}}
                    <h2 class="text-30 sm:text-24 lh-15 mt-20 text-black">Get Updates and More</h2>
                    <p class="mt-5 text-black" style="color:black;">Sign up and we'll send the best deals</p>

                    <form action="{{route('newsletter.subscribe')}}" class="subcribe-form bravo-subscribe-form bravo-form">
                        @csrf
                        <div class="single-field -w-410 d-flex x-gap-10 flex-wrap y-gap-20 pt-30">
                            <div class="col-auto">
                                <input class="col-12 bg-white h-60" name="email" type="text" placeholder="{{__('Your Email')}}">
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="button -md h-60 text-white " style="background-color: var(--color-dark-1);">{{__('Subscribe')}}</button>
                            </div>
                            <div class="form-mess"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
