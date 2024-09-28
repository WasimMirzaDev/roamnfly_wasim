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
<form action="{{ route("hotel.search") }}" class="gotrip_form_search bravo_form_search bravo_form form {{ $classes }}" style="width:100% !important;" method="get">
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

        .gotrip_form_search {
        padding: 3rem 0 !important;
display: block !important;
height: auto !important;
position: relative;
    top: 54px;
    /* z-index: -1; */
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
.render .children{
    font-size: 22px !important; 
}
.bravo_wrap .gotrip_form_search .field-items > .row > div{
    padding: 15px 15px 0 !important;
    height: 100% !important;

}
.field-items {
 
}
.field-items h4{
    font-size: 17px !important;
}
@media (max-width: 769px){

.gotrip_form_search {
    /* max-height: 345px !important; */
    height: 100% !important; 
}
.button-item {
    max-width: 135px !important;
}
.button-item .icon-search,
.button-item .text-search{
    font-size: 16px !important;
}
.mainSearch__submit{
    height: 33px !important;
}
.button-item{
    bottom: -12px !important;
    left: 37% !important;
}

.render{
    font-size: 16px !important,
}
.js-first-date{
    font-size: 16px !important;
}
.js-last-date{
    font-size: 16px !important;
}
.adults span{
    font-size: 16px !important;
}
.children span{
    font-size: 16px !important;
}

.bravo_wrap .gotrip_form_search .field-items {
    margin: 0 !important;
    padding: 0 !important;
}


}

@media (max-width:426px) {
    .button-item{
    left: 33% !important;
}
        }

        @media (max-width:376px) {
            .button-item{
    left: 31% !important;
}
        }

        @media (max-width:321px) {
            .button-item{
    left: 28% !important;
}
        }


      
</Style>











<h3 class="hotel-heading d-block" style="margin-bottom: 4px;" >Book Hotels & Homestays In India</h3>
    <div class="field-items">
        <div class="row w-100 m-0"  style="margin-top:10px; color: var(--color-dark-1); border: 1px solid rgb(196, 196, 196); border-radius: 10px;">
            @if(!empty($hotel_search_fields))
                @foreach($hotel_search_fields as $field)
                    <div class="col-lg-{{ $field['size'] ?? "6" }} align-self-start px-30 lg:py-20 lg:px-0">
                        @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                        @switch($field['field'])
                            @case ('service_name') @include('Layout::common.search.fields.service_name') @break
                            @case ('location') @include('Layout::common.search.fields.location') @break
                            @case ('date')@include('Layout::common.search.fields.date' ,[
                                'index' => 0
                            ]) @break
                            @case ('attr') @include('Layout::common.search.fields.attr') @break
                            @case ('guests') @include('Layout::common.search.fields.guests') @break
                        @endswitch
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="button-item">
        <button class="mainSearch__submit button {{ $button_classes }}" type="submit">
            <i class="icon-search text-20 mr-10"></i>
            <span class="text-search">{{__("SEARCH")}}</span>
        </button>
    </div>
</form>
