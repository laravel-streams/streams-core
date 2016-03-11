<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Add additional path prefixes for the asset manager here. You may also
    | add prefixes for domains like a CDN.
    |
    | Later you can access assets in the path like:
    |
    | $asset->add('collection.css', 'example::path/to/asset.css');
    |
    */

    'paths' => [
        //'example' => 'some/local/path',
        //'s3'      => 'https://region.amazonaws.com/bucket'
    ],

    /*
    |--------------------------------------------------------------------------
    | Hints
    |--------------------------------------------------------------------------
    |
    | Hints help the system interpret the correct
    | output file extension to use for syntax / languages
    | that need to be compiled to a standard language.
    |
    */

    'hints' => [
        'css' => [
            'less',
            'scss',
            'styl'
        ],
        'js'  => [
            'coffee'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    |
    | LESS: "php" or "node"
    | SCSS: "php" or "ruby"
    |
    */

    'filters' => [
        'less' => env('LESS_COMPILER', 'php'),
        'scss' => env('SCSS_COMPILER', 'php')
    ],

    /*
    |--------------------------------------------------------------------------
    | Live
    |--------------------------------------------------------------------------
    |
    | Define which assets marked live are to be compiled.
    |
    | true: Assets request for both the CP and frontend.
    | public: Assets requested ONLY by the frontend.
    | admin: Assets requested ONLY by the CP.
    |
    */

    'live' => env('LIVE_ASSETS', false)
];
