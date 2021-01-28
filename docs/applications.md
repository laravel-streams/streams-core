---
__created_at: 1611725792
__updated_at: 1611725792
title: Applications
category: advanced
sort: 0
stage: outlining
enabled: true
---
## Introduction

**Application switching** provides a fundamental pathway to configure your application behavior based on matching request patterns.

### Configuration

The applications system leverages the `core.applications` stream. Entries are defined using `JSON` files within the `/streams/apps` directory.

```json
// streams/apps/{id}.json
{
    "match": "docs.example.com/*",
    "locale": "en",
    "config": {
        "app.name": "Documentation",
        "database.default": "docs"
    }
}
```

#### How It Works

The first application matching the request, if any, is used to reconfigure various aspects of the application.


## Multi-Tenancy

Application switching provide the backbone functionality for building multi-tenancy applications.

```json
// streams/apps/docs.json
{
    "match": "docs.example.com/*",
    "config": {
        "app.name": "Documentation",
        "database.default": "docs"
    }
}
```

## Localization

Application switching provides the backbone functionality for building multi-lingual applications.

```json
// streams/apps/docs.json
{
    "match": "example.com/fr/*",
    "locale": "fr",
    "config": {
        "app.name": "Documentation",
        "database.default": "docs"
    }
}
```

**@todo Talk about custom application handlers.**<br>
**@todo Talk about deeper configuration (streams/sources) past config/locale.**<br>
**@todo Talk about programatically manipulating applications.**
