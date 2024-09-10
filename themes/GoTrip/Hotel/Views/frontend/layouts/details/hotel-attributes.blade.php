@php
    $attributes = $row['pt'];
@endphp
@if(!empty($attributes))
    <div class="g-attributes pb-30">
        <h3 class="text-22 fw-500 pt-40 border-top-light mb-20">Property Type</h3>
        <div class="list-attributes d-flex flex-wrap">
            <div class="item ">
                {{-- @if(!empty($term->image_id))
                    @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                    <img src="{{$image_url}}" class="img-responsive" alt="{{$translate_term->name}}">
                @else --}}
                    <i class="icon-check text-blue-1"></i>
                {{-- @endif --}}
                {{ucwords(strtolower($attributes))}}
            </div>
        </div>
    </div>
@endif

@php
    $attributes = $row['fl'];
@endphp
@if(!empty($attributes))
    <div class="g-attributes pb-30">
        <h3 class="text-22 fw-500 pt-40 border-top-light mb-20">Facilities / Hotel Service </h3>
        <div class="list-attributes d-flex flex-wrap">
            @foreach($attributes as $term )
                <div class="item ">
                    {{-- @if(!empty($term->image_id))
                        @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                        <img src="{{$image_url}}" class="img-responsive" alt="{{$translate_term->name}}">
                    @else --}}
                        <i class="icon-check text-blue-1"></i>
                    {{-- @endif --}}
                    {{$term}}
                </div>
            @endforeach
        </div>
    </div>
@endif
<div class="border-bottom-light"></div>
