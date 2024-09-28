@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
@endpush
<style>
    .button.-min-180{
        min-width: 100px !important;
        background-color: #f17531 !important;
        color: white;
        &:hover{
            /* background-color: transparent !important;
            color: orange;
            border: 1px solid orange; */
        }
    }
    .ctaCard__content p {
    white-space: normal;   /* Allows the text to break and wrap */
    word-wrap: break-word; /* Forces long words to break */
    overflow: hidden;      /* Ensures no overflow beyond the container */
    display: -webkit-box;  /* Required for limiting text lines */
    -webkit-line-clamp: 2; /* Limits text to 2 lines */
    -webkit-box-orient: vertical;
}
.ctaCard__content h4 {
    white-space: normal;   /* Allows the text to break and wrap */
    word-wrap: break-word; /* Forces long words to break */
    overflow: hidden;      /* Ensures no overflow beyond the container */
    display: -webkit-box;  /* Required for limiting text lines */
    -webkit-line-clamp: 1; /* Limits text to 2 lines */
    -webkit-box-orient: vertical;
}
.ratio-41\:45::before{
    padding-bottom: 60.7561% !important;
}
.slick-slide {
    margin: 0 10px; /* Add margin between slides */
}
.slick-carousel .col-lg-3, .slick-carousel .col-sm-6 {
    width: 100%; /* Allow Slick to manage the width of slides */
    display: block;
}
.slick-list {
 /* overflow-y: auto !important;   
 overflow-x: hidden !important; */
}
.bravo-offer{
    height: 400px !important;
    
}
.sldie-cloned{
    height: 335px !important;

}
.slick-track{
    height: 335px !important;
}
.slick-slide{
    padding: 8px !important; 
    background-color: white;
    box-shadow: 0 0 5px 2px rgb(181 181 181 / 61%);
    margin:  40px 8px;
    border-radius: 5px; 
}
.parah-text{
    font-size: 17px;
}
.heading-text{
    font-size: 21px;
}
@media (max-width:769px) {
    .ctaCard__content{
        padding: 10px !important;
    }
    .parah-text{
    font-size: 13px;
}
.heading-text{
    font-size: 18px;
}
}
</style>
<div class="bravo-offer ">
    <div data-anim-wrap class="container">
        @if(!empty($title))
            <div data-anim-child="slide-up delay-1" class="row pb-40">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $subtitle ?? '' }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(!empty($list_item))
            <div class="slick-carousel">
                @foreach($list_item as $key=>$item)
                    <div data-anim-child="slide-up delay-{{$key+2}}" class="item">
                        <div class="main-the-wrapper">
                        <div class="ctaCard -type-1 rounded-4">
                            <div class="ctaCard__image ratio ratio-41:45">
                                <img class="img-ratio js-lazy" src="#" data-src="{{ get_file_url($item['background_image'],'full') ?? "" }}" alt="image">
                            </div>
                        </div>
                        <div class="ctaCard__content py-10  lg:py-10 lg:px-30" style="height: 150px;">
                            <h4 class="heading-text">{!! clean($item['title']) !!}</h4>
                            @if(!empty($item['featured_text']))
                                <p class=" parah-text">{{ $item['featured_text'] }}</p>
                            @endif
                            <div class="d-inline-block mt-30 btn-book-now" style="
                                /* bottom: -10px; */
                                display: flex !important;
                                position: absolute;
                                left: 3.5rem;
                                transform: translateX(-50%);
                                margin-bottom: 20px;
                            ">
                                <a href="{{$item['link_more']}}" class="button px-48 py-10 -blue-1 -min-180 bg-white text-dark-1">
                                    {{$item['link_title']}}
                                </a>
                            </div>
                        </div>
                        </div>
                 
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>


@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
$(document).ready(function(){
    $('.slick-carousel').slick({
        slidesToShow: 4,  // Show 4 items at a time on larger screens
        slidesToScroll: 1,
        autoplay: true,   
        autoplaySpeed: 3000,  
        arrows: false,     
        dots: false,       
        infinite: true,   
        responsive: [     
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3  // Show 3 items on medium screens
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2  // Show 2 items on small screens
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1  // Show 1 item on mobile screens
                }
            }
        ]
    });
});

</script>

@endpush