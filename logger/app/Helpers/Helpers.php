<?php

use Illuminate\Support\Carbon;

if (!function_exists('requestTimeInIso')) {
    function requestTimeInIso(): string
    {
        return Carbon::createFromTimestamp(request()->server('REQUEST_TIME'))->toIso8601String();
    }
}
