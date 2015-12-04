<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled Currencies
    |--------------------------------------------------------------------------
    |
    | Define an array of currencies enabled for translatable input.
    |
    */

    'enabled'   => explode(',', env('ENABLED_CURRENCIES', 'USD')),

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | In order to enable a currency or use it at all
    | the ISO currency code MUST be in this array.
    |
    */

    'supported' => [
        [
            'USD' => [
                'symbol' => '$'
            ]
        ]
    ]
];
