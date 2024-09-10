@php
    $style = $style ?? 'default';
    $classes = ' form-search-all-service mainSearch -col-5 border-light rounded-4 pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 mt-15';
    $button_classes = " -dark-1 py-15 col-12 bg-blue-1 text-white w-100 rounded-4";
    if($style == 'sidebar'){
        $classes = ' form-search-sidebar';
        $button_classes = " -dark-1 py-15 col-12 bg-blue-1 h-60 text-white w-100 rounded-4";
    }
    if($style == 'normal'){
        $classes = ' px-20 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-100 form-search-all-service mainSearch -w-900 bg-white';
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
    if($style == 'flightCarousel'){
        $classes = " w-100";
        $button_classes = " -dark-1 py-15 col-12 bg-blue-1 h-60 text-white w-100 rounded-4";
    }
@endphp

<Style>
.bravo_wrap .form-search-all-service .tabs__pane.-tab-item-flight .bravo_form  {
    max-width: 100% !important;
    width: 100%;
}
    .gotrip_form_search {
    padding: 6rem 0 !important;
display: block !important;
height: auto !important;
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
font-size: 22px !important; 
}
.bravo_wrap .gotrip_form_search .field-items > .row > div{
padding: 27px 30px 0 !important;
height: 100% !important;

}
.field-items {
height: 120px !important;
}
.field-items h4{
font-size: 17px !important;
}

</Style>

<form action="{{ route("flight.search") }}" class="gotrip_form_search bravo_form_search bravo_form form {{ $classes }}" style="width:100% !important;" method="get">
    @php $flight_search_fields = setting_item_array('flight_search_fields');
            $flight_search_fields = array_values(\Illuminate\Support\Arr::sort($flight_search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
    @endphp
    <div class="field-items d-block">
        @if(!empty($flight_search_fields))
            <div class="row w-100 m-0" style="color: orange; border: 1px solid rgb(196, 196, 196); border-radius: 10px;">
                @foreach($flight_search_fields as $field)
                    <div class="col-lg-{{ $field['size'] ?? "6" }} align-self-center px-10 lg:py-5 lg:px-0">
                        @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                        @switch($field['field'])
                            @case ('date') @include('Layout::common.search.fields.date') @break
                            @case ('seat_type') @include('Layout::common.search.fields.seat_type') @break
                            @case ('from_where') @include('Layout::common.search.fields.airport',['inputName'=>'from_where']) @break
                            @case ('to_where') @include('Layout::common.search.fields.airport',['inputName'=>'to_where']) @break
                            @case ('type') @include('Layout::common.search.fields.customAttr',['attr'=>'travel-type','inputName' => 'travel_type']) @break
                        @endswitch
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="button-item">
        <button class="mainSearch__submit button {{ $button_classes }}" type="submit" >
            <i class="icon-search text-20 mr-10"></i>
            <span class="text-search">{{__("Search")}}</span>
        </button>
    </div>
</form>
