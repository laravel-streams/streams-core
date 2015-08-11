<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locale Hint
    |--------------------------------------------------------------------------
    |
    | Define where to look for an i18n locale.
    |
    | null, "domain" or "uri"
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
    | Enabled Locales
    |--------------------------------------------------------------------------
    |
    | Define an array of locales enabled for translatable input.
    |
    */

    'enabled' => env('ENABLED_LOCALES', ['en']),

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
        'en' => [
            'direction' => 'ltr'
        ],
        'fa' => [
            'direction' => 'rtl'
        ],
        'de' => [
            'direction' => 'ltr'
        ],
        'ar' => [
            'direction' => 'rtl'
        ],
        'cs' => [
            'direction' => 'ltr'
        ],
        'el' => [
            'direction' => 'ltr'
        ],
        'es' => [
            'direction' => 'ltr'
        ],
        'fr' => [
            'direction' => 'ltr'
        ],
        'it' => [
            'direction' => 'ltr'
        ],
        'nl' => [
            'direction' => 'ltr'
        ],
        'se' => [
            'direction' => 'ltr'
        ],
        'sl' => [
            'direction' => 'ltr'
        ],
        'pl' => [
            'direction' => 'ltr'
        ],
        'pt' => [
            'direction' => 'ltr'
        ],
        'br' => [
            'direction' => 'ltr'
        ],
        'ru' => [
            'direction' => 'ltr'
        ],
        'cn' => [
            'direction' => 'ltr'
        ],
        'tw' => [
            'direction' => 'ltr'
        ],
        'he' => [
            'direction' => 'rtl'
        ],
        'lt' => [
            'direction' => 'ltr'
        ],
        'fi' => [
            'direction' => 'ltr'
        ],
        'da' => [
            'direction' => 'ltr'
        ],
        'id' => [
            'direction' => 'ltr'
        ],
        'hu' => [
            'direction' => 'ltr'
        ],
        'th' => [
            'direction' => 'ltr'
        ],
        'hi' => [
            'direction' => 'ltr'
        ]
    ]
];
