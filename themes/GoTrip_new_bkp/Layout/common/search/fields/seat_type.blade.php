@php
    $minValue = 0;
    $seatTypeGet = request()->query('seat_type', []);
    $adults = $seatTypeGet['adults'] ?? 1; // Default to 1 adult
    $children = $seatTypeGet['children'] ?? $minValue;
    $infants = $seatTypeGet['infants'] ?? $minValue;
    $seatClass = $seatTypeGet['class'] ?? 'Economy'; // Default to 'Economy' if no seat class is set
@endphp

<div class="clicked-class searchMenu-guests js-form-dd form-select-seat-type item">
    <div data-x-dd-click="searchMenu-guests" class="overflow-hidden seat-input">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>

        <div class="text-15 text-light-1 ls-2 lh-16">
            <div class="render text-13" id="renderTravellerCount">
                @foreach($seatType as $type)
                {{ $seatClass == $type->name || $seatClass == $type->code ? $type->name : ''}}
                @endforeach
                {{ $adults }} Adults {{ $children }} Child {{ $infants }} Infant
            </div>
        </div>
    </div>
    <div class="searchMenu-guests__field select-seat-type-dropdown shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
        <div class="bg-white px-30 py-30 rounded-4 last-tab">
            <!-- Adults -->
            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500">{{ __('Adults') }}</div>
                </div>
                @php
                    $inputName = 'seat_type_adults';
                    $inputValue = $adults;
                @endphp
                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus resetCountTravellers" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input class="countTravellers adult" id="{{$inputName}}" type="number" name="seat_type[adults]" value="{{$inputValue}}" min="{{$minValue}}">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add resetCountTravellers" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <!-- Children -->
            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500">{{ __('Children') }}</div>
                </div>
                @php
                    $inputName = 'seat_type_children';
                    $inputValue = $children;
                @endphp
                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus resetCountTravellers" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input class="countTravellers children" id="{{$inputName}}" type="number" name="seat_type[children]" value="{{$inputValue}}" min="{{$minValue}}">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add resetCountTravellers" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <!-- Infants -->
            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500">{{ __('Infants') }}</div>
                </div>
                @php
                    $inputName = 'seat_type_infants';
                    $inputValue = $infants;
                @endphp
                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus resetCountTravellers" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input class="countTravellers infant" id="{{$inputName}}" type="number" name="seat_type[infants]" value="{{$inputValue}}" min="{{$minValue}}">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add resetCountTravellers" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <!-- Seat Type -->
            <div class="row y-gap-10">
                @foreach($seatType as $type)
                    @php
                        $inputName = 'seat_type_'.$type->code;
                        $inputValue = $seatTypeGet[$type->code] ?? $minValue;
                    @endphp

                    <div class="col-1">
                        <input style="width:auto;" data-name="{{ __($type->name) }}" class="form-check-input countTravellers class" type="radio" name="seat_type[class]" value="{{$type->code}}" id="seatType{{$type->code}}" {{ $seatClass == $type->name || $seatClass == $type->code ? 'checked' : '' }}>
                    </div>
<div class="{{ Request::url() == 'http://localhost:8000/flight' ? 'col-4' : 'col-5' }}">
    <label class="form-check-label" for="seatType{{$type->code}}">
        {{ __($type->name) }}
    </label>
</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
