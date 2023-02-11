<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('response_time')) {

    /**
     * Get the response time in seconds.
     *
     * @param int $precision
     * @return float
     */
    function response_time(int $precision = 2): float
    {
        return (float) number_format(microtime(true) - Request::server('REQUEST_TIME_FLOAT'), $precision, '.', '');
    }
}
