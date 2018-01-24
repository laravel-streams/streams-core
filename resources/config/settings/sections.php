<?php

return [
    'details'      => [
        'context' => 'info',
        'title'   => 'streams::label.details',
        'fields'  => [
            'name',
            'description',
        ],
    ],
    'display'      => [
        'context' => 'info',
        'title'   => 'streams::label.display',
        'fields'  => [
            'standard_theme',
            'admin_theme',
            'per_page',
        ],
    ],
    'formats'      => [
        'context' => 'danger',
        'title'   => 'streams::label.formats',
        'fields'  => [
            'timezone',
            'date_format',
            'time_format',
            'unit_system',
            'currency',
        ],
    ],
    'localization' => [
        'context' => 'info',
        'title'   => 'streams::label.localization',
        'fields'  => [
            'default_locale',
            'enabled_locales',
        ],
    ],
    'email'        => [
        'context' => 'danger',
        'title'   => 'streams::label.email',
        'fields'  => [
            'email',
            'sender',
        ],
    ],
    'maintenance'  => [
        'context' => 'danger',
        'title'   => 'streams::label.maintenance',
        'fields'  => [
            'debug',
            'maintenance',
            'basic_auth',
            'ip_whitelist',
        ],
    ],
];
