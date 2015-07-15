<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Date/Time Format
    |--------------------------------------------------------------------------
    |
    | This is the default format of dates and times displayed.
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'date_format' => 'D M j, Y',
    'time_format' => 'g:i A',

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | This is the timezone used for display purposes only. It is suggested
    | to keep the system timezone (app.timezone) as UTC.
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'timezone'         => env('TIMEZONE', 'UTC'),
    'default_timezone' => env('DEFAULT_TIMEZONE', 'UTC')
];
