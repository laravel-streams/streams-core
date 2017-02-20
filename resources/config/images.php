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
    | Macros
    |--------------------------------------------------------------------------
    |
    | Add additional macros for the image manager here.
    |
    | Later you can run macros on images like:
    |
    | $image->make('example::path/to/image.jpg')->macro('2x');
    |
    */

    'macros' => [],

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
    | Anti-aliasing Default
    |--------------------------------------------------------------------------
    |
    | This will cause image to use anti-aliasing by default or not.
    |
    */

    'anti_aliasing' => env('ANTI_ALIASING', true),
];
