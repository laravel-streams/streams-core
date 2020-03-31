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

    'database' => [

        /*
        |--------------------------------------------------------------------------
        | DB Cache
        |--------------------------------------------------------------------------
        |
        | Enable database query caching?
        |
        */
    
        'cache' => env('DB_CACHE', false),
    
        /*
        |--------------------------------------------------------------------------
        | Default TTL
        |--------------------------------------------------------------------------
        |
        | What is the default TTL value (seconds)?
        |
        */
    
        'ttl' => env('DB_CACHE_TTL', 3600),
    
        /*
        |--------------------------------------------------------------------------
        | Storage Localization
        |--------------------------------------------------------------------------
        |
        | Define the storage localization options for your database.
        |
        */
    
        'separator' => ',',
        'point'     => '.',
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
    ],

    'distribution' => [

        /*
        |--------------------------------------------------------------------------
        | Distribution
        |--------------------------------------------------------------------------
        |
        | These values provide very basic identification for the distribution.
        |
        */
    
        'name'        => 'Streams Platform',
        'description' => 'Streams is an abstracted modular platform for developing web applications.',
        'version'     => 'v2.0',
    ],

    'images' => [

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
    ],

    'locales' => [

        /*
        |--------------------------------------------------------------------------
        | Locale Hint
        |--------------------------------------------------------------------------
        |
        | Define where to look for an i18n locale.
        |
        | true, false, 'domain' or 'uri'
        |
        | If false, you must handle setting the locale yourself.
        | If true, both 'domain' and 'uri' are enabled and will be detected.
        | If 'domain', streams will check your sub-domain for an i18n locale key
        | If 'uri', streams will check your first URI segment for an i18n locale key
        |
        */
    
        'hint' => env('LOCALE_HINTS', true),
    
        /*
        |--------------------------------------------------------------------------
        | Enabled Locales
        |--------------------------------------------------------------------------
        |
        | Define an array of locales enabled for translatable input.
        |
        */
    
        'enabled' => explode(',', env('ENABLED_LOCALES', 'en')),
    
        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        |
        | The default locale for CONTENT.
        |
        */
    
        'default' => env('DEFAULT_LOCALE', env('LOCALE', 'en')),
    
    ],
];
