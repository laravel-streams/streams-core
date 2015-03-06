<?php

return [
    [
        'section' => 'tabbed',
        'tabs'    => [
            'general' => [
                'title'  => 'streams::tab.general',
                'fields' => [
                    'name',
                    'description',
                    'date_format',
                    'default_locale',
                    'site_enabled',
                    '503_message',
                    'ip_whitelist',
                    'force_https',
                    'contact_email',
                    'server_email',
                ]
            ]
        ]
    ]
];
