

<style>
    .flight-info-box {
        position: fixed;
        bottom: 0;
        /* left: 0; */
        /* max-width: 1140px; */
        margin: 0 auto;
        width: 100%;
        /* max-height: 300px; */
        overflow-y: hidden;
        /* overflow-x: hidden; */
        /* background-color: #333; */
        color: white;
        padding: 5px;
        /* text-align: center; */
        /* box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3); */
  
    }
    
    .flight-info {
        justify-content: space-between;
 min-width:  670px;
 width: 100%;
 display: flex;
 align-items: center;
        font-size: 16px;
        margin: 0 15px 10px;
        padding: 10px;
    }
    
    .flight-info span {
        margin: 0 10px;
    }
    
    .three-way-select {
    overflow-y: hidden;
    overflow-x: auto;
    scrollbar-width: thin; /* For Firefox */
    scrollbar-color:  rgb(255, 145, 0) #f1f1f1; /* For Firefox */
}


.three-way-select::-webkit-scrollbar{
    width: 10px;
}
.three-way-select::-webkit-scrollbar-track{
    background-color: transparent;
}
.three-way-select::-webkit-scrollbar-thumb{
    background-color: rgb(255, 145, 0);
    border-radius: 10px;
    border: 2px solid transparent;
    background-clip: content-box;
}
.three-way-select::-webkit-scrollbar-thumb:hover{
    background-color: bisque;
}
    </style>


<div id="flightFormSelectModalMulti" class="fade"> 
    
    <d class="flight-info-box d-flex justify-content-between" style="  background: #f8f8f8; color:rgb(0, 0, 0); box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3); ">
    
        

         <div class="three-way-select d-flex justify-content-start align-itmes-start">
            <div class="flight-info mt-2" v-for="(ONEflight, index) in flights" :key="index" style="   height: 70px; font-size: 13px; background-color: #eeeeee;">
                <div class="d-flex align-items-start flex-column">
                    {{-- <img v-if="ONEflight.code" :src="getAssetUrl(ONEflight.logo)" class="img-fluid mr-10" alt="Image-Description"> --}}
                    <img v-if="ONEflight.code" style="margin-left:5px;" width="30px" src="{{ asset('images/a.png') }}" class="img-fluid mr-10" alt="Image-Description">
                    <div class="text-14">@{{ONEflight.title}} | @{{ONEflight.code}}</div>
                </div>
                <div class="d-flex align-items-start">
   
                    <div class="text-left">
                      <div class="date-time d-flex align-itmes-end">
                        <h6 class="fw-500 text-18 text-gray-5 mb-0" style="margin:0px 10px;" v-html="ONEflight.departure_time_html"></h6>
                        <div class="text-12 text-gray-5" style="margin:0px 10px;" v-html="ONEflight.departure_date_html"></div>
                      </div>
                        <span class="text-11 text-gray-1" v-html="ONEflight.airport_from"></span>
                    </div>
                </div>
                <div class="mx-2 d-flex">
   
                    <div class="text-left">
                        <div class="date-time d-flex align-itmes-end">
                            
                            <h6 class="fw-500 text-18 text-gray-5 mb-0" style="margin:0px 10px;" v-html="ONEflight.arrival_time_html"></h6>
                            <div class="text-12 text-gray-5" style="margin:0px 10px;" v-html="ONEflight.arrival_date_html"></div>
                        </div>
                            <span class="text-11 text-gray-1" v-html="ONEflight.airport_to"></span>
                    </div>
                </div>
                <ul class="d-flex justify-content-between list-group list-group-borderless list-group-horizontal list-group-flush no-gutters border-bottom-light " v-for="(flight_seat,key) in ONEflight.flight_seat" :key="key" v-if="flight_seat.max_passengers > 0">
                    <li id="infant-price-item" class="mb-3 mt-3 justify-content-between list-group-item py-0 border-0" >
                        <div class="fw-500 text-dark">{{__('Flight Price')}}</div>
                        <span id="infant-price" class="text-gray-1" v-html="each_price(index)"></span>
                    </li>
                </ul>
            </div>
         </div>
         <div class="button-div">
            <ul class="list-unstyled font-size-1 mb-0 font-size-16">
                {{-- <li class="d-flex justify-content-between py-2">
                    <span class="fw-500">{{__('Pay Amount')}}</span>
                    <span class="fw-500" v-html="total_price_html"></span>
                </li> --}}
                <li class="d-flex justify-content-center py-2 font-size-17 font-weight-bold">
                    <a @click="MultiflightCheckOut()" class="button h-60 px-24 -dark-1 bg-blue-1 text-white" style="    white-space: nowrap;
    margin-left: 30px;">
                        {{__('Book Now')}}
                        {{-- <div class="icon-arrow-top-right ml-15"></div> --}}
                        <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                    </a>
                </li>
            </ul>
         </div>

     
    </div>
   
</div>

