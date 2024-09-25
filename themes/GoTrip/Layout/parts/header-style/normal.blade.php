<style>

 .inner-menu-wrapper{
    background-color: rgb(153 152 152 / 50%); 
    padding: 15px;
    border-radius: 30px;
    & i,
    & span{
        color: white;
    }
 }   
 @media (max-width:769px){
    .inner-menu-wrapper{
    background-color: rgb(153 152 152 / 50%); 
    padding: 10px;
    border-radius: 30px;
    .icon-text-wrapper:nth-child(n):not(:last-child){
        margin-right: 5px !important;
    }
    & i{
        margin-right: 8px !important;
        &::before{
           color : white;
            font-size: 16px ;
        }
    }
    & span{
        color: white;
        font-size: 15px;
    }
 }
 .gotrip-header-transparent{
    & a{
        margin-right: 10px !important;
    }
 }
 }
 .row{
    .col-auto{
        padding: 0 10px !important;
       .items-center{
        padding: 0 !important;
       }
    }
 }
 a.active i,
 a.active span{
    color: orange;
 }
</style>
@php
    if($headerStyle == "normal_white"){
        $logo = $logoDark;
    }
@endphp
<div class="d-flex items-center gotrip-header-{{$headerStyle}}">
    <a href="{{url(app_get_locale(false,'/'))}}" class="text-white @if($headerStyle == 'transparent_v3') d-none xl:d-flex @endif header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
        {{-- @if($logo)
        RoamNfly    
        @endif
        @if($logoDark)
        RoamNfly    
        @endif --}}
        Goflyhabibi
        
    </a>
    <div class="header-menuONE mmmmm" data-x="mobile-menu" data-x-toggle="is-menu-active">
        <div class="mobile-overlayONE"></div>
        <div class="header-menu__contentONE">
            <div class="mobile-bg js-mobile-bg"></div>
            <!-- <div class="menu js-navList">
                @php $textColor = $textColor ?? 'text-white';
                    if ($headerStyle == 'transparent_v5' || $headerStyle == 'transparent_v6' || $headerStyle == 'transparent_v9') $textColor = 'text-dark-1';
                    generate_menu('primary',[
                        'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                        'custom_class' => $textColor,
                        'desktop_menu' => true,
                        'enable_mega_menu' => true
                     ])
                @endphp
            </div> -->
            <div class="menu-second">
                <div class="inner-menu-wrapper d-flex justify-content-start align-items-center ">
                    <div class="icon-text-wrapper me-4">
                    <a href="{{ url('/flight') }}" class="d-flex justify-content-start align-items-center {{ request()->is('flight') ? 'active' : '' }}">
                   <i class="fa-solid fa-plane-departure me-2 fa-xl "></i>
                   <span>Flight</span>
                   </a>
                    </div>
                    <div class="icon-text-wrapper me-4">
                  <a href="{{url('/hotel')}}" class=" d-flex justify-content-start align-items-center {{ request()->is('hotel') ? 'active' : '' }}">
                  <i class="fa-solid fa-hotel me-2 fa-xl "></i>
                  <span>Hotel</span>
                  </a>
                    </div>
                    <div class="icon-text-wrapper ">
                  <a href="#HolidayTrip" class=" d-flex justify-content-start align-items-center"> 
                    <i class="fa-solid fa-suitcase-rolling me-2 fa-xl "></i>
                  <span>Holidays</span>
                </a>
                    </div>
                </div>
            </div>
            <!-- <div class="mobile-footer px-20 py-10 border-top-light js-mobile-footer">
                @include('Core::frontend.currency-switcher')
                @include('Language::frontend.switcher-dropdown')
            </div> -->
        </div>
    </div>
    
</div>
