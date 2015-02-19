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
            'default_value' => 'm/d/Y',
        ]
    ],
    'default_locale' => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => config('app.locale'),
            'options'       => function () {

                $options = [];

                foreach (config('streams::config.available_locales') as $locale) {
                    $options[$locale] = trans('streams::language.' . $locale);
                }

                return $options;
            }
        ],
    ],
    'status'         => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => true,
            'on_text'       => 'anomaly.field_type.boolean::choice.enabled',
            'off_text'      => 'anomaly.field_type.boolean::choice.disabled',
            'off_style'     => 'danger'
        ]
    ],
    'ip_whitelist'   => 'anomaly.field_type.textarea',
    'force_https'    => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'default_value' => 'no',
            'options'       => [
                'yes'           => 'streams::setting.force_https.option.yes',
                'no'            => 'streams::setting.force_https.option.no',
                'control_panel' => 'streams::setting.force_https.option.control_panel',
                'public'        => 'streams::setting.force_https.option.public'
            ]
        ],
    ],
];
