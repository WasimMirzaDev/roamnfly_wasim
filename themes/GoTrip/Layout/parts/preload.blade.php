<div class="preloader js-preloader @if(empty(setting_item('enable_preload'))) -is-hidden @endif">
    @if(!empty($logo_preload_id = setting_item('logo_preload_id')))
        <div style="width: 240px; {{ Request::url() !== URL::to('/flight') ? 'padding-left: 16px;' : '' }}" >
            <div>
                <img class="logo-light" src="{{ Request::url() !== URL::to('/flight') ? asset('/images/SpinnerOrange.gif') : get_file_url($logo_preload_id,'full') }}" alt="{{setting_item("site_title")}}">
            </div>
        </div>
    @endif
    <div class="preloader__title"> Goflyhabibi </div>
</div>

