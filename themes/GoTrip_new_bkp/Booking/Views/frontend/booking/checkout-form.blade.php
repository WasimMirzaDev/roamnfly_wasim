<div class="form-checkout" id="form-checkout">
    <input type="hidden" name="code" value="{{ $booking->code }}">
    <input type="hidden" name="type" value="{{ $booking->object_model }}">
    <div class="form-section">
        <div class="row x-gap-20 y-gap-20 pt-20">

            @if (is_enable_guest_checkout() && is_enable_registration())
                <div class="col-12">
                    <div class="">
                        <label for="confirmRegister" class="flex ">
                            <input style="width: auto" type="checkbox" name="confirmRegister" id="confirmRegister"
                                value="1">
                            {{ __('Create a new account?') }}
                        </label>
                    </div>
                </div>
            @endif
            @if (is_enable_guest_checkout())
                <div class="col-12 d-none" id="confirmRegisterContent">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input ">
                                <input type="password" class="form-control" name="password" autocomplete="off">
                                <label class="lh-1 text-16 text-light-1">{{ __('Password') }} <span
                                        class="required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input ">
                                <input type="password" class="form-control" name="password_confirmation"
                                    autocomplete="off">
                                <label class="lh-1 text-16 text-light-1">{{ __('Password confirmation') }} <span
                                        class="required">*</span></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            @endif

            <div class="p-4 mb-3" style="background-color: rgba(245, 245, 245, 0.685)">
                <center>
                    <h3>Passengers</h3>
                </center>
                @php
                    if ($booking->adults != 0 && $booking->adults != null) {
                        $adultsString = $booking->adults;

                        $adultsForarray = json_decode($adultsString, true);
                        // Use a regular expression to extract the number before the '*'
                        if (is_array($adultsForarray) && !empty($adultsForarray)) {
                            // Get the first item from the array
                            $firstAdultString = $adultsForarray[0];
                            // Use a regular expression to extract the number before the '*'
                            if (preg_match('/^\d+/', $firstAdultString, $matches)) {
                                $adultsNumber = (int) $matches[0];
                                if ($adultsNumber == 0) {
                                    $adultsArray = [];
                                } else {
                                    // Create an array from 1 to the extracted number
                                    $adultsArray = range(1, $adultsNumber);
                                }
                            } else {
                                $adultsArray = [];
                            }
                        } else {
                            if (preg_match('/^\d+/', $adultsString, $matches)) {
                                $adultsNumber = (int) $matches[0];
                                if ($adultsNumber == 0) {
                                    $adultsArray = [];
                                } else {
                                    $adultsArray = range(1, $adultsNumber);
                                }
                                // Create an array from 1 to the extracted number
                            } else {
                                $adultsArray = [];
                            }
                        }
                    } else {
                        $adultsArray = [];
                    }

                    if ($booking->children != 0 && $booking->children != null) {
                        $childrenString = $booking->children;

                        $childForarray = json_decode($childrenString, true);
                        // Use a regular expression to extract the number before the '*'
                        if (is_array($childForarray) && !empty($childForarray)) {
                            // Get the first item from the array
                            $firstChildString = $childForarray[0];
                            // Use a regular expression to extract the number before the '*'
                            // Use a regular expression to extract the number before the '*'
                            if (preg_match('/^\d+/', $firstChildString, $matches)) {
                                $childrenNumber = (int) $matches[0];
                                if ($childrenNumber == 0) {
                                    $childrenArray = [];
                                } else {
                                    $childrenArray = range(1, $childrenNumber);
                                }
                                // Create an array from 1 to the extracted number
                            } else {
                                $childrenArray = [];
                            }
                        } else {
                            // Use a regular expression to extract the number before the '*'
                            if (preg_match('/^\d+/', $childrenString, $matches)) {
                                $childrenNumber = (int) $matches[0];
                                if ($childrenNumber == 0) {
                                    $childrenArray = [];
                                } else {
                                    $childrenArray = range(1, $childrenNumber);
                                }
                                // Create an array from 1 to the extracted number
                            } else {
                                $childrenArray = [];
                            }
                        }
                    } else {
                        $childrenArray = [];
                    }
                    if ($booking->infants != 0 && $booking->infants != null) {
                        $infantsString = $booking->infants;

                        $infantsForarray = json_decode($infantsString, true);
                        // Use a regular expression to extract the number before the '*'
                        if (is_array($infantsForarray) && !empty($infantsForarray)) {
                            // Get the first item from the array
                            $FirstinfantsString = $infantsForarray[0];
                            // Use a regular expression to extract the number before the '*'
                            if (preg_match('/^\d+/', $FirstinfantsString, $matches)) {
                                $infantsNumber = (int) $matches[0];
                                if ($infantsNumber == 0) {
                                    $infantsArray = [];
                                } else {
                                    $infantsArray = range(1, $infantsNumber);
                                }
                                // Create an array from 1 to the extracted number
                            } else {
                                $infantsArray = [];
                            }
                        } else {
                            // Use a regular expression to extract the number before the '*'
                            if (preg_match('/^\d+/', $infantsString, $matches)) {
                                $infantsNumber = (int) $matches[0];
                                if ($infantsNumber == 0) {
                                    $infantsArray = [];
                                } else {
                                    $infantsArray = range(1, $infantsNumber);
                                }
                                // Create an array from 1 to the extracted number
                            } else {
                                $infantsArray = [];
                            }
                        }
                    } else {
                        $infantsArray = [];
                    }
                @endphp
                @if (!empty($adultsArray))
                    @foreach ($adultsArray as $index => $adult)
                        <div class="mb-3">
                            <h5 class="mb-2">Adult {{ $adult }}</h5>

                            <div class="row gy-2">
                                <input type="text" class="form-control" value="ADULT"
                                    name="adults[{{ $index }}][type]" hidden>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control" value="{{ $user->first_name ?? '' }}"
                                            name="adults[{{ $index }}][first_name]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('First Name') }} <span
                                                class="required" >*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control" value="{{ $user->last_name ?? '' }}"
                                            name="adults[{{ $index }}][last_name]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('Last Name') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>
<div class="col-md-12 field-Expire-line-1">
    <div class="form-group">
        <label>{{ __('Date of Birth') }} </label>
        <input type="date" placeholder="{{ __('Date of Birth') }}"
            class="form-control" 
            max="{{ now()->subYears(12)->format('Y-m-d') }}"
            value="{{ $user->dob ?? '' }}"
            name="adults[{{ $index }}][dob]">
    </div>
</div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control" value="{{ $user->pan ?? '' }}"
                                            name="adults[{{ $index }}][pan]" placeholder="i.e (AAAAA9999A)">
                                        <label class="lh-1 text-16 text-light-1">{{ __('PAN (AAAAA9999A)') }} <span
                                                class="required">*</span></label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control" value="{{ $user->passport ?? '' }}"
                                            name="adults[{{ $index }}][passport]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('Passport') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6 field-Expire-line-1">
                                    <div class="form-group">
                                        <label>{{ __('Issue Date') }} </label>
                                        <input type="date" placeholder="{{ __('Passport Issue Date') }}"
                                            class="form-control" value="{{ $user->pid ?? '' }}"
                                            name="adults[{{ $index }}][pid]">
                                    </div>
                                </div>
                                <div class="col-md-6 field-Expire-line-2">
                                    <div class="form-group">
                                        <label>{{ __('Expire Date') }} </label>
                                        <input type="date" placeholder="{{ __('Passport Expire Date') }}"
                                            class="form-control" value="{{ $user->eD ?? '' }}"
                                            name="adults[{{ $index }}][eD]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


                @if (!empty($childrenArray))
                    @foreach ($childrenArray as $index => $child)
                        <div class="mb-3">
                            <h5 class="mb-2">Child {{ $child }}</h5>


                            <div class="row gy-2">
                                <input type="text" class="form-control" value="CHILD"
                                    name="children[{{ $index }}][type]" hidden>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control"
                                            value="{{ $user->first_name ?? '' }}"
                                            name="children[{{ $index }}][first_name]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('First Name') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control"
                                            value="{{ $user->last_name ?? '' }}"
                                            name="children[{{ $index }}][last_name]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('Last Name') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-12 field-Expire-line-1">
                                    <div class="form-group">
                                        <label>{{ __('Date of Birth') }} </label>
                                        <input type="date" placeholder="{{ __('Date of Birth') }}"
                                            class="form-control" value="{{ $user->dob ?? '' }}"
                                            name="children[{{ $index }}][dob]">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control" value="{{ $user->pan ?? '' }}"
                                            name="children[{{ $index }}][pan]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('PAN (AAAAA9999A)') }} <span
                                                class="required">*</span></label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control"
                                            value="{{ $user->passport ?? '' }}"
                                            name="children[{{ $index }}][passport]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('Passport') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>

<div class="col-md-12 field-Expire-line-1">
    <div class="form-group">
        <label>{{ __('Date of Birth') }} </label>
        <input type="date" placeholder="{{ __('Date of Birth') }}"
            class="form-control" 
            min="{{ now()->subYears(12)->format('Y-m-d') }}"
            max="{{ now()->subYears(2)->format('Y-m-d') }}"
            value="{{ $user->dob ?? '' }}"
            name="children[{{ $index }}][dob]">
    </div>
</div>
                                <div class="col-md-6 field-Expire-line-2">
                                    <div class="form-group">
                                        <label>{{ __('Expire Date') }} </label>
                                        <input type="date" placeholder="{{ __('Passport Expire Date') }}"
                                            class="form-control" value="{{ $user->eD ?? '' }}"
                                            name="children[{{ $index }}][eD]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


                @if (!empty($infantsArray))
                    @foreach ($infantsArray as $index => $infant)
                        <div class="mb-3">
                            <h5 class="mb-2">Infant {{ $infant }}</h5>


                            <div class="row gy-2">
                                <input type="text" class="form-control" value="INFANT"
                                    name="infants[{{ $index }}][type]" hidden>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control"
                                            value="{{ $user->first_name ?? '' }}"
                                            name="infants[{{ $index }}][first_name]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('First Name') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input type="text" class="form-control"
                                            value="{{ $user->last_name ?? '' }}"
                                            name="infants[{{ $index }}][last_name]">
                                        <label class="lh-1 text-16 text-light-1">{{ __('Last Name') }} <span
                                                class="required">*</span></label>
                                    </div>
                                </div>
<div class="col-md-12 field-Expire-line-1">
    <div class="form-group">
        <label>{{ __('Date of Birth') }} </label>
        <input type="date" placeholder="{{ __('Date of Birth') }}"
            class="form-control" 
            max="{{ now()->subYears(2)->format('Y-m-d') }}"
            value="{{ $user->dob ?? '' }}"
            name="infants[{{ $index }}][dob]">
    </div>
</div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>


            <div class="col-md-6 field-email">
                <div class="form-input ">
                    <input type="email" class="form-control" value="{{ $user->email ?? '' }}" name="email">
                    <label class="lh-1 text-16 text-light-1">{{ __('Email') }} <span
                            class="required">*</span></label>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-input ">
                    <input type="text" class="form-control" value="{{ $user->phone ?? '' }}" name="phone">
                    <label class="lh-1 text-16 text-light-1">{{ __('Phone') }} <span
                            class="required">*</span></label>
                </div>
            </div>
            <div class="col-md-6 field-address-line-1">
                <div class="form-input ">
                    <input type="text" class="form-control" value="{{ $user->address ?? '' }}"
                        name="address_line_1">
                    <label class="lh-1 text-16 text-light-1">{{ __('Address line 1') }} </label>

                </div>
            </div>
            <div class="col-md-6 field-address-line-2">
                <div class="form-input ">
                    <input type="text" class="form-control" value="{{ $user->address2 ?? '' }}"
                        name="address_line_2">
                    <label class="lh-1 text-16 text-light-1">{{ __('Address line 2') }} </label>

                </div>
            </div>
            <div class="col-md-6 field-city">
                <div class="form-input ">
                    <input type="text" class="form-control" value="{{ $user->city ?? '' }}" name="city">
                    <label class="lh-1 text-16 text-light-1">{{ __('City') }} </label>

                </div>
            </div>
            <div class="col-md-6 field-state">
                <div class="form-input ">
                    <input type="text" class="form-control" value="{{ $user->state ?? '' }}" name="state">
                    <label class="lh-1 text-16 text-light-1">{{ __('State/Province/Region') }} </label>

                </div>
            </div>
            <div class="col-md-6 field-zip-code">
                <div class="form-input ">
                    <input type="text" class="form-control" value="{{ $user->zip_code ?? '' }}" name="zip_code">
                    <label class="lh-1 text-16 text-light-1">{{ __('ZIP code/Postal code') }} </label>
                </div>
            </div>
            <div class="col-md-6 field-country">
                <div class="form-input ">
                    <select name="country" class="form-control">
                        <option value="">{{ __('-- Select --') }}</option>
                        @foreach (get_country_lists() as $id => $name)
                            <option @if (($user->country ?? '') == $id) selected @endif value="{{ $id }}">
                                {{ $name }}</option>
                        @endforeach
                    </select>
                    <label class="lh-1 text-16 text-light-1">{{ __('Country') }} <span class="required">*</span>
                    </label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-input">
                    <textarea name="customer_notes" cols="30" rows="6" class="form-control"></textarea>
                    <label class="lh-1 text-16 text-light-1">{{ __('Special Requirements') }} </label>
                </div>
            </div>
        </div>
    </div>


    @include ('Booking::frontend/booking/checkout-passengers')
    @include ('Booking::frontend/booking/checkout-deposit')
    @include ($service->checkout_form_payment_file ?? 'Booking::frontend/booking/checkout-payment')

    @php
        $term_conditions = setting_item('booking_term_conditions');
    @endphp
    @if (setting_item('booking_enable_recaptcha'))
        <div class="form-input ">
            {{ recaptcha_field('booking') }}
        </div>
    @endif
    <div class="html_before_actions"></div>

    <p class="alert-text mt10" v-show=" message.content" v-html="message.content"
        :class="{ 'danger': !message.type, 'success': message.type }"></p>

    <div class="row y-gap-20 items-center justify-between mb-40">
        <div class="col-auto">
            <div class="d-flex items-center">
                <div class="form-checkbox ">
                    <input type="checkbox" name="term_conditions">
                    <div class="form-checkbox__mark">
                        <div class="form-checkbox__icon icon-check"></div>
                    </div>
                </div>
                <div class="text-14 lh-10 text-light-1 ml-10">{{ __('I have read and accept the') }} <a
                        target="_blank"
                        href="{{ get_page_url($term_conditions) }}">{{ __('terms and conditions') }}</a></div>

            </div>
        </div>

        <div class="col-auto">
            <button class="button h-60 px-24 -dark-1 bg-blue-1 text-white" @click="doCheckout">
                {{ __('Book Now') }}
                <div class="icon-arrow-top-right ml-15"></div>
                <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
            </button>

        </div>
    </div>
</div>
