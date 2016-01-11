<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Addon Types
    |--------------------------------------------------------------------------
    |
    | When loading addons the system will look for SLUG-TYPE addons to load.
    |
    */

    'types' => [
        'field_type',
        'extension',
        'module',
        'plugin',
        'theme'
    ],

    /*
    |--------------------------------------------------------------------------
    | Eager Loaded Addons
    |--------------------------------------------------------------------------
    |
    | Eager loaded addons are registered first and can be defined
    | here by specifying their relative path to the project root.
    |
    */

    'eager' => [
        //'core/anomaly/redirects-module'
    ],

    /*
    |--------------------------------------------------------------------------
    | Deferred Addons
    |--------------------------------------------------------------------------
    |
    | Deferred loaded addons are registered last and can be defined
    | here by specifying their relative path to the project root.
    |
    */

    'deferred' => [
        //'core/anomaly/pages-module'
    ]
];
