# Migrations

- [Introduction](#introduction)
- [Addon Migrations](#addon-migrations)
- [Stream Migrations](#stream-migrations)

<hr>

<a name="introduction"></a>
## Introduction

Migrations in PyroCMS works exactly the same as [migrations in Laravel](https://laravel.com/docs/5.1/migrations).

<a name="addon-migrations"></a>
### Addon Migrations

It is encouraged to bundle your migrations and project logic into addons. To create a migration in an addon you may use the `--addon` flag.

    php artisan make:migration create_awesome --addon=foo.module.example

<a name="stream-migrations"></a>
### Stream Migrations

Migrations help you quickly create Streams, Fields, and Field Assignments. To get started simply create a migration using the command above.

#### Creating Fields

Even though fields, streams, and assignments can all be done in one migration it's suggested to keep them separate.

    php artisan make:migration create_module_fields --addon=foo.module.example

Now open the migration class and define your fields.

    protected $fields = [
        'name'    => 'anomaly.field_type.text',
        'image'   => [
            'type'   => 'anomaly.field_type.file',
            'config' => [
                'folders' => ['images']
            ]
        ],
        'enabled' => [
            'type'   => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => true,
            ]
        ],
    ];

**Note that none of the fields provide a namespace even though the namespace is required in the fields table. By default the namespace will be guessed based on your addon's slug.**

<div class="alert alert-info">
<strong>Note:</strong> A fields migration is automatically created for modules when using the make:addon command.
</div>

#### Creating Streams

Now that we have some fields available from our first migration we need to create a stream and assign those fields to it.

    php artisan make:migration create_example_stream --addon=foo.module.example

Again, open the migration class and define your stream and it's field assignments.

    protected $stream = [
        'slug'         => 'example',
        'title_column' => 'name',
        'sortable'     => true,
        'trashable'    => true,
        'translatable' => true,
    ];

    protected $assignments = [
        'name'   => [
            'unique'       => true,
            'required'     => true,
            'translatable' => true,
        ],
        'image'     => [
            'required' => true
        ],
        'enabled'
    ];

<div class="alert alert-info">
<strong>Note:</strong> Stream migrations are automatically created when using the make:stream command.
</div>

Now when you migrate, reset, or refresh migrations for the addon the fields, stream, and assignments will be handled automatically. Now you have a beautiful, human readable database schema and the leverage of Streams at your ready.

    php artisan migrate --addon=foo.module.example

**When you install an module or extension it's migrations are ran automatically.**

Anytime a stream is created or saved it automatically refreshes it's compiled addons. No other changes in code are necessary.

<div class="alert alert-primary">
<strong>Pro Tip:</strong> Refresh migrations often while developing your addon's schema to help incrementally test your desired data structure.
</div>
