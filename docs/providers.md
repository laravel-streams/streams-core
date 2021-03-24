---
title: Service Providers
category: core_concepts
intro: 
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

## [Assets](assets)

```php
public $assets = [
    'scripts' => [
        'theme.js' => 'your/own/theme.js',
    ],
];
```

## [Routes](routing)

```php
public $routes = [
    'web' => [
        '/test' => 'You\Custom\Controller@test',
    ],
];
```

## Streams
## Commands
## Policies
## Listeners
## Providers
## Schedules
## Middleware
