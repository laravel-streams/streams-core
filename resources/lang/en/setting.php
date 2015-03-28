<?php

return [
    'name'           => [
        'label'        => 'Site Name',
        'instructions' => 'What is the name of your application?',
        'placeholder'  => trans('distribution::addon.name')
    ],
    'description'    => [
        'label'        => 'Site Description',
        'instructions' => 'What is the description or slogan of your application?',
        'placeholder'  => trans('distribution::addon.description')
    ],
    'date_format'    => [
        'label'        => 'Date Format',
        'instructions' => 'How should dates be displayed across the website and control panel? Using the <a href="http://php.net/manual/en/function.date.php" target="_blank">date format</a> from PHP.',
        'placeholder'  => 'm/d/Y'
    ],
    'time_format'    => [
        'label'        => 'Time Format',
        'instructions' => 'How should time be displayed across the website and control panel? Using the <a href="http://php.net/manual/en/function.date.php" target="_blank">date format</a> from PHP.',
        'placeholder'  => 'g:i A'
    ],
    'default_locale' => [
        'label'        => 'Default Language',
        'instructions' => 'What is the default language for your application?<br>Languages can be managed in the <a href="/admin/localization" target="_blank">Localization</a> module.'
    ],
    'site_enabled'   => [
        'label'        => 'Site Status',
        'instructions' => 'Use this option to the enable or disable the public-facing part of the application.<br>This is useful when you want to take the application down for maintenance or development.'
    ],
    'ip_whitelist'   => [
        'label'        => 'IP Whitelist',
        'instructions' => 'When the status is set to "disabled" these IP addresses will be allowed to access the application.',
        'placeholder'  => 'Separate each IP address with a comma.'
    ],
    '503_message'    => [
        'label'        => 'Unavailable Message',
        'instructions' => 'When the site is disabled or there is a major problem, this message will display to users.',
        'placeholder'  => 'Be right back.'
    ],
    'force_https'    => [
        'label'        => 'Force HTTPS',
        'instructions' => 'Allow only the HTTPS protocol when accessing the application?',
        'option'       => [
            'all'    => 'Force HTTPS on all connections',
            'none'   => 'Do NOT force HTTPS connections',
            'admin'  => 'Only force HTTPS for admin control panel access',
            'public' => 'Only force HTTPS for public-facing content'
        ]
    ],
    'contact_email'  => [
        'label'        => 'Contact Email',
        'instructions' => 'All e-mails from users, guests and the application will go to this e-mail address by default.',
        'placeholder'  => 'example@domain.com'
    ],
    'server_email'   => [
        'label'        => 'Server Email',
        'instructions' => 'All emails sent from your server will come from this email address.',
        'placeholder'  => 'noreply@domain.com'
    ],
    'mail_driver'    => [
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
    'smtp_host'      => [
        'label'        => 'SMTP Host',
        'instructions' => 'This is the address of the SMTP server used by your application to deliver emails.',
        'placeholder'  => 'smtp.mailgun.org'
    ],
    'smtp_port'      => [
        'label'        => 'SMTP Port',
        'instructions' => 'This is the SMTP port used by your application to deliver emails.',
        'placeholder'  => '587'
    ],
    'smtp_username'  => [
        'label'        => 'SMTP Username',
        'instructions' => 'This is the SMTP username used by your application to deliver emails.'
    ],
    'smtp_password'  => [
        'label'        => 'SMTP Password',
        'instructions' => 'This is the SMTP username used by your application to deliver emails.'
    ],
    'mail_debug'     => [
        'label'        => 'Debug Mode',
        'instructions' => 'When this option is enabled, email will not be sent but will instead be written to your application\'s logs files so you may inspect the message.'
    ],
];
