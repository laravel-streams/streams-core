<?php

return [
    'timezone'      => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => config('app.timezone'),
            'options'       => function () {
                return array_combine(timezone_identifiers_list(), timezone_identifiers_list());
            }
        ],
    ],
    'date_format'   => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => config('streams::datetime.date_format'),
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
    'time_format'   => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'default_value' => config('streams::datetime.time_format'),
            'options'       => [
                'g:i A' => date('g:i A'),
                'G:i A' => date('G:i A') . ' (24 hr)'
            ]
        ],
    ],
    'admin_locale'  => [
        'type'        => 'anomaly.field_type.language',
        'required'    => true,
        'placeholder' => false,
        'config'      => [
            'default_value'     => config('app.locale'),
            'available_locales' => true
        ]
    ],
    'public_locale' => [
        'type'        => 'anomaly.field_type.language',
        'required'    => true,
        'placeholder' => false,
        'config'      => [
            'default_value'     => config('app.locale'),
            'available_locales' => true
        ]
    ]
];
