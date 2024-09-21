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
    <div class="header-menu mmmmm" data-x="mobile-menu" data-x-toggle="is-menu-active">
        <div class="mobile-overlay"></div>
        <div class="header-menu__content">
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
                    <div class="icon-text-wrapper d-flex justify-content-start align-items-center me-4">
                   <a href="">
                   <i class="fa-solid fa-plane-departure me-2 fa-xl "></i>
                   <span>Flight</span>
                   </a>
                    </div>
                    <div class="icon-text-wrapper d-flex justify-content-start align-items-center me-4">
                  <a href="">
                  <i class="fa-solid fa-hotel me-2 fa-xl "></i>
                  <span>Hotel</span>
                  </a>
                    </div>
                    <div class="icon-text-wrapper d-flex justify-content-start align-items-center me-4">
                  <a href=""> 
                    <i class="fa-solid fa-suitcase-rolling me-2 fa-xl "></i>
                  <span>Holidays</span>
                </a>
                    </div>
                </div>
            </div>
            <div class="mobile-footer px-20 py-10 border-top-light js-mobile-footer">
                @include('Core::frontend.currency-switcher')
                @include('Language::frontend.switcher-dropdown')
            </div>
        </div>
    </div>
</div>
