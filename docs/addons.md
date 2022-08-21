---
__created_at: 1621306541
__updated_at: 1621306541
link_title: Addons
title: Addon Packages
category: advanced
stage: outlining
enabled: true
sort: 1
---
## Introduction

Addons are [composer packages](https://getcomposer.org/) that are specifically designed for Laravel Streams. Addons and can be distributed anywhere composer packages can be distributed (Packagist, SATIS, etc.)

### Addon Development

Creating addons is a great way to distribute reusable code as well as encapsulate and organize large project components. Before developing addons you should have a basic understanding of integrating with Laravel Streams as well as a general understanding of Composer packages.


## Creating Addons

Use `composer init` inside a new directory for your addon package. 

```bash
mkdir example-addon

cd example-addon

composer init
```

### Defining Addon Packages

Mark your composer package as a `streams-addon` using the `type` parameter in order to declare that the package is designed for Laravel Streams. 

```bash
// addons/example-addon/composer.json
{
    "name": "myproject/example-addon",
    "description": "An example addon for my project.",
    "type": "streams-addons",
    "require": {
        "streams/core": "^2.0"
    },
    "require-dev": {
        "streams/testing": "^1.0"
    },
    "autoload": {
        "psr-4": {
            "MyProject\\ExampleAddon\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "MyProject\\ExampleAddon\\Tests\\": "tests/"
        }
    },
    "license": "MIT",
    "prefer-stable": true,
    "minimum-stability": "dev",
    "authors": [
        {
            "name": "Joe Smith",
            "email": "joe@streams.dev"
        }
    ],
    "extra": {
        "laravel": {
            "providers": [
                "MyProject\\ExampleAddon\\ExampleAddonServiceProvider"
            ]
        }
    }
}
```

### Service Providers

Using [service providers](https://laravel.com/docs/providers) is the easiest way to integrate with Laravel and Streams. You can specify autodetected service providers using the `composer.json` file.

``` json
// addons/example-addon/composer.json
{
    "extra": {
        "laravel": {
            "providers": [
                "MyProject\\ExampleAddon\\ExampleAddonServiceProvider"
            ]
        }
    }
}
```

```php
// addons/example-addon/src/ExampleAddonServiceProvider.php
namespace MyProject\ExampleAddon;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ExampleAddonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
```

## Local Packages

Using [repository paths](https://getcomposer.org/doc/05-repositories.md#path) you can acheive local-only, application-specific, or development installations of addons.

```json
// composer.json
{
    "repositories": [{
        "type": "path",
        "url": "addons/example-addon",
        "options": {
            "symlink": true
        }
    }]
}
```

## Installing Addons

Generally speaking, installing an addon requires downloading it with composer and optionally publishing it's assets and any migrations.

```json
// composer.json
{
    "require": {
        // ...
        "example/addon": "dev-master"
    }
}
```
