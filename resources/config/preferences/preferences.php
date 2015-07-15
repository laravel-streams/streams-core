<?php

return [
    'admin_locale'  => [
        'type'     => 'anomaly.field_type.language',
        'required' => true,
        'config'   => [
            'available_locales' => true
        ]
    ],
    'public_locale' => [
        'type'     => 'anomaly.field_type.language',
        'required' => true,
        'config'   => [
            'available_locales' => true
        ]
    ]
];
