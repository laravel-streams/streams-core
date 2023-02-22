---
__created_at: 1611725792
__updated_at: 1611725792
title: Applications
category: advanced
sort: 10
stage: outlining
enabled: true
---

## Introduction

Applications provides a fundamental interface to configure your application based on request patterns.

### Defining Applications

Applications are defined using the `applications` stream. Entries are defined using `JSON` entry files within the `/streams/apps` directory by default.

The `match` value is compared to request URLs to determine the active application.

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*"
}
```

## Application Options

The following application options are available and support [parsing variables](parsing).

### Locale

Set the active locale using the **locale** property:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*",
    "locale": "en"
}
```

### Configuration

Override configuration using the **config** property:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*",
    "config": {
        "app.name": "Documentation"
    }
}
```

### Streams

You can overload streams using the **streams** property:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*",
    "streams": {
        "pages": {
            "source.path": "streams/data/pages/docs"
        }
    }
}
```

### Assets

Use the **assets** property to register assets by name:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=darkmode",
    "assets": {
        "variable": "epic/script.js",
        "theme.css": "your/theme/dark.css",
        "theme.js": "your/theme/dark.js",
        "theme-bundle": ["theme.css", "theme.js"]
    }
}
```

```blade
@verbatim{{ Asset::load("random") }}
{{ Asset::load("theme-bundle") }}@endverbatim
```

### Routes

Use the **routes** property to register routes by middleware group:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=login",
    "routes": {
        "web": {
            "/login": {
                "uses": "App\\Http\\Controller\\Alternate@login"
            }
        }
    }
}
```

### Policies

Use the **policies** property to register policies by name:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=login",
    "policies": {
        "custom-testing-array-policy": ["Your\\Policy", "method"],
        "custom-testing-invokable-policy": "You\\InvokablePolicy",
        "CustomProviderService::class": "Your\\Policy"
    }
}
```

### Listeners

Use the **listeners** property to register listeners by event name:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=feature",
    "events": {
        "example.event": [
            "App\\Event\\Listener\\FeatureListener"
        ]
    }
}
```


### Providers

The `providers` property specifies service providers to register.

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=feature",
    "providers": [
        "App\\Providers\\FeatureProvider"
    ]
}
```


### Middleware

The `middleware` property specifies grouped middleware to register.

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=feature",
    "middleware": {
        "web": [
            "App\\Http\\Middleware\\ExampleMiddleware"
        ]
    }
}
```

### Commands

The `commands` property specifies Artisan commands to register.

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=feature",
    "commands": [
        "App\\Console\\ExampleCommand"
    ]
}
```

### Schedules

The `schedules` property specifies [scheduled commands](https://laravel.com/docs/scheduling#scheduling-shell-commands) to register.

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*?preview=feature",
    "schedules": {
        "* * * * *": [
            "App\\Console\\ExampleCommand",
        ],
        "dailyAt|13:00": [
            "App\\Console\\AnotherCommand",
        ]
    }
}
```

## Multi-Tenancy

Applications provide the backbone functionality for building multi-tenancy applications.

```json
// streams/apps/accounts.json
{
    "match": "*.example.com/*",
    "config": {
        "app.name": "My Account",
        "database.default": "{request.parsed.domain.0}",
        "streams.core.data_path": "streams/data/{request.parsed.domain.0}"
    },
    "users": {
        "source.table": "users_{request.parsed.domain.0}"
    }
}
````

## Localization

Application switching provides the backbone functionality for building localized applications.

```json
// streams/apps/localized.json
{
    "match": "*.example.com/*",
    "locale": "{request.parsed.domain.0}",
    "pages": {
        "source.path": "streams/data/pages/{request.parsed.domain.0}"
    }
}
```

## Resources

-   [@todo Example Applications](#example-applications)
