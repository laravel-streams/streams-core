<?php

return [
    'name'            => [
        'label'        => 'Site Name',
        'instructions' => 'What is the name of your application?',
        'placeholder'  => trans('distribution::addon.name')
    ],
    'description'     => [
        'label'        => 'Site Description',
        'instructions' => 'What is the description or slogan of your application?',
        'placeholder'  => trans('distribution::addon.description')
    ],
    'business'        => [
        'label'        => 'Business Name',
        'instructions' => 'What is the legal name of your business?'
    ],
    'phone'           => [
        'label'        => 'Contact Phone',
        'instructions' => 'Specify a general contact phone number.'
    ],
    'address'         => [
        'label' => 'Address'
    ],
    'address2'        => [
        'label' => 'Apt, suite, etc.'
    ],
    'city'            => [
        'label' => 'City'
    ],
    'state'           => [
        'label' => 'State / Province'
    ],
    'postal_code'     => [
        'label' => 'Postal / ZIP Code'
    ],
    'country'         => [
        'label' => 'Country'
    ],
    'timezone'        => [
        'label'        => 'Timezone',
        'instructions' => 'Specify the default timezone for your site.'
    ],
    'unit_system'     => [
        'label'        => 'Unit System',
        'instructions' => 'Specify the unit system for your site.',
        'option'       => [
            'imperial' => 'Imperial System',
            'metric'   => 'Metric System'
        ]
    ],
    'currency'        => [
        'label'        => 'Currency',
        'instructions' => 'Specify the default currency for your site.'
    ],
    'date_format'     => [
        'label'        => 'Date Format',
        'instructions' => 'Specify the default date format for your site.'
    ],
    'time_format'     => [
        'label'        => 'Time Format',
        'instructions' => 'Specify the default time format for your site.'
    ],
    'default_locale'  => [
        'label'        => 'Language',
        'instructions' => 'Specify the default language for your site.'
    ],
    'enabled_locales' => [
        'label'        => 'Enabled Languages',
        'instructions' => 'Specify which languages are available for your site.'
    ],
    'maintenance'     => [
        'label'        => 'Maintenance Mode',
        'instructions' => 'Use this option to the disable the public-facing part of the system.<br>This is useful when you want to take the site down for maintenance or development.'
    ],
    'debug'           => [
        'label'        => 'Debug Mode',
        'instructions' => 'When enabled, detailed messages will be displayed on errors.'
    ],
    'ip_whitelist'    => [
        'label'        => 'IP Whitelist',
        'instructions' => 'When maintenance mode is enabled, these IP addresses will be allowed to access the front of the application.',
        'placeholder'  => 'Separate each IP address with a comma.'
    ],
    'basic_auth'      => [
        'label'        => 'Prompt for authentication?',
        'instructions' => 'When maintenance mode is enabled, prompt users for HTTP authentication?'
    ],
    '503_message'     => [
        'label'        => 'Unavailable Message',
        'instructions' => 'When the site is disabled or there is a major problem, this message will display to users.',
        'placeholder'  => 'Be right back.'
    ],
    'force_https'     => [
        'label'        => 'Force HTTPS',
        'instructions' => 'Allow only the HTTPS protocol when accessing the application?',
        'option'       => [
            'all'    => 'Force HTTPS on all connections',
            'none'   => 'Do NOT force HTTPS connections',
            'admin'  => 'Only force HTTPS for admin control panel access',
            'public' => 'Only force HTTPS for public-facing content'
        ]
    ],
    'contact_email'   => [
        'label'        => 'Contact Email',
        'instructions' => 'All e-mails from users, guests and the application will go to this e-mail address by default.',
        'placeholder'  => 'example@domain.com'
    ],
    'server_email'    => [
        'label'        => 'Server Email',
        'instructions' => 'All emails sent from your server will come from this email address.',
        'placeholder'  => 'noreply@domain.com'
    ],
    'mail_driver'     => [
        'label'        => 'Email Driver',
        'instructions' => 'How does your application send email?',
        'option'       => [
            'smtp'     => 'SMTP',
            'mail'     => 'PHP Mail',
            'sendmail' => 'Sendmail',
            'mailgun'  => 'Mailgun',
            'mandrill' => 'Mandrill',
            'log'      => 'Log File'
        ]
    ],
    'mail_host'       => [
        'label'        => 'SMTP Host',
        'instructions' => 'This is the address of the SMTP server used by your application to deliver emails.',
        'placeholder'  => 'smtp.mailgun.org'
    ],
    'mail_port'       => [
        'label'        => 'SMTP Port',
        'instructions' => 'This is the SMTP port used by your application to deliver emails.',
        'placeholder'  => '587'
    ],
    'mail_username'   => [
        'label'        => 'SMTP Username',
        'instructions' => 'This is the SMTP username used by your application to deliver emails.'
    ],
    'mail_password'   => [
        'label'        => 'SMTP Password',
        'instructions' => 'This is the SMTP password used by your application to deliver emails.'
    ],
    'mail_debug'      => [
        'label'        => 'Debug Mode',
        'instructions' => 'When this option is enabled, email will not be sent but will instead be written to your application\'s logs files so you may inspect the message.'
    ],
    'mailgun_domain'  => [
        'label' => 'Mailgun Domain'
    ],
    'mailgun_secret'  => [
        'label' => 'Mailgun Secret'
    ],
    'mandrill_secret' => [
        'label' => 'Mandrill Secret'
    ],
    'cache_driver'    => [
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
    'standard_theme'  => [
        'label'        => 'Public Theme',
        'instructions' => 'What theme would you like to use for the public site?'
    ],
    'admin_theme'     => [
        'label'        => 'Admin Theme',
        'instructions' => 'What theme would you like to use for the control panel?'
    ],
    'per_page'        => [
        'label'        => 'Results Per Page',
        'instructions' => 'Specify the default number of results to display on each page.'
    ]
];
