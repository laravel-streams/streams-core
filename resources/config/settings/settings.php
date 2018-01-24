<?php

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

return [
    'name'            => [
        'env'    => 'APP_NAME',
        'bind'   => 'app.name',
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.name');
            },
        ],
    ],
    'description'     => [
        'type'   => 'anomaly.field_type.text',
        'bind'   => 'app.description',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.description');
            },
        ],
    ],
    'timezone'        => [
        'env'    => 'APP_TIMEZONE',
        'bind'   => 'app.timezone',
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'handler'       => 'timezones',
            'default_value' => config('app.timezone'),
        ],
    ],
    'date_format'     => [
        'env'         => 'DATE_FORMAT',
        'bind'        => 'streams::datetime.date_format',
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'options' => [
                'j F, Y' => function () {
                    return date('j F, Y'); // 10 July, 2015
                },
                'j M, y' => function () {
                    return date('j M, y'); // 10 Jul, 15
                },
                'm/d/Y'  => function () {
                    return date('m/d/Y'); // 07/10/2015
                },
                'd/m/Y'  => function () {
                    return date('d/m/Y'); // 10/07/2015
                },
                'Y-m-d'  => function () {
                    return date('Y-m-d'); // 2015-07-10
                },
            ],
        ],
    ],
    'time_format'     => [
        'env'         => 'TIME_FORMAT',
        'bind'        => 'streams::datetime.time_format',
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'options' => [
                'g:i A' => function () {
                    return date('g:i A'); // 4:00 PM
                },
                'g:i a' => function () {
                    return date('g:i a'); // 4:00 pm
                },
                'H:i'   => function () {
                    return date('H:i'); // 16:00
                },
            ],
        ],
    ],
    'unit_system'     => [
        'env'      => 'UNIT_SYSTEM',
        'bind'     => 'streams::system.unit_system',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => 'imperial',
            'options'       => [
                'imperial' => 'streams::setting.unit_system.option.imperial',
                'metric'   => 'streams::setting.unit_system.option.metric',
            ],
        ],
    ],
    'currency'        => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'handler'       => 'currencies',
            'default_value' => config('streams::currencies.default'),
        ],
    ],
    'standard_theme'  => [
        'env'      => 'STANDARD_THEME',
        'bind'     => 'streams::themes.standard',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::themes.standard');
            },
            'options'       => function (ThemeCollection $themes) {
                return $themes->standard()->pluck('title', 'namespace')->all();
            },
        ],
    ],
    'admin_theme'     => [
        'env'      => 'ADMIN_THEME',
        'bind'     => 'streams::themes.admin',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::themes.admin');
            },
            'options'       => function (ThemeCollection $themes) {
                return $themes->admin()->pluck('title', 'namespace')->all();
            },
        ],
    ],
    'per_page'        => [
        'env'      => 'RESULTS_PER_PAGE',
        'bind'     => 'streams::system.per_page',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => 15,
            'options'       => [
                5   => 5,
                10  => 10,
                15  => 15,
                25  => 25,
                50  => 50,
                75  => 75,
                100 => 100,
                150 => 150,
            ],
        ],
    ],
    'default_locale'  => [
        'env'      => 'DEFAULT_LOCALE',
        'bind'     => 'streams::locales.default',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
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
            },
        ],
    ],
    'enabled_locales' => [
        'env'      => 'ENABLED_LOCALES',
        'bind'     => 'streams::locales.enabled',
        'type'     => 'anomaly.field_type.checkboxes',
        'required' => true,
        'config'   => [
            'default_value' => function () {
                return [config('streams::locales.default')];
            },
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
            },
        ],
    ],
    'debug'           => [
        'env'    => 'APP_DEBUG',
        'bind'   => 'app.debug',
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('app.debug');
            },
            'on_text'       => 'ON',
            'off_text'      => 'OFF',
        ],
    ],
    'maintenance'     => [
        'type'   => 'anomaly.field_type.boolean',
        'value'  => function (Application $application) {
            return $application->isDownForMaintenance();
        },
        'config' => [
            'on_text'  => 'ON',
            'off_text' => 'OFF',
        ],
    ],
    'basic_auth'      => [
        'env'  => 'MAINTENANCE_AUTH',
        'bind' => 'streams::maintenance.auth',
        'type' => 'anomaly.field_type.boolean',
    ],
    'ip_whitelist'    => [
        'env'    => 'IP_WHITELIST',
        'bind'   => 'streams::maintenance.ip_whitelist',
        'type'   => 'anomaly.field_type.tags',
        'config' => [
            'filter' => 'FILTER_VALIDATE_IP',
        ],
    ],
    'email'           => [
        'env'      => 'FROM_ADDRESS',
        'bind'     => 'mail.from.address',
        'type'     => 'anomaly.field_type.email',
        'required' => true,
        'config'   => [
            'default_value' => function (Repository $config) {

                $host = array_get(parse_url($config->get('app.url')), 'host');

                return 'noreply@' . (str_contains($host, '.') ? $host : $host . '.com');
            },
        ],
    ],
    'sender'          => [
        'env'      => 'FROM_NAME',
        'bind'     => 'mail.from.name',
        'type'     => 'anomaly.field_type.text',
        'required' => true,
        'config'   => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.name');
            },
        ],
    ],
];
