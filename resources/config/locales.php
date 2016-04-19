<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locale Hint
    |--------------------------------------------------------------------------
    |
    | Define where to look for an i18n locale.
    |
    | true, false, "domain" or "uri"
    |
    | If false, you must handle setting the locale yourself.
    | If true, both "domain" and "uri" are enabled and will be detected.
    | If "domain", streams will check your sub-domain for an i18n locale key
    | If "uri", streams will check your first URI segment for an i18n locale key
    |
    */

    'hint' => true,

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

    'lazy' => env('LAZY_TRANSLATIONS', false),

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

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | In order to enable a locale or translate anything
    | the i18n locale key MUST be in this array.
    |
    */

    'supported' => [
        'en'    => [
            'direction' => 'ltr'
        ],
        'fa'    => [
            'direction' => 'rtl'
        ],
        'de'    => [
            'direction' => 'ltr'
        ],
        'ar'    => [
            'direction' => 'rtl'
        ],
        'cs'    => [
            'direction' => 'ltr'
        ],
        'el'    => [
            'direction' => 'ltr'
        ],
        'es'    => [
            'direction' => 'ltr'
        ],
        'et'    => [
            'direction' => 'ltr'
        ],
        'fr'    => [
            'direction' => 'ltr'
        ],
        'fr-ca' => [
            'direction' => 'ltr'
        ],
        'it'    => [
            'direction' => 'ltr'
        ],
        'nl'    => [
            'direction' => 'ltr'
        ],
        'sv'    => [
            'direction' => 'ltr'
        ],
        'sl'    => [
            'direction' => 'ltr'
        ],
        'sme'   => [
            'direction' => 'ltr'
        ],
        'pl'    => [
            'direction' => 'ltr'
        ],
        'pt'    => [
            'direction' => 'ltr'
        ],
        'br'    => [
            'direction' => 'ltr'
        ],
        'ru'    => [
            'direction' => 'ltr'
        ],
        'zh-cn' => [
            'direction' => 'ltr'
        ],
        'zh-tw' => [
            'direction' => 'ltr'
        ],
        'he'    => [
            'direction' => 'rtl'
        ],
        'lt'    => [
            'direction' => 'ltr'
        ],
        'fi'    => [
            'direction' => 'ltr'
        ],
        'da'    => [
            'direction' => 'ltr'
        ],
        'id'    => [
            'direction' => 'ltr'
        ],
        'hu'    => [
            'direction' => 'ltr'
        ],
        'th'    => [
            'direction' => 'ltr'
        ],
        'hi'    => [
            'direction' => 'ltr'
        ]
    ]
];
