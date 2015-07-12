<?php

return [
    'name'           => [
        'label'        => 'Nom du site',
        'instructions' => 'Quel est le nom du site ou de l\'application ?',
        'placeholder'  => trans('distribution::addon.name')
    ],
    'description'    => [
        'label'        => 'Description du site',
        'instructions' => 'Description du site ou de l\'application',
        'placeholder'  => trans('distribution::addon.description')
    ],
    'date_format'    => [
        'label'        => 'Format de la date',
        'instructions' => 'Dans quel format les dates doivent être affichées ? <a href="http://php.net/manual/en/function.date.php" target="_blank">Documentation</a>.',
        'placeholder'  => 'm/d/Y'
    ],
    'time_format'    => [
        'label'        => 'Format de l\'heure',
        'instructions' => 'Dans quel format l\'heure doit être affichée ? <a href="http://php.net/manual/en/function.date.php" target="_blank">Documentation</a>.',
        'placeholder'  => 'g:i A'
    ],
    'default_locale' => [
        'label'        => 'Langue par défaut',
        'instructions' => 'Quelle est la langue du site ?<br>Les langues peuvent être gérées <a href="/admin/localization" target="_blank">module localisation</a>.'
    ],
    'site_enabled'   => [
        'label'        => 'Site actif ?',
        'instructions' => 'Utilisez cette option pour bloquer l\'accès à la partie publique du site.'
    ],
    'ip_whitelist'   => [
        'label'        => 'Liste blanche IP',
        'instructions' => 'Quand le site est inactif, quelles adresses IP sont autorisées à accèder au site ?',
        'placeholder'  => 'Adresses séparées par une virgule.'
    ],
    '503_message'    => [
        'label'        => 'Message de maintenance ?',
        'instructions' => 'Quel message afficher aux visiteurs quand le site est inactif ?',
        'placeholder'  => 'De retour bientôt !'
    ],
    'force_https'    => [
        'label'        => 'Forcer le HTTPS',
        'instructions' => 'Forcer l\'accès au site en HTTPS ?',
        'option'       => [
            'all'    => 'Forcer HTTPS pour toutes les connexions.',
            'none'   => 'Ne pas forcer le HTTPS.',
            'admin'  => 'Forcer le HTTPS uniquement pour l\'administration.',
            'public' => 'Forcer le HTTPS uniquement pour la partie publique.'
        ]
    ],
    'contact_email'  => [
        'label'        => 'Email de contact',
        'instructions' => 'Tous les messages du site et des utilisateurs seront envoyés à cette adresse.',
        'placeholder'  => 'contact@domaine.fr'
    ],
    'server_email'   => [
        'label'        => 'Email du serveur',
        'instructions' => 'Tous les emails seront envoyés par cette adresse.',
        'placeholder'  => 'ne-pas-repondre@domaine.fr'
    ],
    'mail_driver'    => [
        'label'        => 'Méthode email',
        'instructions' => "Comment l'application envoit-elle les emails ?",
        'option'       => [
            'smtp'     => 'SMTP',
            'mail'     => 'Fonction mail PHP',
            'sendmail' => 'Sendmail',
            'mailgun'  => 'Mailgun',
            'mandrill' => 'Mandrill',
            'log'      => 'Fichier de log'
        ]
    ],
    'smtp_host'      => [
        'label'        => 'Hôte SMTP',
        'instructions' => 'Domaine ou adresse IP de l\'hôte du serveur SMTP.',
        'placeholder'  => 'smtp.mailgun.org'
    ],
    'smtp_port'      => [
        'label'        => 'Port SMTP',
        'instructions' => 'Port personnalisé pour le serveur SMTP. 587 par défaut.',
        'placeholder'  => '587'
    ],
    'smtp_username'  => [
        'label'        => 'Identifiant SMTP',
        'instructions' => 'Identifiant du serveur SMTP.'
    ],
    'smtp_password'  => [
        'label'        => 'Mot de passe SMTP',
        'instructions' => 'Mot de passe pour le serveur SMTP.'
    ],
    'mail_debug'     => [
        'label'        => 'Mode de debogage',
        'instructions' => 'En activant cette option aucun email ne sera envoyé. Ils seront écrits dans un fichier de log pour les consulter.'
    ],
    'cache_driver'   => [
        'label'        => 'Méthode de mise en cache',
        'instructions' => 'Comment l\'application stocke t-elle les données ?',
        'option'       => [
            'apc'       => 'APC',
            'array'     => 'Tableau',
            'file'      => 'File',
            'memcached' => 'Memcached',
            'redis'     => 'Redis'
        ]
    ],
    'standard_theme' => [
        'label'        => 'Thème public',
        'instructions' => 'Quel thème utiliser pour la partie publique ?'
    ],
    'admin_theme'    => [
        'label'        => 'Thème administrateur',
        'instructions' => 'Quel thème utiliser pour l\'administration ?'
    ]
];
