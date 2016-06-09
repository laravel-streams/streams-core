<?php

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

return [
    'name'              => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.name');
            },
        ]
    ],
    'description'       => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.description');
            },
        ]
    ],
    'business'          => [
        'type' => 'anomaly.field_type.text'
    ],
    'phone'             => [
        'type' => 'anomaly.field_type.text'
    ],
    'address'           => [
        'type' => 'anomaly.field_type.text'
    ],
    'address2'          => [
        'type' => 'anomaly.field_type.text'
    ],
    'city'              => [
        'type' => 'anomaly.field_type.text'
    ],
    'state'             => [
        'type' => 'anomaly.field_type.state'
    ],
    'postal_code'       => [
        'type' => 'anomaly.field_type.text'
    ],
    'country'           => [
        'type'   => 'anomaly.field_type.country',
        'config' => [
            'top_options' => [
                'US'
            ]
        ]
    ],
    'timezone'          => [
        'env'    => 'APP_TIMEZONE',
        'bind'   => 'app.timezone',
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'handler'       => 'timezones',
            'default_value' => config('app.timezone')
        ]
    ],
    'date_format'       => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'options' => [
                'l, j F, Y' => function () {
                    return date('l, j F, Y'); // Friday, 10 July, 2015
                },
                'j F, Y'    => function () {
                    return date('j F, Y'); // 10 July, 2015
                },
                'j M, y'    => function () {
                    return date('j M, y'); // 10 Jul, 15
                },
                'm/d/Y'     => function () {
                    return date('m/d/Y'); // 07/10/2015
                },
                'Y-m-d'     => function () {
                    return date('Y-m-d'); // 2015-07-10
                }
            ]
        ]
    ],
    'time_format'       => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'options' => [
                'g:i A' => function () {
                    return date('g:00 A'); // 4:00 PM
                },
                'H:i'   => function () {
                    return date('H:00'); // 16:00
                }
            ]
        ]
    ],
    'unit_system'       => [
        'env'      => 'UNIT_SYSTEM',
        'bind'     => 'streams::system.unit_system',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => 'imperial',
            'options'       => [
                'imperial' => 'streams::setting.unit_system.option.imperial',
                'metric'   => 'streams::setting.unit_system.option.metric',
            ]
        ]
    ],
    'currency'          => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'handler'       => 'currencies',
            'default_value' => config('streams::currencies.default')
        ]
    ],
    'standard_theme'    => [
        'env'      => 'STANDARD_THEME',
        'bind'     => 'streams::themes.standard',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => env('STANDARD_THEME'),
            'options'       => function (ThemeCollection $themes) {
                return $themes->standard()->lists('title', 'namespace')->all();
            }
        ]
    ],
    'admin_theme'       => [
        'env'      => 'ADMIN_THEME',
        'bind'     => 'streams::themes.admin',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => env('ADMIN_THEME'),
            'options'       => function (ThemeCollection $themes) {
                return $themes->admin()->lists('title', 'namespace')->all();
            }
        ]
    ],
    'per_page'          => [
        'env'      => 'RESULTS_PER_PAGE',
        'bind'     => 'streams::system.per_page',
        'type'     => 'anomaly.field_type.integer',
        'required' => true,
        'config'   => [
            'default_value' => 15,
            'min'           => 5
        ]
    ],
    'default_locale'    => [
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
            }
        ]
    ],
    'enabled_locales'   => [
        'env'      => 'ENABLED_LOCALES',
        'bind'     => 'streams::locales.enabled',
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
    'debug'             => [
        'env'    => 'APP_DEBUG',
        'bind'   => 'app.debug',
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('app.debug');
            },
            'on_text'       => 'ON',
            'off_text'      => 'OFF'
        ]
    ],
    'maintenance'       => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'on_text'  => 'ON',
            'off_text' => 'OFF'
        ]
    ],
    'basic_auth'        => [
        'env'  => 'MAINTENANCE_AUTH',
        'bind' => 'streams::maintenance.auth',
        'type' => 'anomaly.field_type.boolean'
    ],
    'ip_whitelist'      => [
        'env'    => 'IP_WHITELIST',
        'bind'   => 'streams::maintenance.ip_whitelist',
        'type'   => 'anomaly.field_type.tags',
        'config' => [
            'filter' => 'FILTER_VALIDATE_IP'
        ]
    ],
    'mail_debug'        => [
        'env'    => 'MAIL_DEBUG',
        'bind'   => 'mail.debug',
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => function (Repository $config) {
                return $config->get('mail.pretend');
            },
            'on_text'       => 'ON',
            'off_text'      => 'OFF'
        ]
    ],
    'email'             => [
        'bind'     => 'mail.from.address',
        'type'     => 'anomaly.field_type.email',
        'required' => true,
        'config'   => [
            'default_value' => function () {
                return env('ADMIN_EMAIL');
            },
        ]
    ],
    'sender'            => [
        'bind'     => 'mail.from.name',
        'type'     => 'anomaly.field_type.text',
        'required' => true,
        'config'   => [
            'default_value' => function (Repository $config) {
                return $config->get('streams::distribution.name');
            },
        ]
    ],
    'mail_driver'       => [
        'env'      => 'MAIL_DRIVER',
        'bind'     => 'mail.driver',
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => config('mail.driver'),
            'options'       => [
                'smtp'     => 'streams::setting.mail_driver.option.smtp',
                'mail'     => 'streams::setting.mail_driver.option.mail',
                'sendmail' => 'streams::setting.mail_driver.option.sendmail',
                'mailgun'  => 'streams::setting.mail_driver.option.mailgun',
                'log'      => 'streams::setting.mail_driver.option.log',
                'ses'      => 'streams::setting.mail_driver.option.ses'
            ]
        ]
    ],
    'mail_host'         => [
        'env'    => 'MAIL_HOST',
        'bind'   => 'mail.host',
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => config('mail.host')
        ]
    ],
    'mail_port'         => [
        'env'    => 'MAIL_PORT',
        'bind'   => 'mail.port',
        'type'   => 'anomaly.field_type.integer',
        'config' => [
            'default_value' => config('mail.port')
        ]
    ],
    'mail_username'     => [
        'env'    => 'MAIL_USERNAME',
        'bind'   => 'mail.username',
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => config('mail.username')
        ]
    ],
    'mail_password'     => [
        'env'    => 'MAIL_PASSWORD',
        'bind'   => 'mail.password',
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => config('mail.password'),
            'type'          => 'password'
        ]
    ],
];
