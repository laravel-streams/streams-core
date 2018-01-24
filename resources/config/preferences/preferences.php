<?php

return [
    'per_page'    => [
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
    'timezone'    => [
        'env'    => 'APP_TIMEZONE',
        'bind'   => 'app.timezone',
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'handler'       => 'timezones',
            'default_value' => config('app.timezone'),
        ],
    ],
    'date_format' => [
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
    'time_format' => [
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
];
