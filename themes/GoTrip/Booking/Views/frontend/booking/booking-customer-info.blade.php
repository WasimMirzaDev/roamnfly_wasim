<style>
    .info-list{
        display: flex;
        flex-wrap: wrap;
        & li{
            flex: 0 0 50%; 
            justify-content: start !important;
            .label{
                width: 36% !important;
        }
        }
    }
</style>

<div class="booking-review">
    <h4 class="booking-review-title">{{__('Your Information')}}</h4>
    <div class="booking-review-content vvvv">
        <div class="review-section">
            <div class="info-form">
                <ul class="info-list">
                    <li class="info-first-name">
                        <div class="label">{{__('First name')}}</div>
                        <div class="val">{{$booking->first_name}}</div>
                    </li>
                    <li class="info-last-name">
                        <div class="label">{{__('Last name')}}</div>
                        <div class="val">{{$booking->last_name}}</div>
                    </li>
                    <li class="info-email">
                        <div class="label">{{__('Email')}}</div>
                        <div class="val">{{$booking->email}}</div>
                    </li>
                    <li class="info-phone">
                        <div class="label">{{__('Phone')}}</div>
                        <div class="val">{{$booking->phone}}</div>
                    </li>
                    @if(!empty($booking->address))
                    <li class="info-address">
                        <div class="label">{{__('Address line 1')}}</div>
                        <div class="val">{{$booking->address}}</div>
                    </li>
                    @endif
                    @if(!empty($booking->address2))
                    <li class="info-address2">
                        <div class="label">{{__('Address line 2')}}</div>
                        <div class="val">{{$booking->address2}}</div>
                    </li>
                    @endif
                    @if(!empty($booking->city))
                    <li class="info-city">
                        <div class="label">{{__('City')}}</div>
                        <div class="val">{{$booking->city}}</div>
                    </li>
                    @endif
                    @if(!empty($booking->state))
                    <li class="info-state">
                        <div class="label">{{__('State/Province/Region')}}</div>
                        <div class="val">{{$booking->state}}</div>
                    </li>
                    @endif
                    @if(!empty($booking->zip_code))
                    <li class="info-zip-code">
                        <div class="label">{{__('ZIP code/Postal code')}}</div>
                        <div class="val">{{$booking->zip_code}}</div>
                    </li>
                    @endif
                    @if(!($booking->country == 'NULL'))
                    <li class="info-country">
                        <div class="label">{{__('Country')}}</div>
                        <div class="val">{{get_country_name($booking->country)}}</div>
                    </li>
                    @endif
                    @if(!empty($booking->customer_notes))
                    <li class="info-notes">
                        <div class="label">{{__('Special Requirements')}}</div>
                        <div class="val">{{$booking->customer_notes}}</div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
