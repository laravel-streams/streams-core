<?php

return [

    /**
     * Specify the default directory for VCS compatible (file based) data.
     */
    'data_path' => env('STREAMS_DATA_PATH', 'streams/data'),

    /**
     * Specify the default source adapter for streams.
     */
    'default_source' => env('STREAMS_SOURCE', 'filebase'),

    /**
     * Configurable options for source adapters.
     */
    'sources' => [

        'filebase' => [

            'default_format' => env('STREAMS_DEFAULT_FORMAT', 'json'),

            'formats' => [
                'php' => \Streams\Core\Criteria\Format\Php::class,
                'json' => \Streams\Core\Criteria\Format\Json::class,
                'yaml' => \Streams\Core\Criteria\Format\Yaml::class,
                'md' => \Streams\Core\Criteria\Format\Markdown::class,
                'tpl' => \Streams\Core\Criteria\Format\Template::class,
            ],
        ],
    ],

    /**
     * Configure the default field types.
     */
    'field_types' => [

        // Numbers
        'number' => \Streams\Core\Field\Type\Number::class,
        'integer' => \Streams\Core\Field\Type\Integer::class,
        'decimal' => \Streams\Core\Field\Type\Decimal::class,

        // Strings
        'string' => \Streams\Core\Field\Type\Str::class,

        'url' => \Streams\Core\Field\Type\Url::class,
        'uuid' => \Streams\Core\Field\Type\Uuid::class,
        'hash' => \Streams\Core\Field\Type\Hash::class,
        'slug' => \Streams\Core\Field\Type\Slug::class,
        'email' => \Streams\Core\Field\Type\Email::class,
        'encrypted' => \Streams\Core\Field\Type\Encrypted::class,

        // Markup
        'markdown' => \Streams\Core\Field\Type\Markdown::class,
        'template' => \Streams\Core\Field\Type\Template::class,

        // Boolean
        'boolean' => \Streams\Core\Field\Type\Boolean::class,

        // Dates
        'datetime' => \Streams\Core\Field\Type\Datetime::class,
        'date' => \Streams\Core\Field\Type\Date::class,
        'time' => \Streams\Core\Field\Type\Time::class,

        // Arrays
        'array' => \Streams\Core\Field\Type\Arr::class,

        // Selections
        'select' => \Streams\Core\Field\Type\Select::class,
        'multiselect' => \Streams\Core\Field\Type\Multiselect::class,

        // Collections
        // @todo Test me
        // 'collection' => \Streams\Core\Field\Type\Collection::class,

        // Objects
        'prototype' => \Streams\Core\Field\Type\Prototype::class,
        'object' => \Streams\Core\Field\Type\Prototype::class,
        'image' => \Streams\Core\Field\Type\Image::class,
        'file' => \Streams\Core\Field\Type\File::class,

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

    /**
     * Enabling this feature automatically
     * generages alt tags when not specified.
     */
    'auto_alt' => env('STREAMS_AUTO_ALT', true),

    /**
     * Enabling this feature automatically
     * generates version control query
     * parameters when generating
     * image URLs and output.
     */
    'version_images' => env('STREAMS_VERSION_IMAGES', true),
];
