<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Force HTTPS
    |--------------------------------------------------------------------------
    |
    | You may opt to force an SSL connection when accessing the application.
    | Supported options are "none", "all", "public", "admin"
    |
    */

    'force_https' => env('FORCE_HTTPS', 'none'),

    /*
    |--------------------------------------------------------------------------
    | 404 Redirect
    |--------------------------------------------------------------------------
    |
    | You may opt to redirect a 404 to a specific URL / path.
    |
    */

    '404_redirect' => env('404_REDIRECT'),
    '404_type'     => env('404_TYPE', 301)
    
];
