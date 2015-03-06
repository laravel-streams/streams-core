<?php

return [
    'name'           => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function () {
                return trans('distribution::addon.name');
            },
        ]
    ],
    'description'    => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function () {
                return trans('distribution::addon.description');
            },
        ]
    ],
    'date_format'    => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'n/j/Y',
        ]
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
            'default_value' => true,
            'on_text'       => 'anomaly.field_type.boolean::choice.enabled',
            'off_text'      => 'anomaly.field_type.boolean::choice.disabled',
            'off_style'     => 'danger'
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
    'mail_debug'     => 'anomaly.field_type.boolean'
];
