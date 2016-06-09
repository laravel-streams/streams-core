<?php

return [
    'name'              => [
        'label'        => 'Site Name',
        'instructions' => 'What is the name of your application?',
        'placeholder'  => trans('distribution::addon.name')
    ],
    'description'       => [
        'label'        => 'Site Description',
        'instructions' => 'What is the description or slogan of your application?',
        'placeholder'  => trans('distribution::addon.description')
    ],
    'business'          => [
        'label'        => 'Business Name',
        'instructions' => 'What is the legal name of your business?'
    ],
    'phone'             => [
        'label'        => 'Contact Phone',
        'instructions' => 'Specify a general contact phone number.'
    ],
    'address'           => [
        'label' => 'Address'
    ],
    'address2'          => [
        'label' => 'Apt, suite, etc.'
    ],
    'city'              => [
        'label' => 'City'
    ],
    'state'             => [
        'label' => 'State / Province'
    ],
    'postal_code'       => [
        'label' => 'Postal / ZIP Code'
    ],
    'country'           => [
        'label' => 'Country'
    ],
    'timezone'          => [
        'label'        => 'Timezone',
        'instructions' => 'Specify the default timezone for your site.'
    ],
    'unit_system'       => [
        'label'        => 'Unit System',
        'instructions' => 'Specify the unit system for your site.',
        'option'       => [
            'imperial' => 'Imperial System',
            'metric'   => 'Metric System'
        ]
    ],
    'currency'          => [
        'label'        => 'Currency',
        'instructions' => 'Specify the default currency for your site.'
    ],
    'date_format'       => [
        'label'        => 'Date Format',
        'instructions' => 'Specify the default date format for your site.'
    ],
    'time_format'       => [
        'label'        => 'Time Format',
        'instructions' => 'Specify the default time format for your site.'
    ],
    'default_locale'    => [
        'label'        => 'Language',
        'instructions' => 'Specify the default language for your site.'
    ],
    'enabled_locales'   => [
        'label'        => 'Enabled Languages',
        'instructions' => 'Specify which languages are available for your site.'
    ],
    'maintenance'       => [
        'label'        => 'Maintenance Mode',
        'instructions' => 'Use this option to the disable the public-facing part of the system.<br>This is useful when you want to take the site down for maintenance or development.'
    ],
    'debug'             => [
        'label'        => 'Debug Mode',
        'instructions' => 'When enabled, detailed messages will be displayed on errors.'
    ],
    'ip_whitelist'      => [
        'label'        => 'IP Whitelist',
        'instructions' => 'When maintenance mode is enabled, these IP addresses will be allowed to access the front of the application.',
        'placeholder'  => 'Separate each IP address with a comma.'
    ],
    'basic_auth'        => [
        'label'        => 'Prompt for authentication?',
        'instructions' => 'When maintenance mode is enabled, prompt users for HTTP authentication?'
    ],
    '503_message'       => [
        'label'        => 'Unavailable Message',
        'instructions' => 'When the site is disabled or there is a major problem, this message will display to users.',
        'placeholder'  => 'Be right back.'
    ],
    'email'             => [
        'label'        => 'System Email',
        'instructions' => 'Specify the default email to use for system generated messages.',
        'placeholder'  => 'example@domain.com'
    ],
    'sender'            => [
        'label'        => 'Sender Name',
        'instructions' => 'Specify the "From" name to use for system generated messages.'
    ],
    'mail_driver'       => [
        'label'        => 'Email Driver',
        'instructions' => 'How does your site send email?',
        'option'       => [
            'smtp'     => 'SMTP',
            'mail'     => 'PHP Mail',
            'sendmail' => 'Sendmail',
            'mailgun'  => 'Mailgun',
            'log'      => 'Log File',
            'ses'      => 'Amazon SES'
        ]
    ],
    'mail_host'         => [
        'label'        => 'SMTP Host',
        'instructions' => 'Specify the address of the SMTP server used to deliver emails.',
        'placeholder'  => 'smtp.mailgun.org'
    ],
    'mail_port'         => [
        'label'        => 'SMTP Port',
        'instructions' => 'Specify the SMTP port used to deliver emails.',
        'placeholder'  => '587'
    ],
    'mail_username'     => [
        'label'        => 'SMTP Username',
        'instructions' => 'Specify the SMTP username used to deliver emails.',
    ],
    'mail_password'     => [
        'label'        => 'SMTP Password',
        'instructions' => 'Specify the SMTP password used to deliver emails.',
    ],
    'mail_debug'        => [
        'label'        => 'Debug Mail',
        'instructions' => 'When this option is enabled, email will not be sent but will instead be written to your log files so you may inspect the message.'
    ],
    'mailgun_domain'    => [
        'label' => 'Mailgun Domain'
    ],
    'mailgun_secret'    => [
        'label' => 'Mailgun Secret'
    ],
    'mandrill_secret'   => [
        'label' => 'Mandrill Secret'
    ],
    'cache_driver'      => [
        'label'        => 'Cache Driver',
        'instructions' => 'How does your store cached data?',
        'option'       => [
            'apc'       => 'APC',
            'array'     => 'Array',
            'file'      => 'File',
            'memcached' => 'Memcached',
            'redis'     => 'Redis'
        ]
    ],
    'standard_theme'    => [
        'label'        => 'Public Theme',
        'instructions' => 'What theme would you like to use for the public site?'
    ],
    'admin_theme'       => [
        'label'        => 'Admin Theme',
        'instructions' => 'What theme would you like to use for the control panel?'
    ],
    'per_page'          => [
        'label'        => 'Results Per Page',
        'instructions' => 'Specify the default number of results to display on each page.'
    ],
];
