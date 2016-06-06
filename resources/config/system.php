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
];
