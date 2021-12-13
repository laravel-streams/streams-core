---
title: Configuration
category: getting_started
intro: Configuring the core.
sort: 2
enabled: true
---

## Configuration Files

Published configuration files reside in `config/streams/`.

``` files
├── config/streams/
│   └── core.php
```

### Publishing Configuration

Use the following command to publish configuration files.

```bash
php artisan vendor:publish --provider=Streams\\Core\\StreamsServiceProvider --tag=config
```

The above command will copy configuration files from their package location to the directory mentioned above so that you can modify them directly and commit them to your version control system.

## Configuring Streams Core

Below are the contents of the published configuration file:

```php
// config/streams/core.php
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
        'object' => \Streams\Core\Field\Type\Structure::class,
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

    'markdown' => [
        'configs' => [
            'commonmark' => [
                'use_asterisk' => true,
                'use_underscore' => true,
                'enable_strong' => true,
                'enable_em' => true,
                'unordered_list_markers' => [ '*', '+', '-' ],
            ],
            'disallowed_raw_html' => [
                'disallowed_tags' => [
                    'title',
                    'textarea',
                    'style',
                    'xmp',
                    'iframe',
                    'noembed',
                    'noframes',
                    'script',
                    'plaintext',
                ],
            ],
        ],
        'extensions' => [
            \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
            \League\CommonMark\Extension\Autolink\AutolinkExtension::class,
            \League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension::class,
            \League\CommonMark\Extension\Strikethrough\StrikethroughExtension::class,
            \League\CommonMark\Extension\Table\TableExtension::class,
            \League\CommonMark\Extension\TaskList\TaskListExtension::class,
        ],
    ],
];
```
