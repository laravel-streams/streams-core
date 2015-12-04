<?php

return [
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
