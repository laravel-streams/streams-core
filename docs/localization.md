---
title: Localization
category: core_concepts
intro: 
sort: 20
---

- Introduction
- Configuration
    - Custom Paths
    - Custom Loaders
- Localizing Entries
    - Defining Entries    
    - Querying Translations


```php
<?php

return [

    'applications' => [
        'default' => [], // Need this?
        'french' => [
            'match' => '*streams.*lang=fr*',
            'config' => [
                'app.name' => 'Ruisseaux',
                'app.locale' => 'fr',
            ],
            // Moar!
        ],
    ]
];
```
