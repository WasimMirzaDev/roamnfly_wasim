@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>


<style>
   .slider-container .slick-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 0px;  /* Adjust spacing between slides */
    }

    .slick-prev, .slick-next {
        background-color: #000;
        border-radius: 50%;
        color: #fff;
    }

    .uhhh.slider-container {
        padding-left: 0;
        padding-right: 0;
    }

    .slick-track {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

</style>
@endpush
<section class="layout-pt-md layout-pb-lg" id="HolidayTrip">
    <div data-anim-wrap class="container">
        @if(!empty($title) || !empty($desc))
            <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ $title }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc }}</p>
                    </div>
                </div>
                <div class="col-auto">
                    {{-- <a href="{{ route('boat.search') }}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                        {{ __('More') }}
                        <div class="icon-arrow-top-right ml-15"></div>
                    </a> --}}
                </div>
            </div>
        @endif
        <div class="y-gap-30 pt-40 sm:pt-20 uhhh slider-container">
            @php
                $index = 2;
                $classes = 'col-xl-3 col-lg-3';
                if($columns == '3'){
                    $classes = 'col-xl-4 col-lg-4';
                }
            @endphp
            @foreach($rows as $key => $row)
                <div data-anim-child="slide-up delay-{{ $index }}" class="{{ $classes }} col-sm-6">
                    @include('Boat::frontend.layouts.search.loop-grid-2')
                </div>
                @php
                    $index++;
                    if($key == 5){
                        $index = 2;
                    }
                @endphp
            @endforeach
        </div>
    </div>
</section>

<!-- Slick Slider Styling -->


<!-- Include jQuery and Slick Carousel Scripts -->
<!-- jQuery must be loaded first -->
@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Then load the Slick Carousel script -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- Initialize Slick Slider -->
<script>
$(document).ready(function(){
    if ($.fn.slick) {
        console.log('Slick is loaded');
    } else {
        console.log('Slick not loaded');
    }
});

$(document).ready(function(){
    $('.slider-container').slick({
        slidesToShow: 4,  // Number of items to show at once on large screens
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,   // Allows looping
        arrows: false,    // Hide arrows
        dots: false,      // Hide dots
        responsive: [
            {
                breakpoint: 1024,  // At 1024px or less, show 3 slides
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,  // At 768px or less, show 2 slides
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,  // At 480px or less, show 1 slide
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});

    console.log($('.slider-container').slick); // Should log a function if Slick is loaded correctly
</script>
@endpush