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
    | Version Assets
    |--------------------------------------------------------------------------
    |
    | This will cause asset changes to version by default.
    |
    | <link href="example/theme.css?v=1484943345" type="text/css"/>
    |
    */

    'version' => env('VERSION_ASSETS', true),
];
