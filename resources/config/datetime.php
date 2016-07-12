<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Date/Time Format
    |--------------------------------------------------------------------------
    |
    | This is the default format of dates and times displayed.
    |
    */

    'date_format' => env('DATE_FORMAT', 'j F, Y'),
    'time_format' => env('TIME_FORMAT', 'g:i A'),

    /*
    |--------------------------------------------------------------------------
    | Timezones
    |--------------------------------------------------------------------------
    |
    | This is the default timezone used for display.
    |
    */

    'default_timezone' => env('DEFAULT_TIMEZONE', 'UTC')
];
