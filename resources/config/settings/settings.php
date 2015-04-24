<?php

return [
    'name'           => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function () {
                return config('streams.app.name');
            },
        ]
    ],
    'description'    => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function () {
                return config('streams.app.description');
            },
        ]
    ],
    'date_format'    => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => config('streams.date_format'),
            'options'       => [
                'Y/n/j'     => date('Y/n/j'),
                'n/j/Y'     => date('n/j/Y'),
                'M j, Y'    => date('M j, Y'),
                'D M j, Y'  => date('D M j, Y'),
                'F jS, Y'   => date('F jS, Y'),
                'l F jS, Y' => date('l F jS, Y'),
            ]
        ],
    ],
    'time_format'    => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => config('streams.time_format'),
            'options'       => [
                'g:i A' => date('g:i A'),
                'G:i A' => date('G:i A') . ' (24 hr)'
            ]
        ],
    ],
    'default_locale' => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'options' => function () {
                return config('streams.available_locales');
            }
        ],
    ],
    'site_enabled'   => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => true
        ]
    ],
    '503_message'    => [
        'type'   => 'anomaly.field_type.textarea',
        'config' => [
            'default_value' => function () {
                return 'streams::message.503';
            }
        ]
    ],
    'ip_whitelist'   => 'anomaly.field_type.tags',
    'force_https'    => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => 'none',
            'options'       => [
                'all'    => 'streams::setting.force_https.option.all',
                'none'   => 'streams::setting.force_https.option.none',
                'admin'  => 'streams::setting.force_https.option.admin',
                'public' => 'streams::setting.force_https.option.public'
            ]
        ],
    ],
    'contact_email'  => [
        'type'   => 'anomaly.field_type.email',
        'config' => [
            'default_value' => function () {
                return app('auth')->user()->email;
            },
        ]
    ],
    'server_email'   => [
        'type'   => 'anomaly.field_type.email',
        'config' => [
            'default_value' => function () {
                return app('auth')->user()->email;
            },
        ]
    ],
    'mail_driver'    => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => 'mail',
            'options'       => [
                'smtp'     => 'streams::setting.mail_driver.option.smtp',
                'mail'     => 'streams::setting.mail_driver.option.mail',
                'sendmail' => 'streams::setting.mail_driver.option.sendmail',
                'mailgun'  => 'streams::setting.mail_driver.option.mailgun',
                'mandrill' => 'streams::setting.mail_driver.option.mandrill',
                'log'      => 'streams::setting.mail_driver.option.log'
            ]
        ],
    ],
    'smtp_host'      => 'anomaly.field_type.text',
    'smtp_port'      => 'anomaly.field_type.integer',
    'smtp_username'  => 'anomaly.field_type.text',
    'smtp_password'  => 'anomaly.field_type.text',
    'mail_debug'     => 'anomaly.field_type.boolean',
    'cache_driver'   => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => config('cache.default'),
            'options'       => [
                'file' => 'streams::setting.cache_driver.option.file'
            ]
        ],
    ],
];
