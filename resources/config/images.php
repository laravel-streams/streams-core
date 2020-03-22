<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Quality
    |--------------------------------------------------------------------------
    |
    | Specify the default image quality.
    |
    */

    'quality' => env('IMAGE_QUALITY', 80),

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Add additional path prefixes for the image manager here. You may also
    | add prefixes for domains like a CDN.
    |
    | Later you can access images in the path like:
    |
    | $image->make('example::path/to/image.jpg');
    |
    */

    'paths' => [],

    /*
    |--------------------------------------------------------------------------
    | Automatic Alt Tags
    |--------------------------------------------------------------------------
    |
    | This will default alt tags to the humanized filename.
    |
    | <img src="my_awesome_photo.jpg" alt="My Awesome Photo"/>
    |
    */

    'auto_alt' => env('IMAGE_ALTS', true),

    /*
    |--------------------------------------------------------------------------
    | Version Images
    |--------------------------------------------------------------------------
    |
    | This will cause image changes to version by default.
    |
    | <img src="my_awesome_photo.jpg?v=1484943345" alt="My Awesome Photo"/>
    |
    */

    'version' => env('VERSION_IMAGES', true),

    /*
    |--------------------------------------------------------------------------
    | Interlace JPEGs
    |--------------------------------------------------------------------------
    |
    | This will cause image to automatically interlace JPEGs.
    |
    */

    'interlace' => env('IMAGE_INTERLACE', true),
];
