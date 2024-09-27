<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .header-content-main-wrapper{
        /* border: 1px solid black; */
        box-shadow: 0 0 5px 2px rgb(181 181 181 / 61%);
        margin: 25px 0;
        .header-wrapper{
            /* border-bottom: 1px solid black; */
            box-shadow:0 5px 5px  rgb(181 181 181 / 61%);
            padding: 10px 35px;
        }
        .content-wrapper{
            padding: 50px 35px;
        }
        .icon-wrap{
            border-radius: 50%;
            box-shadow: 0 0 5px 2px rgb(181 181 181 / 61%);
position: absolute;
left: 3px ;
        padding: 7px;
        background: white;

        }

.header-bottom-row{
    & strong{
font-weight: 500;
    }

    & span{
        font-size: 12px;
    }
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
    .header-wrapper{
        flex-direction: column !important;
        padding: 5px 5px 5px 27px !important;
    }
}
.content-wrapper{
    flex-direction: column !important;
    padding: 20px 15px !important
}
.content-small-wrapper{
    padding-bottom: 20px;
    & div{
        width: 50% !important;
    }
}
    }
   
</style>
<div class="header-content-main-wrapper for-web">
<div class="header-wrapper d-flex  justify-content-between align-items-center">
<div class="icon-wrap">
<i class="fa-solid fa-plane-departure"></i>
</div>
    <div class="ab">
        {{-- @if($service = $booking->service) --}}
            {!! clean($booking->title) !!}
            {{-- ({!! clean($service->code) !!}) --}}
        {{-- @else
            {{__("[Deleted]")}}
        @endif --}}
        <div class="header-bottom-row">
            @if ($booking->travel_type == "One Way")
            <div><strong class="d-">One way . </strong><Span>BookingID-{{$booking->code}} </Span></div>
            @elseif($booking->travel_type == "Round Trip")
            <div><strong class="d-">Round Trip . </strong><Span>BookingID-{{$booking->code}} </Span></div>
            @else
            <div><strong class="d-">Multicity . </strong><Span>BookingID-{{$booking->code}} </Span></div>
            @endif
        </div>
    </div>
    <div class="fw-500 a1">{{format_money($booking->total)}}</div>
    <!-- <div class="a2">{{format_money($booking->paid)}}</div>
    <div class="ab1">{{format_money($booking->total - $booking->paid)}}</div> -->
    <div class="ab12">
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
                        <a href="{{route('booking.checkout',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking" onclick="window.location.href = this.getAdivivibute('href')">
                            {{__("Pay now")}}
                        </a>
                    @endif

                </div>
            </div>
        </div>
    

       

    </div>
</div>
<?php 
$flightData = json_decode($booking->flightData, true);
?>
<div class="content-wrapper d-flex justify-content-between">
   <div class="from-wrapper">
   <div>
        {{__("From")}} 
        <br>
         {{display_datetime($booking->start_date)}} <br>
    </div>
    <div class="from-country">
        {{-- {{$booking->travel_type}} --}}
        @if ($booking->travel_type == "One Way")
        {{$flightData['airport_from'] ?? ''}}
        @else
        @foreach ($flightData as $item)
        {{$flightData['airport_from'] ?? ''}}
        @endforeach
        @endif
    </div>
   </div>
   <div class="to-wrapper">
   <div>
        {{__("To ")}} 
        <br>
         {{display_datetime($booking->end_date)}} <br>
    </div>
    <div class="to-country">
        @if ($booking->travel_type == "One Way")
        {{$flightData['airport_to'] ?? ''}}
        @else
        @foreach ($flightData as $item)
        {{$flightData['airport_to'] ?? ''}}
        @endforeach
        @endif
    </div>
   </div>
    <div>
        {{__("Duration")}} 
        <br>
         {{__(':duration hrs',['duration'=> @$booking->service->duration])}}
    </div>

<!-- 
    <div class="a">
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        {{$booking->object_model}}
    </div> -->
  
    <div class="abc">
        <span>
            Oder Date
        </span>
        <br>

    {{display_date($booking->created_at)}}
</div>
   
   <div class="status-div">
<span>Staus</span>
<br>
<div class="{{$booking->status}} ab2">
        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500">{{$booking->statusName}}</span>
    </div>
   </div>

 
</div>

</div>
<div class="header-content-main-wrapper for-mobile">
<div class="header-wrapper d-flex  justify-content-between ">
<div class="icon-wrap">
<i class="fa-solid fa-plane-departure"></i>
</div>
    <div class="ab">
        {{-- @if($service = $booking->service) --}}
            {!! clean($booking->title) !!}
            {{-- ({!! clean($service->code) !!}) --}}
        {{-- @else
            {{__("[Deleted]")}}
        @endif --}}
        <div class="header-bottom-row">
            @if ($booking->travel_type == "One Way")
            <div><strong class="d-">One way . </strong><Span>BookingID-{{$booking->code}} </Span></div>
            @elseif($booking->travel_type == "Round Trip")
            <div><strong class="d-">Round Trip . </strong><Span>BookingID-{{$booking->code}} </Span></div>
            @else
            <div><strong class="d-">Multicity . </strong><Span>BookingID-{{$booking->code}} </Span></div>
            @endif
        </div>
    </div>
    <div class="btn-wrapper d-flex justify-content-between w-100">
    <div class="fw-500 a1">{{format_money($booking->total)}}</div>
    <!-- <div class="a2">{{format_money($booking->paid)}}</div>
    <div class="ab1">{{format_money($booking->total - $booking->paid)}}</div> -->
    <div class="ab12">
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
                        <a href="{{route('booking.checkout',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking" onclick="window.location.href = this.getAdivivibute('href')">
                            {{__("Pay now")}}
                        </a>
                    @endif

                </div>
            </div>
        </div>
    

       

    </div>
    </div>
  
</div>
<div class="content-wrapper d-flex justify-content-between">
    <div class="content-small-wrapper d-flex justify-content-between">
    <div class="from-wrapper">
   <div>
        {{__("From")}} 
        <br>
         {{display_datetime($booking->start_date)}} <br>
    </div>
    <div class="from-country">
Dubai
    </div>
   </div>
   <div class="to-wrapper">
   <div>
        {{__("To ")}} 
        <br>
         {{display_datetime($booking->end_date)}} <br>
    </div>
    <div class="to-country">
        Muscat
    </div>
   </div>
    </div>
 
    <div class="content-small-wrapper d-flex justify-content-between">
    <div>
        {{__("Duration")}} 
        <br>
         {{__(':duration hrs',['duration'=>@$booking->service->duration])}}
    </div>

<!-- 
    <div class="a">
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        {{$booking->object_model}}
    </div> -->
  
    <div class="abc">
        <span>
            Oder Date
        </span>
        <br>

    {{display_date($booking->created_at)}}
    </div>
    </div>
   
   <div class="status-div">
<span>Staus</span>

<div class="{{$booking->status}} ab2">
        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500">{{$booking->statusName}}</span>
    </div>
   </div>

 
</div>

</div>
