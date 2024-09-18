<?php
// Set default values
$defaultStartDate = date("Y-m-d");
$defaultEndDate = date("Y-m-d", strtotime("+1 day"));

// Get dates from URL or use default values
$startDate = Request::query('start')[$index] ?? $defaultStartDate;
$endDate = Request::query('end')[$index] ?? $defaultEndDate;

$dateRange = Request::query('date', "{$startDate} - {$endDate}");
?>
<div class="searchMenu-date form-date-search-hotel position-relative item">
    <div class="date-wrapper" data-x-dd-click="searchMenu-date">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>

        <div class="text-14 text-light-1 ls-2 lh-16 check-in-out-render">
            <!-- Display start date or default to today -->
            <span class="js-first-date render check-in-render">{{ $startDate }}</span>
            -
            <!-- Display end date or default to tomorrow -->
            <span class="js-last-date render check-out-render">{{ $endDate }}</span>
        </div>
    </div>
    
    <!-- Hidden inputs to maintain state in form submission -->
    <input type="hidden" class="check-in-input" value="{{ $startDate }}" name="start[]">
    <input type="hidden" class="check-out-input" value="{{ $endDate }}" name="end[]">
    
    <!-- Invisible text input for date range -->
    <input type="text" class="check-in-out absolute invisible" name="date" value="{{ $dateRange }}">
</div>

<style>
    @media (max-width: 767px) {
        body .daterangepicker {
            padding: 0px !important;
        }
    }
</style>