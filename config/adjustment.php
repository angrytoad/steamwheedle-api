<?php return [
    // -1 round down, 0 normal rounding, 1 round up
    'rounding' => 1,
    // The interval period in seconds currently expressed in a readable way 5 * 60 seconds or 5 min
    'interval' => env('INTERVAL') * 60,
    // The multiple of an items base price that is considered the maximum price
    'upperBound' => 5,
    // The multiple of an items base price that is considered the minimum price
    'lowerBound' => 1 / 5,
    // The number of intervals to look back on during the price update
    'pastIntervals' => 1
    ];