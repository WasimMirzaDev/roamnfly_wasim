<div class="bravo-list-item">
    <div class="row y-gap-10 justify-between items-center">
        <div class="col-auto">
            <div class="text-18">
                <span class="fw-500 result-count">
                    @if($rows->total() > 1)
                        {{ __(":count flights found",['count'=>$rows->total()]) }}
                    @else
                        {{ __(":count flight found",['count'=>$rows->total()]) }}
                    @endif
                </span>
            </div>
        </div>

        {{-- <div class="col-auto bc-form-order">
            @include('Layout::global.search.orderby',['routeName'=>'flight.search','hidden_map_button'=>1])
        </div> --}}
    </div>
    <style>

.row-for-d-no{
display: none !important;
.has-skeleton,
.content-wrapper{
    flex-shrink: 0;
}
.select-btn-wrapper{
    display: contents;
}
}

@media (max-width: 1201px) {
.row-for-d-no{
    display: inline-block !important;
}
.row-for-d-flex{
display: none !important;
}
.div-for-select-btn{
    display: flex !important;
}
}

@media (max-width: 551px) {
.has-skeleton-image-wrapper{
    width: 30px !important;
    height: 30px !important;
}
.has-skeleton-content-wrapper{
    line-height: normal !important;
    .h3-heading{
        font-size: 14px !important;
    }
    & span{
        font-size: 12px !important;
    }
} 
.div-for-select-btn{
.text-upper{
    font-size: 14px !important;
}
.text-lower{
    font-size: 12px !important;
}
}
.accordion__button{
    & a{
        height: 40px !important;
        padding: 20px !important;
    }
}
.bar-js{
    display: none !important;
}
}

@media (max-width: 450px) {
.wrapper-for-profile{
    flex-direction: column !important;
}
.div-for-select-btn{
    flex-direction: column !important;
    align-items: end !important;
}
.content-wrapper{
    margin: 15px 0 0 25px !important;
    .h3-heading{
        white-space: nowrap; 
  overflow: hidden;  
  text-overflow: ellipsis;
  width: 100%;  
    }
}



}
</style>
    <div class="ajax-search-result" id="flightFormBook">
        @include('Flight::frontend.ajax.search-result',[ 'type'=> 'return'])
    </div>

</div>
