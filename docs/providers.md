---
title: Service Providers
category: developers
enabled: true
sort: 99
---

## Introduction

Streams provides a stream-lined service provider for integrating easily with Laravel and Streams.

### Getting Started

Extend the `Streams\Core\Support\Provider` to get started defining your own service provider.

```php
namespace App\Providers;

use Streams\Core\Support\Provider;

class YourProvider extends Provider
{
    // This is your stuff.
}
```

### Integration

@todo Important to note: Uses `Integrator`.

## Basic Usage

### Assets

The `assets` property specifies [named assets](assets#named-assets) to register.

```php
public $assets = [
    'theme.js' => 'resources/js/theme.js',
];
```

### Routes

The `routes` property specifies [routes](routes) to register. Routes are specified by middleware group.

```php
public $routes = [
    'web' => [
        '/' => 'App\Http\Controller@index',
    ],
];
```

You can also specify routes as an array of [route options](routing#route-options)

```php
public $routes = [
    'web' => [
        '/' => [
            'stream' => 'pages',
            'entry' => 'home',
            'view' => 'welcome',
        ],
    ],
];
```

### Policies

The `policies` property specifies policies to register.

```php
public $policies = [
    // ...
];
```

### Streams

The `streams` property specifies [streams](streams) to register.

```php
public $streams = [
        'contacts' => [
            'name' => 'Contacts',
        'source' => [
            'type' => 'filebase',
            'filename' => 'streams/data/contacts',
            'format' => 'json'
        ],
        'config' => [
            'prototype' => 'Streams\Core\Entry\Entry',
            'collection' => 'Illuminate\Support\Collection'
        ],
        'fields' => [
            'name' => 'string',
            'email' => 'email',
            'company' => [
                'type' => 'relationship',
                'config' => [
                    'related' => 'companies'
                ]
            ]
        ],
    ]
];
```

### Listeners

The `listeners` property specifies event listeners to register.

```php
public $listeners = [
    'example.event' => [
        'App\Event\Listener\ExampleListener',
    ],
];
```

### Providers

The `providers` property specifies service providers to register.

```php
public $providers = [
    'App\Providers\CustomProvider',
];
```



### Middleware

The `middleware` property specifies grouped middleware to register.

```php
public $middleware = [
    'web' => [
        'App\Http\Middleware\ExampleMiddleware',
    ],
];
```

### Commands

The `commands` property specifies Artisan commands to register.

```php
public $commands = [
    'App\Console\ExampleCommand',
];
```

### Schedules

The `schedules` property specifies scheduled commands to register.

```php
public $schedules = [
    '* * * * *' => [
        'App\Console\ExampleCommand',
    ],
];
```
