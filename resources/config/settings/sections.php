<?php

return [
    'system' => [
        'stacked' => true,
        'tabs'    => [
            'details'      => [
                'title'  => 'streams::label.details',
                'fields' => [
                    'name',
                    'description',
                ],
            ],
            'display'      => [
                'title'  => 'streams::label.display',
                'fields' => [
                    'standard_theme',
                    'admin_theme',
                    'per_page',
                ],
            ],
            'formats'      => [
                'title'  => 'streams::label.formats',
                'fields' => [
                    'timezone',
                    'date_format',
                    'time_format',
                    'unit_system',
                    'currency',
                ],
            ],
            'localization' => [
                'title'  => 'streams::label.localization',
                'fields' => [
                    'default_locale',
                    'enabled_locales',
                ],
            ],
            'email'        => [
                'title'  => 'streams::label.email',
                'fields' => [
                    'email',
                    'sender',
                    'mail_driver',
                    'mail_host',
                    'mail_port',
                    'mail_username',
                    'mail_password',
                ],
            ],
            'maintenance'  => [
                'title'  => 'streams::label.maintenance',
                'fields' => [
                    'debug',
                    'debug_bar',
                    'maintenance',
                    'basic_auth',
                    'ip_whitelist',
                ],
            ],
        ],
    ],
];
