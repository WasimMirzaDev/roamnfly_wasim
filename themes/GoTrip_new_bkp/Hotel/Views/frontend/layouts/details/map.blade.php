@if(!empty($row['ad']['adr']))
    <section class="pb-40">
        <div class="{{ $class_container ?? "container" }}">
            <h3 class="text-22 fw-500 mb-10">{{ __('Where you’ll be') }}</h3>
            <div class="mb-20">{{$row['ad']['adr'] ?? ''}}</div>
            @if($row['gl']['lt'] && $row['gl']['ln'])
                <div class="g-location">
                    <div class="location-map">
                        <div id="map_content" class="map rounded-4 map-500"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif
