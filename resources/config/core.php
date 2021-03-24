<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Source Configuration
    |--------------------------------------------------------------------------
    |
    | Configure Stream sources.
    |
    */
    'sources' => [

        'default' => env('STREAMS_SOURCE', 'filebase'),

        'types' => [

            'filebase' => [

                'format' => env('STREAMS_SOURCE_FORMAT', 'json'),
                //'path' => env('STREAMS_SOURCE_PATH', 'streams/data'),

                'formats' => [
                    'php' => \Streams\Core\Criteria\Format\Php::class,
                    'json' => \Streams\Core\Criteria\Format\Json::class,
                    'yaml' => \Streams\Core\Criteria\Format\Yaml::class,
                    'md' => \Streams\Core\Criteria\Format\Markdown::class,
                    'tpl' => \Streams\Core\Criteria\Format\Template::class,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Addon Customization
    |--------------------------------------------------------------------------
    |
    | Here you can customize and
    | extend the addon loader.
    |
    */
    'addons' => [

        /**
         * An array of disabled
         * addons by handle.
         */
        'disabled' => [
            //'anomaly.module.users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Customization
    |--------------------------------------------------------------------------
    |
    | Here you can customize and
    | extend the image manager.
    |
    */
    'images' => [

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
    ],

    /*
    |--------------------------------------------------------------------------
    | Transformers
    |--------------------------------------------------------------------------
    |
    | Here you can define system transformers.
    |
    */
    'transformers' => [
        'Streams\Core\Stream\Stream' => [
            'test' => [
                'config' => [
                    'app.name' => 'Transformers!',
                ]
            ],
        ],
    ],
];
