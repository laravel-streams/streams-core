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

    'quality' => 80,

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

    'auto_alt' => true
];
