<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Force SSL
    |--------------------------------------------------------------------------
    |
    | Force requests to use SSL
    |
    */

    'force_ssl' => env('FORCE_SSL', false),

    /*
    |--------------------------------------------------------------------------
    | Results Per Page
    |--------------------------------------------------------------------------
    |
    | This is the global default number of results
    | to display on each page.
    |
    */

    'per_page' => env('RESULTS_PER_PAGE', 15),

    /*
    |--------------------------------------------------------------------------
    | Units of Measurement
    |--------------------------------------------------------------------------
    |
    | Which measurement system do you use? 'imperial' or 'metric'
    |
    */

    'unit_system' => env('UNIT_SYSTEM', 'imperial'),

    /*
    |--------------------------------------------------------------------------
    | Lazy Translations
    |--------------------------------------------------------------------------
    |
    | Do you want to guess strings for missing translation keys?
    |
    | By default generators will automate a suggested translation key
    | paradigm for you. Enabling this feature is helpful for rapidly
    | building and deploying addons that don't require fulfilled
    | translation files but can easily support them at a later
    | date if needed. With this feature disabled it is easy
    | to spot what translations need to be added still.
    |
    | Example:
    |
    | A field with the name key "anomaly.module.store::field.product_type.name"
    | would gracefully fallback to "Product Type" if the translation file has
    | not been included with the "product_type" field's name.
    |
    |
    */

    'lazy_translations' => env('LAZY_TRANSLATIONS'),
];
