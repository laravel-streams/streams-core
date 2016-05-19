<?php

return [
    'details'      => [
        'context' => 'info',
        'title'   => 'streams::label.details',
        'fields'  => [
            'name',
            'description'
        ]
    ],
    'contact'      => [
        'context' => 'primary',
        'title'   => 'streams::label.contact',
        'fields'  => [
            'business',
            'phone',
            'address',
            'address2',
            'city',
            'state',
            'postal_code',
            'country'
        ]
    ],
    'appearance'   => [
        'context' => 'success',
        'title'   => 'streams::label.appearance',
        'fields'  => [
            'standard_theme',
            'admin_theme'
        ]
    ],
    'formats'      => [
        'context' => 'danger',
        'title'   => 'streams::label.formats',
        'fields'  => [
            'timezone',
            'unit_system',
            'currency'
        ]
    ],
    'localization' => [
        'context' => 'info',
        'title'   => 'streams::label.localization',
        'fields'  => [
            'locale',
            'locales'
        ]
    ],
    'maintenance'  => [
        'context' => 'danger',
        'title'   => 'streams::label.maintenance',
        'fields'  => [
            'debug_mode',
            'maintenance_mode',
            'basic_auth',
            'ip_whitelist'
        ]
    ]
];
