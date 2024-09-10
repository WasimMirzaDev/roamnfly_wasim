<style>
    .searchMenu-loc__field {
        height: 300px;
        max-height: 300px; /* Set a max-height to make scrolling work */
        overflow: hidden;
    }
    .js-results {
        max-height: 300px; /* Make sure it doesn't exceed container height */
        overflow-y: auto; /* Use 'auto' to handle overflow properly */
    }
    .js-results::-webkit-scrollbar {
        width: 5px;
        background: rgb(155 155 155 / 50%);
    }
    /* Add these styles to your stylesheet */
.show-important {
    display: block !important;
}

.hide-important {
    display: none !important;
}
.no-scroll{
    overflow: hidden
}

</style>

@if($airports = \Modules\Flight\Models\Airport::where('status', 'publish')->get())
<div class="searchMenu-loc clicked-class js-form-dd js-liverSearch item">
    <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span>
    <div data-x-dd-click="searchMenu-loc">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ __(ucwords(str_replace('_', ' ', $inputName))) }}</h4>
        <div class="text-15 text-light-1 ls-2 lh-16 smart-search">
            <input type="hidden" name="{{ $inputName }}[]" class="js-search-get-id" value="{{ Request::query($inputName)[0] ?? '' }}">
            <input type="text" autocomplete="off" readonly class="smart-search-location parent_text js-search js-dd-focus" 
                placeholder="{{ __('Select ' . ucwords(str_replace('_', ' ', $inputName))) }}" 
                value="{{ $airports->where('code', Request::query($inputName)[0] ?? '')->first()->name ?? '' }}">
        </div>
    </div>
    <div class="searchMenu-loc__field asdsads shadow-2 js-popup-window" data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
        <div class="bg-white px-0 py-10 sm:px-0 sm:py-15 rounded-4">
            <input type="text" autocomplete="off" class="react-autosuggest__input" placeholder="Search Airports" title="Type to search for airports">
            <div class="y-gap-5 js-results">
                @foreach($airports as $term)
                    <div class="-link d-block col-12 text-left rounded-4 px-20 py-15 remove-scroll js-search-option" data-id="{{ $term->code }}">
                        <div class="d-flex align-items-center">
                            <div class="fa fa-plane text-light-1 text-20 pt-4"></div>
                            <div class="ml-10">
                                <div class="text-15 lh-12 fw-500 js-search-option-target">{{ $term->name .' | '. $term->code .' | '. $term->address }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const searchInput = $('.react-autosuggest__input');
    const resultsContainer = $('.js-results');
    const searchOptions = $('.js-search-option');

    // Show all options by default
    // resultsContainer.removeClass('hide-important').addClass('show-important');
    searchOptions.removeClass('hide-important').addClass('show-important');


    searchInput.on('input', function () {
        const query = $(this).val().toLowerCase().trim();

        if (query.length > 0) {
            let hasVisibleOptions = false; // Track if any option is visible

            searchOptions.each(function () {
                const airportText = $(this).find('.js-search-option-target').text().toLowerCase();

                if (airportText.includes(query)) {
                    $(this).removeClass('hide-important').addClass('show-important'); // Show matching result
                    hasVisibleOptions = true; // Mark that we have at least one visible option
                } else {
                    $(this).removeClass('show-important').addClass('hide-important'); // Hide non-matching result
                }
            });


        } else {
            searchOptions.removeClass('hide-important').addClass('show-important');
            // resultsContainer.removeClass('hide-important').addClass('show-important');/
        }
    });

});
$(document).ready(function () {
    // When searchMenu-loc is clicked, add the no-scroll class to the body
    $('.clicked-class').on('click', function (e) {
        e.stopPropagation(); // Prevent event bubbling
        $('body').addClass('no-scroll');
    });

    // When remove-scroll is clicked, remove the no-scroll class from the body
    $('.remove-scroll').on('click', function (e) {
        e.stopPropagation();
        $('body').removeClass('no-scroll');
    });

    // Click outside to close the menu and re-enable scrolling
    $(document).on('mousedown', function (e) {
        // Check if the clicked element is not within .searchMenu-loc or .js-popup-window
        if (!$(e.target).closest('.clicked-class, .js-popup-window').length) {
            $('body').removeClass('no-scroll'); // Remove no-scroll class from body
        }
    });

    // // Prevent propagation within the pop-up window
    // $('.js-popup-window').on('click', function (e) {
    //     e.stopPropagation(); // Prevent closing when clicking inside the pop-up
    // });
});


</script>


