<?php

use Illuminate\Contracts\Config\Repository;

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
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.name');
            },
        ]
    ],
    'description' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.description');
            },
        ]
    ]
];
