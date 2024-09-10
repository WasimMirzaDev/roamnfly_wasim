@php
    // Extract values from the URL or set default values
    $adults = request()->query('seat_type')['adults'] ?? 1;
    $children = request()->query('seat_type')['children'] ?? 0;
    $infants = request()->query('seat_type')['infants'] ?? 0;
    $room = request()->query('room', 1); // Default to 1 if not present
@endphp

<div class="searchMenu-guests form-select-guests js-form-dd item">

    <div data-x-dd-click="searchMenu-guests">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>

        <div class="text-15 text-light-1 ls-2 lh-16">
            <div class="render">
                <span class="adults">
                    <span class="one @if($adults > 1) d-none @endif">{{ __('1 Adult') }}</span>
                    <span class="multi @if($adults <= 1) d-none @endif" data-html="{{ __(':count Adults') }}">{{ __(':count Adults', ['count' => $adults]) }}</span>
                </span>
                -
                <span class="children">
                    <span class="one @if($children > 1) d-none @endif" data-html="{{ __(':count Child') }}">{{ __(':count Child', ['count' => $children]) }}</span>
                    <span class="multi @if($children <= 1) d-none @endif" data-html="{{ __(':count Children') }}">{{ __(':count Children', ['count' => $children]) }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="searchMenu-guests__field select-guests-dropdown shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
        <div class="bg-white px-30 py-30 rounded-4">
            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500 text-black">{{ __('Rooms') }}</div>
                </div>

                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="room"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input type="number" name="room" value="{{ $room }}" min="1">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="room"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <div class="border-top-light mt-24 mb-24"></div>

            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500 text-black">{{ __('Adults') }}</div>
                </div>

                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="adults"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input type="number" name="adults" value="{{ $adults }}" min="1">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="adults"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <div class="border-top-light mt-24 mb-24"></div>

            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500 text-black">{{ __('Children') }}</div>
                </div>

                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="children"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input type="number" name="children" value="{{ $children }}" min="0">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="children"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
