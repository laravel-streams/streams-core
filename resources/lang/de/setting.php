<?php

return [
    'name'             => [
        'label'        => 'Name der Website',
        'instructions' => 'Was ist der Name Ihrer Website?',
        'placeholder'  => trans('distribution::addon.name')
    ],
    'description'      => [
        'label'        => 'Beschreibung der Website',
        'instructions' => 'Was ist der Slogan oder eine kurze Beschreibung Ihrer Website?',
        'placeholder'  => trans('distribution::addon.description')
    ],
    'default_timezone' => [
        'label'        => 'Standard Zeitzone',
        'instructions' => 'Geben Sie die Standard Zeitzone an. Diese wird von allen Datums- und Zeit-Funktionen verwendet.'
    ],
    'date_format'      => [
        'label'        => 'Datumsformat',
        'instructions' => 'Wie soll eine Datumsangabe auf der Website und im Control Panel dargestellt werden? Beachten Sie das <a href="http://php.net/manual/de/function.date.php" target="_blank">Datumsformat</a> von PHP.',
        'placeholder'  => 'm/d/Y'
    ],
    'time_format'      => [
        'label'        => 'Zeitformat',
        'instructions' => 'Wie soll eine Zeitangabe auf der Website und im Control Panel dargestellt werden? Beachten Sie das <a href="http://php.net/manual/de/function.date.php" target="_blank">Zeitformat</a> von PHP.',
        'placeholder'  => 'g:i A'
    ],
    'default_locale'   => [
        'label'        => 'Standard Sprache',
        'instructions' => 'Was ist die Standard Sprache Ihrer Applikation?'
    ],
    'enabled_locales'  => [
        'label'        => 'Aktivierte Sprachen',
        'instructions' => 'Geben Sie an, welche Sprachen für Ihre Website oder Applikation verfügbar sein werden.'
    ],
    'site_enabled'     => [
        'label'        => 'Site aktiviert',
        'instructions' => 'Verwenden Sie diese Option, um den öffentlichen Teil Ihrer Website zu aktivieren oder zu deaktivieren.<br>Das ist hilfreich, wenn Sie die Website oder Applikation für Wartung oder Entwicklungen deaktivieren möchten.'
    ],
    'ip_whitelist'     => [
        'label'        => 'IP Whitelist',
        'instructions' => 'Wenn Ihre Site auf "deaktiviert" gesetzt ist, können diese IP-Adressen weiterhin auf die Website zugreifen.',
        'placeholder'  => 'Trennen Sie jeden IP-Adresse mit einem Komma.'
    ],
    '503_message'      => [
        'label'        => 'Nachricht, wenn die Website nicht verfügbar ist',
        'instructions' => 'Wenn die Website deaktiviert oder ein grosses Problem aufgetreten ist, wird diese Meldung angezeigt.',
        'placeholder'  => 'Wir sind gleich zurück.'
    ],
    'force_https'      => [
        'label'        => 'HTTPS erzwingen',
        'instructions' => 'Sollen nur Zugriffe via HTTPS-Protokoll erlaubt sein?',
        'option'       => [
            'all'    => 'Erzwinge HTTPS für alle Verbindungen',
            'none'   => 'KEINE Erzwingung von HTTP-Verbindungen',
            'admin'  => 'Erzwinge HTTPS für Verbindungen auf das Control Panel',
            'public' => 'Erwzinge HTTP für Verbindungen auf den öffentlichen Teil der Website'
        ]
    ],
    'contact_email'    => [
        'label'        => 'Kontakt E-Mail-Adresse',
        'instructions' => 'Alle E-Mails von Benutzern, Gästen und der Website werden standardmässig an diese E-Mail-Adresse gesendet.',
        'placeholder'  => 'muster@domain.com'
    ],
    'server_email'     => [
        'label'        => 'Server E-Mail-Adresse',
        'instructions' => 'All E-Mail, die vom Server aus gesendet werden, verwenden diese E-Mail-Adresse als Absender.',
        'placeholder'  => 'noreply@domain.com'
    ],
    'mail_driver'      => [
        'label'        => 'E-Mail Treiber',
        'instructions' => 'Wie versendet Ihre Website E-Mails?',
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
        'label'        => 'SMTP Server',
        'instructions' => 'Die Adresse des SMTP-Servers, der von Ihrer Website für den Versand von E-Mails verwendet wird.',
        'placeholder'  => 'smtp.mailgun.org'
    ],
    'mail_port'        => [
        'label'        => 'SMTP Port',
        'instructions' => 'Der SMTP Port, der von Ihrer Website verwendet wird, um E-Mails zu versenden.',
        'placeholder'  => '587'
    ],
    'mail_username'    => [
        'label'        => 'SMTP Benutzername',
        'instructions' => 'Der SMTP Benutzername, der von Ihrer Website verwendet wird um E-Mails zu versenden.'
    ],
    'mail_password'    => [
        'label'        => 'SMTP Passwort',
        'instructions' => 'Das SMTP Passwort, das von Ihrer Website verwendet wird um E-Mails zu versenden.'
    ],
    'mail_debug'       => [
        'label'        => 'Debug Modus',
        'instructions' => 'Wenn diese Option aktiviert ist, werden E-Mails nicht versendet, sondern stattdessen in die Log-Datei Ihrer Website geschrieben, damit Sie die Nachricht überprüfen können.'
    ],
    'cache_driver'     => [
        'label'        => 'Cache Treiber',
        'instructions' => 'Wie soll Ihre Website Daten in den Cache speichern?',
        'option'       => [
            'apc'       => 'APC',
            'array'     => 'Array',
            'file'      => 'File',
            'memcached' => 'Memcached',
            'redis'     => 'Redis'
        ]
    ],
    'standard_theme'   => [
        'label'        => 'Öffentliches Theme',
        'instructions' => 'Welches Theme möchten Sie für den öffentlichen Teil der Website verwenden?'
    ],
    'admin_theme'      => [
        'label'        => 'Admin Theme',
        'instructions' => 'Welches Theme soll für das Control Panel verwendet werden?'
    ]
];
