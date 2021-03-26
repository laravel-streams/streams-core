<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Streams
    |--------------------------------------------------------------------------
    |
    | Configure Streams system.
    |
    */

    'streams_dir' => 'streams/data',

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

    'fields' => [
        'types' => [

            // Strings
            'string' => \Streams\Core\Field\Type\Str::class,

            'url' => \Streams\Core\Field\Type\Url::class,
            'text' => \Streams\Core\Field\Type\Str::class,
            'hash' => \Streams\Core\Field\Type\Hash::class,
            'slug' => \Streams\Core\Field\Type\Slug::class,
            'email' => \Streams\Core\Field\Type\Email::class,

            'markdown' => \Streams\Core\Field\Type\Markdown::class,
            'template' => \Streams\Core\Field\Type\Template::class,

            // Numbers
            'number' => \Streams\Core\Field\Type\Number::class,
            'integer' => \Streams\Core\Field\Type\Integer::class,
            'float' => \Streams\Core\Field\Type\Decimal::class,

            'decimal' => \Streams\Core\Field\Type\Decimal::class,

            // Boolean
            'boolean' => \Streams\Core\Field\Type\Boolean::class,

            // Arrays
            'array' => \Streams\Core\Field\Type\Arr::class,

            // Objects
            'prototype' => \Streams\Core\Field\Type\Prototype::class,
            'object' => \Streams\Core\Field\Type\Prototype::class,
            'image' => \Streams\Core\Field\Type\Image::class,
            'file' => \Streams\Core\Field\Type\File::class,

            // Dates
            'datetime' => \Streams\Core\Field\Type\Datetime::class,
            'date' => \Streams\Core\Field\Type\Date::class,
            'time' => \Streams\Core\Field\Type\Time::class,

            // Selections
            'select' => \Streams\Core\Field\Type\Select::class,
            'multiselect' => \Streams\Core\Field\Type\Multiselect::class,

            // Collections
            // @todo Test me
            'collection' => \Streams\Core\Field\Type\Collection::class,

            // Streams
            'entry' => \Streams\Core\Field\Type\Entry::class,
            'entries' => \Streams\Core\Field\Type\Entries::class,

            // Relationships
            'multiple' => \Streams\Core\Field\Type\Multiple::class,
            'polymorphic' => \Streams\Core\Field\Type\Polymorphic::class,
            'relationship' => \Streams\Core\Field\Type\Relationship::class,

            // Miscellaneous
            'color' => \Streams\Core\Field\Type\Color::class,
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
];
