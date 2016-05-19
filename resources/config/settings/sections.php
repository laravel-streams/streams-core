<?php

return [
    'general'   => [
        'title' => 'streams::label.general',
        'tabs'  => [
            'details' => [
                'context' => 'info',
                'title'   => 'streams::label.details',
                'fields'  => [
                    'name',
                    'description'
                ]
            ],
            'contact' => [
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
            ]
        ]
    ],
    'display'   => [
        'context' => 'info',
        'title'   => 'streams::label.display',
        'fields'  => [
            'standard_theme',
            'admin_theme',
            'per_page'
        ]
    ],
    'standards' => [
        'title' => 'streams::label.standards',
        'tabs'  => [
            'formats'      => [
                'context' => 'danger',
                'title'   => 'streams::label.formats',
                'fields'  => [
                    'timezone',
                    'date_format',
                    'time_format',
                    'unit_system',
                    'currency'
                ]
            ],
            'localization' => [
                'context' => 'info',
                'title'   => 'streams::label.localization',
                'fields'  => [
                    'default_locale',
                    'enabled_locales'
                ]
            ]
        ]
    ],
    'advanced'  => [
        'title' => 'streams::label.advanced',
        'tabs'  => [
            'email'       => [
                'context' => 'danger',
                'title'   => 'streams::label.email',
                'fields'  => [
                    'mail_debug',
                    'email',
                    'sender',
                    'mail_driver',
                    'mail_host',
                    'mail_port',
                    'mail_username',
                    'mail_password'
                ]
            ],
            'maintenance' => [
                'context' => 'danger',
                'title'   => 'streams::label.maintenance',
                'fields'  => [
                    'debug',
                    'maintenance',
                    'basic_auth',
                    'ip_whitelist'
                ]
            ]
        ]
    ],
];
