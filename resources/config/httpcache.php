<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HTTP CACHE ENABLED
    |--------------------------------------------------------------------------
    |
    | Do you want to enable HTTP caching?
    |
    */

    'enabled' => env('HTTP_CACHE', false),

    /*
    |--------------------------------------------------------------------------
    | DEFAULT TTL
    |--------------------------------------------------------------------------
    |
    | What is the default TTL value (seconds)?
    |
    */

    'ttl' => env('HTTP_CACHE_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | EXCLUDED PATHS
    |--------------------------------------------------------------------------
    |
    | Specify cache-excluded paths.
    | Use * for partial matching.
    |
    */

    'excluded' => explode(',', env('HTTP_CACHE_EXCLUDED', '')),

];
