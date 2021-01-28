---
title: Addons
category: advanced
stage: outlining
enabled: true
---
## Introduction

Addons provide a basic standard for developing distributable chunks of code designed specifically for Laravel Streams.

Addons are composer packages marked `streams-addon` and can be distributed anywhere composer packages can be distributed (Packagist, SATIS, etc.)

### Detecting Addons

Packages of type `streams-addon` are automatically detected from your `composer.lock` file.

```json
// vendor/example/widgets/composer.json
{
    "name": "example/widgets",
    "description": "Widgets for your example project.",
    "type": "streams-addon",
}
```

### Local Packages

Using [repository paths](https://getcomposer.org/doc/05-repositories.md#path) you can acheive local-only, application-specific, or development installations of addons.

```json
// composer.json
{
    "repositories": [{
        "type": "path",
        "url": "../addons/*"
    }]
}
