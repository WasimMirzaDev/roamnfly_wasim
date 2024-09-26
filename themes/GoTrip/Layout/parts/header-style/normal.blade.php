<style>
     .menu-second{
  .inner-menu-wrapper{
    background-color: rgb(153 152 152 / 50%); 
  }
 }
 .menu-second-for-next-line{
    .inner-menu-wrapper{
        display: flex !important;
        justify-content: center !important;
    }
    .inner-the-wrapper{ 
        display: flex;
    background-color: rgb(153 152 152 / 50%); 
    padding: 6px 10px;
    border-radius: 30px;
 }
 }
    .menu-second,
    .menu-second-for-next-line{
 .inner-menu-wrapper{
    padding: 15px;
    border-radius: 30px;
    & i,
    & span{
        color: white;
    }
 }   
}
.menu-second-for-next-line{
    display: none;
}
 @media (max-width:769px){
    .menu-second{
  .inner-menu-wrapper{
    background-color: rgb(153 152 152 / 50%); 
  }
 }
    .menu-second,
    .menu-second-for-next-line{
    .inner-menu-wrapper{
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
}
    .gotrip-header-transparent{
    & a{
        margin-right: 10px !important;
       }
    }
    .menu-second{
        display: none !important;

    }
    .menu-second-for-next-line{
        display: block !important;
    }
    
 }
 @media (max-width:426px){
    .menu-second{
  .inner-menu-wrapper{
    background-color: rgb(153 152 152 / 50%); 
  }
 }
    .menu-second,
    .menu-second-for-next-line{  
    .inner-menu-wrapper{
    padding: 8px 5px !important;
    border-radius: 30px;
    .icon-text-wrapper:nth-child(n):not(:last-child){
        margin-right: 0 !important;
    }
    & i{
        margin-right: 6px !important;
        &::before{
           color : white;
            font-size: 12px ;
        }
    }
    & span{
        color: white;
        font-size: 13px;
    }
 }
}
 .gotrip-header-transparent{
    & a{
        margin-right: 8px !important;
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
    <a href="{{url(app_get_locale(false,'/'))}}" class="text-white @if($headerStyle == 'transparent_v3') d-none xl:d-flex @endif header-logo mr-10" data-x="header-logo" data-x-toggle="is-logo-dark">
        {{-- @if($logo)
        RoamNfly    
        @endif
        @if($logoDark)
        RoamNfly    
        @endif --}}
        Goflyhabibi
        
    </a>
    <div class="header-menuONE" data-x="mobile-menu" data-x-toggle="is-menu-active">
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
                    <a href="{{ url('/flight') }}" class="d-flex justify-content-start align-items-center  me-2 {{ request()->is('flight') ? 'active' : '' }}">
                   <i class="fa-solid fa-plane-departure me-2 fa-xl "></i>
                   <span>Flight</span>
                   </a>
                    </div>
                    <div class="icon-text-wrapper me-4">
                  <a href="{{url('/hotel')}}" class=" d-flex justify-content-start align-items-center  me-2 {{ request()->is('hotel') ? 'active' : '' }}">
                  <i class="fa-solid fa-hotel me-2 fa-xl "></i>
                  <span>Hotel</span>
                  </a>
                    </div>
                    <div class="icon-text-wrapper ">
                  <a href="#" class=" d-flex justify-content-start align-items-center me-2 "> 
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
