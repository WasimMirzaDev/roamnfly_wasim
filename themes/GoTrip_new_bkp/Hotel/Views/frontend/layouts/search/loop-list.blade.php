{{-- @php
    $translation = $row->translate();
@endphp --}}
<div class="row x-gap-20 px-10 py-10 bg-white y-gap-20 {{$wrap_class ?? ''}}">
    <div class="col-md-auto">
        <div class="has-skeleton">
            <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                <div class="cardImage__content">
                    <a href="{{ \Modules\Hotel\Services\HotelService::getDetailUrl($row['id']) }}">
                        @if(isset($row['img'][0]['url']))
                            {{-- @if(!empty($disable_lazyload)) --}}
                                <img  src="{{$row['img'][0]['url'] ?? ''}}" class="rounded-4 col-12 js-lazy" alt="{{ $translation->title ?? 'image' }}">
                            {{-- @else
                                {!! get_image_tag($row['img'][0]['url'],'medium',['class'=>'rounded-4 col-12 js-lazy','alt'=>$translation->title ?? 'image']) !!}
                            @endif --}}
                        @endif
                    </a>
                </div>
                <div class="service-wishlist" data-id="{{ $row['id'] }}" data-type="{{ $row['pt'] }}">
                    <div class="cardImage__wishlist">
                        <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                            <i class="icon-heart text-12"></i>
                        </button>
                    </div>
                </div>
                <div class="cardImage__leftBadge">
                    {{-- @if($row->is_featured == "1") --}}
                        {{-- <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                            {{__("Featured")}}
                        </div> --}}
                    {{-- @endif --}}
                    {{-- @if($row->discount_percent)
                        <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-blue-1 text-white mt-5">
                            {{__("Sale off :number",['number'=>$row->discount_percent])}}
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="d-flex flex-column h-full justify-between">
            <div class="has-skeleton">
                @if(!empty($row['ad']['adr']))
                    @php $location =  $row['ad']['adr'] @endphp
                @endif
                <h3 class="text-18 lh-16 fw-500">
                    <a href="{{ \Modules\Hotel\Services\HotelService::getDetailUrl($row['id']) }}">{{  $row['name'] }}</a>
                    @if(isset($row['rt']))
                        <div class="star-rate d-inline-block ml-10">
                            @for ($star = 1 ;$star <= $row['rt'] ; $star++)
                                <i class="icon-star text-10 text-yellow-2"></i>
                            @endfor
                        </div>
                    @endif
                </h3>
                @if(!empty($location))
                    <p class="text-14 lh-14 mb-5">{{ $location }}</p>
                @endif
                @if(!empty($row['fl']))
                    <div class="terms">
                        <div class="g-attributes">
                            <span class="attr-title"><i class="icofont-medal"></i> Facilities: </span>
                            @foreach($row['fl'] as $term )
                                <span class="item {{$term}} term-{{$term}}">{{$term}}</span>
                                @if ($loop->iteration > 5)
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @if(!empty($row['fl']))
                <div class="row x-gap-10 y-gap-10 pt-20">
                    @php
                        $i=0;
                    @endphp
                    @foreach($row['fl'] as $term)
                        @if (strlen($term) < 22 && $loop->iteration > 6)
                            @php
                                $i++;
                            @endphp
                            <div class="col-auto">
                                <div class="has-skeleton border-light rounded-100 py-5 px-20 text-14 lh-14">{{ $term }}</div>
                            </div>
                            @if ($i == 4)
                                @break
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-auto text-right md:text-left">
        <div class="has-skeleton">
            {{-- @if(setting_item('space_enable_review'))
                <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
                <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                    <div class="col-auto">
                        <div class="text-14 lh-14 fw-500">{{ $reviewData['review_text'] }}</div>
                        <div class="text-14 lh-14 text-light-1">@if($reviewData['total_review'] > 1)
                                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">{{ $reviewData['score_total'] }}</div>
                    </div>
                </div>
            @endif --}}
            <div class="text-14 text-light-1 mt-40 md:mt-20">{{__('From')}}</div>
            <div class="d-flex justify-content-md-end align-baseline mt-5">
                <div class="text-16 text-red-1 line-through mr-5"></div>
                <div class="text-22 lh-12 fw-600">{{ format_money($row['ops']['0']['ris'][0]['pis'][0]['fc']['TF'] ?? 0 ) }}</div>
            </div>
            <div class="text-14 text-light-1 mt-5">{{ __('/night') }}</div>
            <a href="{{ \Modules\Hotel\Services\HotelService::getDetailUrl($row['id']) }}" class="button -md -dark-1 bg-blue-1 text-white mt-24">
                {{ __('See Availability') }} <div class="icon-arrow-top-right ml-15"></div>
            </a>
        </div>
    </div>
</div>
