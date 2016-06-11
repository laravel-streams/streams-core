<?php

return [
    'name'             => [
        'label'        => '网站标题',
        'instructions' => '您的网站名称？',
        'placeholder'  => trans('distribution::addon.name')
    ],
    'description'      => [
        'label'        => '网站说明',
        'instructions' => '您的网站说明或是标语？',
        'placeholder'  => trans('distribution::addon.description')
    ],
    'default_timezone' => [
        'label'        => '预设时区',
        'instructions' => '请设定系统的预设时区，这将会影响所有日期与时间的功能。'
    ],
    'date_format'      => [
        'label'        => '日期格式',
        'instructions' => '网站前后台的日期格式是？ 请参考 <a href="http://php.net/manual/en/function.date.php" target="_blank">date format</a> 在 PHP 网站中的说明。',
        'placeholder'  => 'm/d/Y'
    ],
    'time_format'      => [
        'label'        => '时间格式',
        'instructions' => '网站前后台的时间格式是？ 请参考 <a href="http://php.net/manual/en/function.date.php" target="_blank">date format</a> 在 PHP 网站中的说明。',
        'placeholder'  => 'g:i A'
    ],
    'default_locale'   => [
        'label'        => '预设语言',
        'instructions' => '您的网站预设语言是？'
    ],
    'enabled_locales'  => [
        'label'        => '使用语言',
        'instructions' => '您的网站可以支持那些语言？'
    ],
    'site_enabled'     => [
        'label'        => '网站开启',
        'instructions' => '使用此选项来启用或禁用网站前台。<br>当您需要暂时将网站关闭时，这将会很有用。'
    ],
    'ip_whitelist'     => [
        'label'        => 'IP 白名单',
        'instructions' => '当状态设定为 "禁用" 时，这些 IP 才能允许存取这个网站。',
        'placeholder'  => '请使用半形字的逗点来区隔多个 IP。'
    ],
    '503_message'      => [
        'label'        => '无法存取时的显示讯息',
        'instructions' => '当网站状态设定为禁用或有重大问题产生时，此讯息将会显示。',
        'placeholder'  => '马上回来'
    ],
    'force_https'      => [
        'label'        => '强制 HTTPS',
        'instructions' => '只允许透过 HTTPS 通讯协定来使用网站。',
        'option'       => [
            'all'    => '强制在所有的连接使用 HTTPS。',
            'none'   => '不强制使用 HTTPS。',
            'admin'  => '只在后台强制使用 HTTPS 。',
            'public' => '只在前台强制使用 HTTPS 。'
        ]
    ],
    'contact_email'    => [
        'label'        => '与我联系的电子邮箱',
        'instructions' => '所有网站中来自用户、访客与系统的邮件，将会寄送到此预设的邮箱。',
        'placeholder'  => 'example@domain.com'
    ],
    'server_email'     => [
        'label'        => '伺服器的电子邮箱',
        'instructions' => '所有服务器对外发出的邮件，将以此为寄件者。',
        'placeholder'  => 'noreply@domain.com'
    ],
    'mail_driver'      => [
        'label'        => '电子邮件的寄信程式',
        'instructions' => '您的网站将以什么方式寄出信件？',
        'option'       => [
            'smtp'     => 'SMTP',
            'mail'     => 'PHP Mail',
            'sendmail' => 'Sendmail',
            'mailgun'  => 'Mailgun',
            'mandrill' => 'Mandrill',
            'log'      => 'Log File'
        ]
    ],
    'mail_host'        => [
        'label'        => 'SMTP Host',
        'instructions' => '您的网站将使用这个 SMTP server 来寄送邮件。',
        'placeholder'  => 'smtp.mailgun.org'
    ],
    'mail_port'        => [
        'label'        => 'SMTP Port',
        'instructions' => '您的网站将使用这个 SMTP port 来寄送邮件。',
        'placeholder'  => '587'
    ],
    'mail_username'    => [
        'label'        => 'SMTP Username',
        'instructions' => '您的网站将使用这个 SMTP username 来寄送邮件。'
    ],
    'mail_password'    => [
        'label'        => 'SMTP Password',
        'instructions' => '您的网站将使用这个 SMTP password 来寄送邮件。'
    ],
    'mail_debug'       => [
        'label'        => '侦错模式',
        'instructions' => '当这个选项开启时，邮件将不会被寄出，而是被写入网站的记录档(log)，因此您可以检查或侦错。'
    ],
    'cache_driver'     => [
        'label'        => '暂存程式',
        'instructions' => '您的网站将用什么方式暂存资料呢？',
        'option'       => [
            'apc'       => 'APC',
            'array'     => 'Array',
            'file'      => 'File',
            'memcached' => 'Memcached',
            'redis'     => 'Redis'
        ]
    ],
    'standard_theme'   => [
        'label'        => '前台模板',
        'instructions' => '您的网站前台要使用什么风格模板呢？'
    ],
    'admin_theme'      => [
        'label'        => '后台模板',
        'instructions' => '您的网站后台要使用什么风格模板呢？'
    ]
];
