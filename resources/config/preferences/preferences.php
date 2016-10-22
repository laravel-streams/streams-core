<?php

use Illuminate\Contracts\Config\Repository;

return [
    'per_page'    => [
        'env'      => 'RESULTS_PER_PAGE',
        'bind'     => 'streams::system.per_page',
        'type'     => 'anomaly.field_type.integer',
        'required' => true,
        'config'   => [
            'default_value' => 15,
            'min'           => 5
        ]
    ],
    'timezone'    => [
        'env'    => 'APP_TIMEZONE',
        'bind'   => 'app.timezone',
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'handler'       => 'timezones',
            'default_value' => function (Repository $config) {
                return $config->get('app.timezone');
            }
        ]
    ],
    'date_format' => [
        'env'         => 'DATE_FORMAT',
        'bind'        => 'streams::datetime.date_format',
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
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
                'd/m/Y'     => function () {
                    return date('d/m/Y'); // 10/07/2015
                },
                'Y-m-d'     => function () {
                    return date('Y-m-d'); // 2015-07-10
                }
            ]
        ]
    ],
    'time_format' => [
        'env'         => 'TIME_FORMAT',
        'bind'        => 'streams::datetime.time_format',
        'type'        => 'anomaly.field_type.select',
        'placeholder' => false,
        'required'    => true,
        'config'      => [
            'options' => [
                'g:i A' => function () {
                    return date('g:00 A'); // 4:00 PM
                },
                'H:i'   => function () {
                    return date('H:00'); // 16:00
                }
            ]
        ]
    ]
];
