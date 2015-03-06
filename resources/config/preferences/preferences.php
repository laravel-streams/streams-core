<?php

return [
    'locale' => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'options' => function () {
                return config('streams.available_locales');
            }
        ],
    ],
];
