@php
    $style = $style ?? 'default';
    $classes = ' form-search-all-service mainSearch bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 mt-30';
    $button_classes = " -dark-1 py-15 col-12 bg-blue-1 text-white w-100 rounded-4";
    if($style == 'normal'){
        $classes = ' px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-100 form-search-all-service mainSearch -w-900 bg-white';
        $button_classes = " -dark-1 py-15 h-60 col-12 rounded-100 bg-blue-1 text-white w-100";
    }
    if($style == 'normal2'){
        $classes = 'mainSearch bg-white pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 shadow-1';
        $button_classes = " -dark-1 py-15 h-60 col-12 rounded-100 bg-blue-1 text-white w-100";
    }
    if($style == 'carousel_v2'){
        $classes = " w-100";
        $button_classes = " -dark-1 py-15 px-35 h-60 col-12 rounded-4 bg-yellow-1 text-dark-1";
    }
    if($style == 'map'){
        $classes = " w-100";
        $button_classes = " -dark-1 size-60 col-12 rounded-4 bg-blue-1 text-white";
    }
    if($style == 'hotel_carousel'){
        $classes = " form-search-all-service mainSearch bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 mt-30 form-search-service-hotel";
    }
    $search_style = setting_item('hotel_location_search_style',"normal")
@endphp
<form action="{{ route("hotel.search") }}" class="gotrip_form_search bravo_form_search bravo_form form {{ $classes }}" style="width:100% !important; background:transparent !important;" method="get">
    @if( !empty(Request::query('_layout')) )
        <input type="hidden" name="_layout" value="{{Request::query('_layout')}}">
    @endif
    @php     $search_style = setting_item('hotel_location_search_style');
             $hotel_search_fields = setting_item_array('hotel_search_fields');
             $hotel_search_fields = array_values(\Illuminate\Support\Arr::sort($hotel_search_fields, function ($value) {
                return $value['position'] ?? 0;
             }));
    @endphp



<Style>
    .bravo_wrap .form-search-all-service .tabs__pane.-tab-item-flight .bravo_form  {
        max-width: 100% !important;
        width: 100%;
        padding: 95px 0px 6rem 0px !important;
    }
        .gotrip_form_search {
        padding: 1rem 0 !important;
    display: block !important;
    height: auto !important;
    }
    .adjust-border {
        height: 120px !important;
    }
    .hotel-heading{
    text-align: center;
    color: #8f8f8f;
    font-weight: 500;
    font-size: 20px;
    }
    .smart-search-location,
    .js-first-date,
    .js-last-date,
    .render .adults,
    .render .children,
    .render{
    font-size: 16px !important; 
    color: #dfdfdf !important;
    }
    .bravo_wrap .gotrip_form_search .field-items > .row > div{
    padding: 8px 9px 0 !important;
    border:none !important;
    }
    /* .field-items h4{
    font-size: 14px !important;
    
    } */
    .field-items .row{
        height: 100% !important;
    }
    
    .searchMenu-loc__field > div{
        
         position: fixed !important;
         box-shadow: 0 10px 10px #dfd6d6
        
    }
    
    
    .header-row{
        
    }
    .check-in-out-render{
        & span{
    
            font-size: 15px !important;
        }
    }
 
    
        .col-lg-2{
            & button{
                position: relative;
        top: 20px;
        left: 5px;
        padding: 5px 10px;
            }
        }
    
        /* .bravo_wrap .gotrip_form_search .field-items:nth-child(1){
            padding: 65px 20px 20px;
        } */
        .bravo_wrap .bravo_search_flight .bravo_form_search {
            display: flex;
        justify-content: space-between;
        align-items: start;
    
        }
        .tabs.-underline .tabs__controls .tabs__button::after{
            background-color: var(--color-dark-1);
        }
    .button-city-add{
        background: transparent !important;
        color: var(--color-dark-1);
        border: 1px solid var(--color-dark-1);
        border-radius: 4px;
        padding: 20px !important;
        margin-top: 10px
    }
    .gotrip_form_search{
        padding: 0px !important;
        border: none !important;
    
    }
    .border-light {
    border: none;
    }
    .field-items{
        padding-top: 10px !important;
        .row{
            color: white;
            .col-lg-2,
            .col-lg-3,
            .col-lg-1,
            .col-lg-4{
            background: hsl(0deg 0.84% 30.33% / 45%) !important;
            border-radius: 4px !important;
            }
        }
    }
    
 
    #search-title{
        display: none;
    }
    
    .header-row{
        gap: 10px !important;
        background: none;
        .col-lg-2,
        .col-lg-3{
        background: hsl(0deg 0.84% 30.33% / 45%) !important;
            border-right: none !important;
            border-radius: 4px ;
        }
    }
    .js-search::placeholder{
    color: #dfdfdf !important;
    }
    
    .js-search{
    color: #dfdfdf !important;
    }
    #multiCityDiv1,
    #multiCityDiv2,
    #multiCityDiv3,
    #multiCityDiv4,
    #multiCityDiv5{
        margin: 0 !important;
        max-width: 1181px !important;
        border: none !important;
    }
    .button-city-add{
        margin: 0 !important;
        top: 2px !important;
        left: 0 !important;
    }
    .trip-heading{
        & h4{
            padding: 13.5px 10px
        }
    }
    
    .last-tab{
        position: fixed !important;
        color: black;
        .row{
            color: var(--color-dark-1);
        }
    }
    </style>
    
    <script>
      if (window.location.pathname === '/flight') {
        document.styleSheets[0].addRule('.bravo_wrap .bravo_search_flight .bravo_form_search', 'margin-top: 10px !important;');
        document.styleSheets[0].addRule('.bravo_wrap .gotrip_form_search .field-items:nth-child(1)', 'padding: 20px 20px 20px !important');
      }
    </script>











{{-- <h3 class="hotel-heading d-block " style="color: #dfd6d6;">Book Hotels & Homestays In India</h3> --}}
    <div class="field-items">
        <div class="row w-100 m-0 d-flex"  style="gap:12px; color: var(--color-dark-1); border-radius: 10px;">
            @if(!empty($hotel_search_fields))
                @foreach($hotel_search_fields as $field)
                {{-- {{ $field['size'] ?? "6" }} --}}
                    <div class="col-lg-3 align-self-start px-30 lg:py-20 lg:px-0">
                        @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                        @switch($field['field'])
                            @case ('service_name') @include('Layout::common.search.fields.service_name') @break
                            @case ('location') @include('Layout::common.search.fields.location') @break
                            @case ('date')                     @include('Layout::common.search.fields.date' ,[
                                'index' => 0
                            ]) @break
                            @case ('attr') @include('Layout::common.search.fields.attr') @break
                            @case ('guests') @include('Layout::common.search.fields.guests') @break
                        @endswitch
                    </div>
                @endforeach
            @endif
            <div class="button-item col-2 ms-auto align-self-start px-30 lg:py-20 lg:px-0">
                <button class="mainSearch__submit button {{ $button_classes }}" type="submit">
                    <i class="icon-search text-20 mr-10"></i>
                    <span class="text-search">{{__("SEARCH")}}</span>
                </button>
            </div>
        </div>
    </div>

</form>
