{{-- <style>
     .js-results{
        display: block !important;
    }
</style>




@if(!empty($attr) and !empty($attr = \Modules\Core\Models\Attributes::where('slug', $attr)->first()))
    <div class="searchMenu-loc js-form-dd js-liverSearch item">
        <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span>
        <div data-x-dd-click="searchMenu-loc">
            <h4 class="text-15 fw-500 ls-2 lh-16">{{ $attr->name }}</h4>
            <div class="text-15 text-light-1 ls-2 lh-16 smart-search">
                <!-- Retrieve value from URL or set to empty -->
                <input type="hidden" id="{{ $inputName }}" name="{{ $inputName }}" class="js-search-get-id" value="{{ Request::query($inputName) ?? '' }}">
                <!-- Display selected term name or placeholder -->
                <input type="text" autocomplete="off" readonly class="smart-search-location parent_text js-search js-dd-focus" 
                    placeholder="{{ __('Select Type') }}" 
                    value="{{ optional($attr->terms->where('name', Request::query($inputName))->first())->name ?? '' }}">
            </div>            
        </div>
        <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
            <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                <div class="y-gap-5 js-results">
                    @foreach($attr->terms as $term)
                        @php $translate = $term->translate(); @endphp
                        <div class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option getMultiRow" data-id="{{ $translate->name }}">
                            <div class="d-flex align-items-center">
                                <div class="{{ $term->icon }} text-light-1 text-20 pt-4"></div>
                                <div class="ml-10">
                                    <div class="text-15 lh-12 fw-500 js-search-option-target">{{ $translate->name }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif --}}
