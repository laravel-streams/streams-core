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

Applications provides a fundamental pathway to configure your application based on request patterns.

### Defining Applications

Applications are defined using the `core.applications` stream. Entries are defined using `JSON` entry files within the `/streams/apps` directory by default.

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

Set the active locale using the **locale** option:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*",
    "locale": "en"
}
```

### Configuration

Override configuration using the **config** option:

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

You can overload streams using the **streams** option:

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*",
    "streams": {
        "pages": {
            "source.path": "streams/data/pages/docs"
        },
        "docs": "@streams/docs.json" // @todo support importing
    }
}
```

### Assets
### Routes
### Policies
### Listeners
### Providers
### Middleware
### Commands
### Schedules

## Multi-Tenancy

Applications provide the backbone functionality for building multi-tenancy applications.

```json
// streams/apps/accounts.json
{
    "match": "*.example.com/*",
    "config": {
        "app.name": "My Account",
        "database.default": "{request.parsed.domain.0}",
        "streams.core.streams_data": "streams/data/{request.parsed.domain.0}"
    },
    "users": {
        "source.table": "users_{request.parsed.domain.0}"
    }
}
```

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

**@todo Talk about custom application handlers.**<br>
**@todo Talk about deeper configuration (streams/sources) past config/locale.**<br>
**@todo Talk about programatically manipulating applications.**
