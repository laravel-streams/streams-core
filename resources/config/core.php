<?php

return [

    /**
     * Specify the base Streams definition.
     */
    'streams_id' => 'streams',

    /**
     * Specify the stream used for
     * multitenancy and applications.
     */
    'applications_id' => 'applications',

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
                'json' => \Streams\Core\Criteria\Format\Json::class,
                'yaml' => \Streams\Core\Criteria\Format\Yaml::class,
                'html' => \Streams\Core\Criteria\Format\Html::class,
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
        'number' => \Streams\Core\Field\Types\NumberFieldType::class,
        'integer' => \Streams\Core\Field\Types\IntegerFieldType::class,
        'decimal' => \Streams\Core\Field\Types\DecimalFieldType::class,

        // Strings
        'string' => \Streams\Core\Field\Types\StringFieldType::class,

        'url' => \Streams\Core\Field\Types\UrlFieldType::class,
        'uuid' => \Streams\Core\Field\Types\UuidFieldType::class,
        'hash' => \Streams\Core\Field\Types\HashFieldType::class,
        'slug' => \Streams\Core\Field\Types\SlugFieldType::class,
        'email' => \Streams\Core\Field\Types\EmailFieldType::class,
        'encrypted' => \Streams\Core\Field\Types\EncryptedFieldType::class,

        // Boolean
        'boolean' => \Streams\Core\Field\Types\BooleanFieldType::class,

        // Dates
        'datetime' => \Streams\Core\Field\Types\DatetimeFieldType::class,
        'date' => \Streams\Core\Field\Types\DateFieldType::class,
        'time' => \Streams\Core\Field\Types\TimeFieldType::class,

        // Selections
        'enum' => \Streams\Core\Field\Types\SelectFieldType::class,
        'select' => \Streams\Core\Field\Types\SelectFieldType::class,
        'multiselect' => \Streams\Core\Field\Types\MultiselectFieldType::class,

        // Arrays
        'array' => \Streams\Core\Field\Types\ArrayFieldType::class,

        // Objects
        'object' => \Streams\Core\Field\Types\ObjectFieldType::class,

        // Files
        'image' => \Streams\Core\Field\Types\ImageFieldType::class,
        'file' => \Streams\Core\Field\Types\FileFieldType::class,

        // Relationships
        'relationship' => \Streams\Core\Field\Types\RelationshipFieldType::class,
        'polymorphic' => \Streams\Core\Field\Types\PolymorphicFieldType::class,

        // Other
        'color' => \Streams\Core\Field\Types\ColorFieldType::class,
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
