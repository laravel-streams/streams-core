<?php

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

return [

    /*
    |--------------------------------------------------------------------------
    | Name & Description
    |--------------------------------------------------------------------------
    |
    | These values provide very basic identification for your application.
    |
    */

    'name'            => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.name');
            },
        ]
    ],
    'description'     => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.description');
            },
        ]
    ],
    'email'           => [
        'type'   => 'anomaly.field_type.email',
        'config' => [
            'default_value' => function () {
                return env('ADMIN_EMAIL');
            },
        ]
    ],
    'business'        => [
        'type' => 'anomaly.field_type.text'
    ],
    'phone'           => [
        'type' => 'anomaly.field_type.text'
    ],
    'address'         => [
        'type' => 'anomaly.field_type.text'
    ],
    'address2'        => [
        'type' => 'anomaly.field_type.text'
    ],
    'city'            => [
        'type' => 'anomaly.field_type.text'
    ],
    'state'           => [
        'type' => 'anomaly.field_type.state'
    ],
    'postal_code'     => [
        'type' => 'anomaly.field_type.text'
    ],
    'country'         => [
        'type'   => 'anomaly.field_type.country',
        'config' => [
            'top_options' => [
                'US'
            ]
        ]
    ],
    'timezone'        => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'handler'       => 'timezones',
            'default_value' => config('app.timezone')
        ]
    ],
    'unit_system'     => [
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'default_value' => 'imperial',
            'options'       => [
                'imperial' => 'streams::setting.unit_system.option.imperial',
                'metric'   => 'streams::setting.unit_system.option.metric',
            ]
        ]
    ],
    'currency'        => [
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'handler'       => 'currencies',
            'default_value' => config('streams::currencies.default')
        ]
    ],
    'standard_theme'  => [
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'default_value' => env('STANDARD_THEME'),
            'options'       => function (ThemeCollection $themes) {
                return $themes->standard()->lists('title', 'namespace')->all();
            }
        ]
    ],
    'admin_theme'     => [
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'default_value' => env('ADMIN_THEME'),
            'options'       => function (ThemeCollection $themes) {
                return $themes->admin()->lists('title', 'namespace')->all();
            }
        ]
    ],
    'per_page'        => [
        'type'     => 'anomaly.field_type.integer',
        'required' => true,
        'config'   => [
            'default_value' => 15,
            'min'           => 5
        ]
    ],
    'default_locale'  => [
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'default_value' => config('streams::locales.default'),
            'options'       => function (Repository $config) {
                return array_combine(
                    $keys = array_keys($config->get('streams::locales.supported')),
                    array_map(
                        function ($locale) {
                            return trans('streams::locale.' . $locale . '.name') . ' (' . $locale . ')';
                        },
                        $keys
                    )
                );
            }
        ]
    ],
    'enabled_locales' => [
        'type'     => 'anomaly.field_type.checkboxes',
        'required' => true,
        'config'   => [
            'default_value' => config('streams::locales.enabled'),
            'options'       => function (Repository $config) {
                return array_combine(
                    $keys = array_keys($config->get('streams::locales.supported')),
                    array_map(
                        function ($locale) {
                            return trans('streams::locale.' . $locale . '.name') . ' (' . $locale . ')';
                        },
                        $keys
                    )
                );
            }
        ]
    ],
    'debug'           => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('app.debug');
            },
            'on_text'       => 'ON',
            'off_text'      => 'OFF'
        ]
    ],
    'maintenance'     => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'on_text'  => 'ON',
            'off_text' => 'OFF'
        ]
    ],
    'basic_auth'      => [
        'type' => 'anomaly.field_type.boolean'
    ],
    'ip_whitelist'    => [
        'type'   => 'anomaly.field_type.tags',
        'config' => [
            'filter' => 'FILTER_VALIDATE_IP'
        ]
    ],
];
