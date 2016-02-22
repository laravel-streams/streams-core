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
    ]
];
