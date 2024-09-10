<div class="bravo-list-item">
    <div class="row y-gap-10 justify-between items-center">
        <div class="col-auto">
            <div class="text-18">
            </div>
        </div>

        <div class="col-auto bc-form-order">
            @include('Layout::global.search.orderby',['routeName'=>'flight.search','hidden_map_button'=>1])
        </div>
    </div>

    <div class="ajax-search-result" id="flightFormBook">
        @include('Flight::frontend.ajax.multi-search-result',['type'=> 'Multi'])
    </div>

</div>
