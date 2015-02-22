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
    'date_format'    => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'n/j/Y',
        ]
    ],
    'default_locale' => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => config('app.locale'),
            'options'       => function () {

                $options = [];

                foreach (config('streams.available_locales') as $locale) {
                    $options[$locale] = trans('streams::language.' . $locale);
                }

                return $options;
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
                'all'           => 'streams::setting.force_https.option.all',
                'none'          => 'streams::setting.force_https.option.none',
                'control_panel' => 'streams::setting.force_https.option.control_panel',
                'public'        => 'streams::setting.force_https.option.public'
            ]
        ],
    ],
];
