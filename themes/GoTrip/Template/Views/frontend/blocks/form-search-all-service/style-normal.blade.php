<style>
    .is-tab-el-active {
        color: #008cff;
    }

    .tabs.-underline .tabs__controls .tabs__button::after {
        background: #008cff;
    }

    .diabled-tabs {
        white-space: initial;
        word-break: break-all;
        width: 72px;
        font-weight: 400;
        line-height: 17px;
        font-size: 14px;
    }

    .tabs__button {
        font-size: 14px;
    }

    .gotrip_form_search {
        /* width: 1200px !important; */
        /* height:315px; */
        padding: 20px 0;
        border-radius: 15px;
        /* max-width:1110px; */
    }

    .button-item {
        position: absolute;
        left: 42%;
        /* top: 92%; */
        bottom: -21px;
        z-index: 9;
        max-width: 170px !important;

    }

    .mainSearch__submit {
        height: 44px !important;
        height: 43px !important;

    }

    .bravo_wrap .gotrip_form_search .field-items {
        /* width: 1080px; */
        margin: 0 auto;
        position: relative;
        /* z-index: 10; */
        margin: 0px 11px !important;
        border-radius: 8px;
        /* box-shadow: 0 1px 5px 0 rgb(0 0 0 / 10%); */
        padding: 0 20px;
    }

    .adjust-border {
        border: 1px solid #e7e7e7;
        border-radius: 10px;
        height: 80px;
    }

    .react-autosuggest__input {
        background: #ffffff;
        box-shadow: 0 2px 3px 0 rgb(0 0 0 / 10%);
        padding: 11px 10px 11px 30px;
        outline: 0;
        border: 0;
        width: 100%;
        font-size: calc(var(--font-scale, 1) * 16px);
        color: #000000;
        font-weight: 700;
    }

    .bravo_wrap .gotrip_form_search .field-items>.row>div:not(:last-child) {
        height: 75px;
        padding-top: 10px;
    }

    .button-item .text-search,
    .button-item .icon-search {
        font-size: 20px !important;
    }

    .bravo_wrap .gotrip_form_search .button-item .button {
        max-width: 235px !important;
    }


    @media (max-width: 769px) {
        .go-tabs {
            /* left: 39% !important; */
            background: white !important;
            width: 150px !important;
            padding: 10px 13px !important;
            /* top: -45px !important; */
        }

        .gotrip_form_search {
            height: 460px !important;
        }
    }

    @media (max-width:426px){
        /* .go-tabs {
            left: 32% !important;
           
        } */
    }
 
    @media (max-width:376px){
        /* .go-tabs {
            left: 29% !important;
           
        } */
    }
    @media (max-width:321px){
        /* .go-tabs {
            left: 25% !important;
           
        } */
    }
    .search-header-wrapper{
        width: 100% !important;
        position: absolute;
        z-index: 21 !important;
    }
</style>
<section data-anim-wrap class="form-search-all-service masthead -type-1 z-5">
    <div data-anim-child="fade" class="masthead__bg">
        <img src="{{ $bg_image_url }}" alt="image" data-src="{{ $bg_image_url }}" class="js-lazy">
    </div>

    <div class="container">
        <div class="row justify-center">
            <div class="">
                <div id="search-title" class="text-center d-none">
                    <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 text-white">
                        {{ $title }}</h1>
                    <p data-anim-child="slide-up delay-5" class="text-white mt-6 md:mt-10">{{ $sub_title }}</p>
                </div>

                @if (empty($hide_form_search))
                    <div data-anim-child="slide-up delay-6" class="tabs -underline mt-60 js-tabs">
                        <center>
                            <div class="search-header-wrapper" style="z-index: 33px !important">

                                <div style=" gap: 25px;    padding: 10px 0px;   box-shadow: 0 2px 20px 0 rgb(0 0 0 / 10%);  width: 290px;  "
                                    class="go-tabs bg-white tabs__controls d-flex justify-center sm:justify-start js-tabs-controls">
                                    @if ($service_types)
                                        @php
                                            $allServices = get_bookable_services();
                                            $number = 0;
                                        @endphp
                                        @foreach ($service_types as $index => $service_type)
                                            @php
                                                if (empty($allServices[$service_type])) {
                                                    continue;
                                                }
                                                $service = $allServices[$service_type];
                                            @endphp
                                            <div class="" style="width:72px; color:var(--color-dark-1);">
                                                <div class="image-wrapper-go">
                                                    <img style="width:52px"
                                                        src="{{ $index == 0 ? asset('/images/hotels.png') : asset('/images/ap.png') }}" />
                                                </div>
                                                <button
                                                    class="w-100 tabs__button text-15 fw-500 text-dark pb-4 js-tabs-button @if ($number == 0) is-tab-el-active @endif"
                                                    data-tab-target=".-tab-item-{{ $service_type }}"
                                                    style="color: var(--color-dark-1);">
                                                    {{ $service::getModelName() }}
                                                </button>
                                            </div>

                                            @php $number++; @endphp
                                        @endforeach
                                    @endif
                                    {{-- <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img class="" style="width:52px" src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           Homestays&Villas
                                        </button>
                                    </div>
                                    <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img  src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           Holiday<br>Packages
                                        </button>
                                    </div>
                                    <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img style="width:52px" src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           Trains
                                        </button>
                                    </div>
                                    <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img style="width:52px" src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           Buses
                                        </button>
                                    </div>
                                    <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img style="width:52px" src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           Cabs
                                        </button>
                                    </div>
                                    <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img style="width:52px" src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           ForexCard&Currency
                                        </button>
                                    </div>
                                    <div style="width:72px">
                                        <div class="image-wrapper-go">
                                            <img style="width:52px" src="{{asset('/images/ap.png')}}"/>
                                        </div>
                                        <button disabled class="diabled-tabs">
                                           Travel<br>Insurance
                                        </button>
                                    </div> --}}
                                </div>
                                
                            </div>

                        </center>
                        <div class="tabs__content   js-tabs-content">
                            @if ($service_types)
                                @php $number = 0; @endphp
                                @foreach ($service_types as $k => $service_type)
                                    @php
                                        if (empty($allServices[$service_type])) {
                                            continue;
                                        }
                                    @endphp
                                    <div
                                        class="tabs__pane -tab-item-{{ $service_type }} @if ($number == 0) is-tab-el-active @endif">
                                        @include(ucfirst($service_type) . '::frontend.layouts.search.form-search',
                                            ['style' => 'normal']
                                        )
                                    </div>
                                    @php $number++; @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
