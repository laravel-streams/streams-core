<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Results Per Page
    |--------------------------------------------------------------------------
    |
    | This is the global default number of results
    | to display on each page.
    |
    */

    'per_page' => env('RESULTS_PER_PAGE', 15),

    /*
    |--------------------------------------------------------------------------
    | Units of Measurement
    |--------------------------------------------------------------------------
    |
    | Which measurement system do you use? 'imperial' or 'metric'
    |
    */

    'unit_system' => env('UNIT_SYSTEM', 'imperial'),

    /*
    |--------------------------------------------------------------------------
    | Force HTTPS
    |--------------------------------------------------------------------------
    |
    | Redirect to HTTPS as desired.
    |
    | Available options are:
    |
    | 'none'    - don't force https
    | 'public'  - force https for public only
    | 'admin'   - force https for control panel only
    | 'all'     - force https for public and control panel
    |
    */

    'force_https' => env('FORCE_HTTPS', 'none'),

    /*
    |--------------------------------------------------------------------------
    | Prefer WWW / non-WWW
    |--------------------------------------------------------------------------
    |
    | Redirect to WWW or non-WWW as preferred.
    |
    | Available options are:
    |
    | 'none'    - no preference
    | 'www'     - redirect to www
    | 'domain'  - redirect to non-www
    |
    */

    'www_preference' => env('WWW_PREFERENCE', 'none'),
];
