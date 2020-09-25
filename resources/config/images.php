<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Image Path Hints
    |--------------------------------------------------------------------------
    |
    | Usage: Images::make('unsplash::random');
    |
    */
    'paths' => [
        'unsplash' => 'https://source.unsplash.com/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Automatically Interlace JPGs
    |--------------------------------------------------------------------------
    |
    | You can set this on the image too:
    |
    | Images::make('img/foo.jpg')->interlace(false);
    |
    */
    'interlace' => env('IMAGES_INTERLACE', true),

    /*
    |--------------------------------------------------------------------------
    | Automatic Alt Tags
    |--------------------------------------------------------------------------
    |
    | Enabling this feature automatically
    | generages alt tags when not specified.
    |
    */
    'auto_alt' => env('IMAGES_AUTO_ALT', true),
];
