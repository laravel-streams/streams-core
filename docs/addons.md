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

## Defining Addons

Mark your composer package as a `streams-addon` using the `type` parameter:

```json
// addons/example/widgets/composer.json
{
    "name": "example/widgets",
    "description": "Widgets for your example project.",
    "type": "streams-addon",
}
```

### Service Providers

Using [service providers](https://laravel.com/docs/providers) is the easiest way to integrate with Laravel and Streams. You can specify autodetected service providers using the `composer.json` file.

``` json
// addons/example/widgets/composer.json
{
    "extra": {
        "laravel": {
            "providers": [
                "Example\\Widgets\\WidgetsProvider"
            ]
        }
    }
}
```

### Local Packages

Using [repository paths](https://getcomposer.org/doc/05-repositories.md#path) you can acheive local-only, application-specific, or development installations of addons.

```json
// composer.json
{
    "repositories": [{
        "type": "path",
        "url": "addons/examples/widget",
        "options": {
            "symlink": true
        }
    }]
}
```

### Installing Addons

Generally speaking, installing an addon requires downloading it with composer and optionally publishing it's assets and any migrations. There is no addon manager to control state.

```json
{
    "require": {
        // ...
        "example/addon": "dev-master"
    },
}
```
