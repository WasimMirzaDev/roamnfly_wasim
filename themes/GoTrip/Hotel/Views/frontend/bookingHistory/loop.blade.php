<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .header-content-main-wrapperh-hotel{
        /* border: 1px solid black; */
        box-shadow: 0 0 5px 2px rgb(181 181 181 / 61%);
        margin: 25px 0;
        .header-wrapper-hotel{
            /* border-bottom: 1px solid black; */
            box-shadow:0 5px 5px  rgb(181 181 181 / 61%);
            padding: 10px 35px;
        }
        .content-wrapper-hotel{
            padding: 35px 35px;
        }
        .icon-wrap{
            border-radius: 50%;
            box-shadow: 0 0 5px 2px rgb(181 181 181 / 61%);
position: absolute;
left: 3px ;
        padding: 7px;
        background: white;

        }
    }
    .for-mobile{
    display: none;
}
    @media (max-width: 991px){
        .px-30 {
    padding-left: 10px !important;
    padding-right: 10px !important;
}  
.for-web{
    display: none;
}
.for-mobile{
    display: block !important;
    .header-wrapper-hotel{
        flex-direction: column !important;
        padding: 5px 5px 5px 27px !important;
    }
}
.content-wrapper-hotel{
    flex-direction: column !important;
    padding: 20px 15px !important
}
.content-small-wrapper{
    & div{
        width: 50% !important;
    }
}
    }
</style>

<div class="header-content-main-wrapperh-hotel for-web">
<div class="header-wrapper-hotel d-flex  justify-content-between align-items-center">
<div class="icon-wrap">
<i class="fa-solid fa-hotel"></i>
</div>
  <div>
        @if($service = $booking->service ?? $booking->object_model)
            @if ($service == 'hotel')
                
                    {{ $booking->title }}
                
            @else
                @php
                    $divanslation = $service->divanslate();
                @endphp
                
                    {{$divanslation->title}}
                
            @endif
        @else
            {{__("[Deleted]")}}
        @endif
        <div class="header-bottom-row">
        <strong>BookingID - </strong><span>{{$booking->code}}</span>
  



        </div>
    </div>
    <div class="fw-500">{{format_money_main($booking->total)}}</div>
    <!-- <div>{{format_money($booking->paid)}}</div>
    <div>{{format_money($booking->total - $booking->paid)}}</div> -->
    <div>
        <div class="dropdown js-dropdown js-actions-1-active">
            <div class="dropdown__button d-flex items-center rounded-4 text-blue-1 bg-blue-1-05 text-14 px-15 py-5" data-el-toggle=".js-actions-{{ $key + 1 }}-toggle" data-el-toggle-active=".js-actions-{{ $key + 1 }}-active">
                <span class="js-dropdown-title">{{ __("Actions") }}</span>
                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
            </div>

            <div class="toggle-element -dropdown-2 js-click-dropdown js-actions-{{ $key + 1 }}-toggle">
                <div class="text-14 fw-500 js-dropdown-list">
                    @if($service = $booking->service)
                        <div><a href="#" class="d-block js-dropdown-link btn-info-booking" data-ajax="{{route('booking.modal',['booking'=>$booking])}}" data-toggle="modal" data-id="{{$booking->id}}" data-target="#modal_booking_detail">{{ __("Details") }}</a></div>
                    @endif

                    <div><a href="{{route('user.booking.invoice',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking open-new-window" onclick="window.open(this.href); return false;">{{ __("Invoice") }}</a></div>

                    @if($booking->status == 'unpaid')
                        <a href="{{route('booking.checkout',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking " onclick="window.location.href = this.getAdivivibute('href')">
                            {{__("Pay now")}}
                        </a>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>
<div class="content-wrapper-hotel d-flex justify-content-between">

<div>
{{__("Check in")}} 
<br>
 {{display_date($booking->start_date)}} <br>
</div>
<div>
{{__("Check out")}} 
<br>
 {{display_date($booking->end_date)}} <br>
</div>
<div>
{{__("Duration")}} 
<br>
@if($booking->duration_nights <= 1)
    {{__(':count night',['count'=>$booking->duration_nights])}}
@else
    {{__(':count nights',['count'=>$booking->duration_nights])}}
@endif
</div>

<!-- <div>
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        {{$booking->object_model}}
    </div> -->
  
    <div>
    <span>
        Order Date
    </span>
    <br>
     {{display_date($booking->created_at)}}
    </div>
    
       
    
   <div class="status-div">
    <span>
        Status
    </span>
    <br>
   <div class="{{$booking->status}}">
        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500">{{$booking->statusName}}</span>
    </div>
   </div>

   
</div>
   
</div>
<div class="header-content-main-wrapperh-hotel for-mobile">
<div class="header-wrapper-hotel d-flex  justify-content-between ">
<div class="icon-wrap">
<i class="fa-solid fa-hotel"></i>
</div>
  <div>
        @if($service = $booking->service ?? $booking->object_model)
            @if ($service == 'hotel')
                
                    {{ $booking->title }}
                
            @else
                @php
                    $divanslation = $service->divanslate();
                @endphp
                
                    {{$divanslation->title}}
                
            @endif
        @else
            {{__("[Deleted]")}}
        @endif
        <div class="header-bottom-row">
        <strong class>BookingID - </strong><span>{{$booking->code}}</span>
  



        </div>
    </div>
   <div class="btn-wrapper d-flex justify-content-between w-100">
   <div class="fw-500">{{format_money_main($booking->total)}}</div>
    <!-- <div>{{format_money($booking->paid)}}</div>
    <div>{{format_money($booking->total - $booking->paid)}}</div> -->
    <div>
        <div class="dropdown js-dropdown js-actions-1-active">
            <div class="dropdown__button d-flex items-center rounded-4 text-blue-1 bg-blue-1-05 text-14 px-15 py-5" data-el-toggle=".js-actions-{{ $key + 1 }}-toggle" data-el-toggle-active=".js-actions-{{ $key + 1 }}-active">
                <span class="js-dropdown-title">{{ __("Actions") }}</span>
                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
            </div>

            <div class="toggle-element -dropdown-2 js-click-dropdown js-actions-{{ $key + 1 }}-toggle">
                <div class="text-14 fw-500 js-dropdown-list">
                    @if($service = $booking->service)
                        <div><a href="#" class="d-block js-dropdown-link btn-info-booking" data-ajax="{{route('booking.modal',['booking'=>$booking])}}" data-toggle="modal" data-id="{{$booking->id}}" data-target="#modal_booking_detail">{{ __("Details") }}</a></div>
                    @endif

                    <div><a href="{{route('user.booking.invoice',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking open-new-window" onclick="window.open(this.href); return false;">{{ __("Invoice") }}</a></div>

                    @if($booking->status == 'unpaid')
                        <a href="{{route('booking.checkout',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking " onclick="window.location.href = this.getAdivivibute('href')">
                            {{__("Pay now")}}
                        </a>
                    @endif

                </div>
            </div>
        </div>

    </div>
   </div>
</div>
<div class="content-wrapper-hotel d-flex justify-content-between">
<div class="content-small-wrapper d-flex justify-content-between ">
<div>
{{__("Check in")}} 
<br>
 {{display_date($booking->start_date)}} <br>
</div>
<div>
{{__("Check out")}} 
<br>
 {{display_date($booking->end_date)}} <br>
</div>
</div>
<div class="content-small-wrapper d-flex justify-content-between">
<div>
{{__("Duration")}} 
<br>
@if($booking->duration_nights <= 1)
    {{__(':count night',['count'=>$booking->duration_nights])}}
@else
    {{__(':count nights',['count'=>$booking->duration_nights])}}
@endif
</div>

<!-- <div>
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        {{$booking->object_model}}
    </div> -->
  
    <div>
    <span>
        Order Date
    </span>
    <br>
     {{display_date($booking->created_at)}}
    </div>
</div>

    
       
    
   <div class="status-div">
    <span>
        Status
    </span>

   <div class="{{$booking->status}}">
        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500">{{$booking->statusName}}</span>
    </div>
   </div>

   
</div>
   
</div>
