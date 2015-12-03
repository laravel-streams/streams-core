<?php

return [
    [
        'section' => 'tabbed',
        'tabs'    => [
            'general'      => [
                'title'  => 'streams::tab.general',
                'fields' => [
                    'name',
                    'description'
                ]
            ],
            'datetime'     => [
                'title'  => 'streams::tab.datetime',
                'fields' => [
                    'default_timezone',
                    'date_format',
                    'time_format'
                ]
            ],
            'localization' => [
                'title'  => 'streams::tab.localization',
                'fields' => [
                    'default_locale',
                    'enabled_locales'
                ]
            ],
            'access'       => [
                'title'  => 'streams::tab.access',
                'fields' => [
                    'force_https'
                ]
            ],
            'maintenance'  => [
                'title'  => 'streams::tab.maintenance',
                'fields' => [
                    'maintenance_mode',
                    '503_message',
                    'ip_whitelist',
                    'basic_auth'
                ]
            ],
            'email'        => [
                'title'  => 'streams::tab.email',
                'fields' => [
                    'contact_email',
                    'server_email',
                    'mail_driver',
                    'mail_host',
                    'mail_port',
                    'mail_username',
                    'mail_password',
                    'mail_debug',
                    'mailgun_domain',
                    'mailgun_secret',
                    'mandrill_secret'
                ]
            ]
        ]
    ]
];
