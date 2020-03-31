<?php 

return [

    'addons' => [

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
            'theme',
        ],

        /*
        |--------------------------------------------------------------------------
        | Configured Addon Paths @todo unused
        |--------------------------------------------------------------------------
        |
        | These manually defined addon paths can be helpful
        | when you need to push an addon path into load
        | that is shipped IN another addon.
        |
        */

        'paths' => [
            //'addons/shared/example-module/addons/anomaly/fancy-field_type'
        ],

        /*
        |--------------------------------------------------------------------------
        | Configured Addon Directories @todo unused
        |--------------------------------------------------------------------------
        |
        | These manually defined addon paths can be helpful
        | when you need to push an addon path into load
        | that is shipped IN another addon.
        |
        */

        'directories' => [
            //'my-bundle'
        ],
    ],

    'assets' => [

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
    ],    

    'datetime' => [

        /*
        |--------------------------------------------------------------------------
        | Date/Time Format
        |--------------------------------------------------------------------------
        |
        | This is the default format of dates and times displayed.
        |
        */

        'date_format' => env('DATE_FORMAT', 'm/d/Y'),
        'time_format' => env('TIME_FORMAT', 'g:i A'),

        /*
        |--------------------------------------------------------------------------
        | Timezones
        |--------------------------------------------------------------------------
        |
        | Configure the various timezones used.
        |
        | Default: The default timezone for the application when none is set.
        | Database: The timezone of the database.
        |
        */

        'default_timezone'  => env('DEFAULT_TIMEZONE', date_default_timezone_get()),
        'database_timezone' => env('DATABASE_TIMEZONE', date_default_timezone_get()),
    ]
];
