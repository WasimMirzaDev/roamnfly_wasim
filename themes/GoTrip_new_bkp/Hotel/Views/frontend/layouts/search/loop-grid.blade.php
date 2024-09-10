<!--@php-->
<!--    $translation = $row->translate();-->
<!--@endphp-->
<div class="hotelsCard -type-1 item-loop {{$wrap_class ?? ''}}">
    <div class="hotelsCard__image">
        <div class="cardImage ratio ratio-1:1">
            <a @if(!empty($blank)) target="_blank" @endif href="{{ \Modules\Hotel\Services\HotelService::getDetailUrl($row['id']) }}">
                <div class="cardImage__content">
                        @if(isset($row['img'][0]['url']))
                            {{-- @if(!empty($disable_lazyload)) --}}
                                <img  src="{{$row['img'][0]['url'] ?? ''}}" class="rounded-4 col-12 js-lazy" alt="{{ $translation->title ?? 'image' }}">
                            {{-- @else
                                {!! get_image_tag($row['img'][0]['url'],'medium',['class'=>'rounded-4 col-12 js-lazy','alt'=>$translation->title ?? 'image']) !!}
                            @endif --}}
                        @endif
                </div>
            </a>
            <div class="service-wishlist" data-id="{{ $row['id']}}" data-type="{{ $row['pt'] }}">
                <div class="cardImage__wishlist">
                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                        <i class="icon-heart text-12"></i>
                    </button>
                </div>
            </div>
            <div class="cardImage__leftBadge">
            </div>
        </div>
    </div>
    <div class="hotelsCard__content mt-10">
        <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
            <a class="text-dark-1-i" href="{{ \Modules\Hotel\Services\HotelService::getDetailUrl($row['id']) ?? '' }}"> <span>{{  $row['name'] ?? '' }}</span></a>
        </h4>
        @if(!empty($row['ad']['adr']))
            @php $location =  $row['ad']['adr'] @endphp
            <p class="text-light-1 lh-14 text-14 mt-5">{{$location}}</p>
        @endif
            
        <div class="mt-5">
            <div class="fw-500">
                {{ __('Starting from') }}
                <div class="d-inline-flex justify-content-md-end align-baseline">
                    <div class="text-16 text-red-1 line-through mr-5"></div>
                    <div class="text-22 lh-12 fw-600 text-blue-1">{{ format_money($row['ops']['0']['ris'][0]['pis'][0]['fc']['TF'] ?? 0 ) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
