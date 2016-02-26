<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Name & Description
    |--------------------------------------------------------------------------
    |
    | These values provide very basic identification for your application.
    |
    */

    'name'        => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function () {
                return config('streams::distribution.name');
            },
        ]
    ],
    'description' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function () {
                return config('streams::distribution.description');
            },
        ]
    ]
];
