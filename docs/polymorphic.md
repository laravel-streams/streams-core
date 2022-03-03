---
title: Polymorphic Type
link_title: Polymorphic
intro: Relate to any stream entry.
category: field_types
stage: drafting
enabled: true
---

## Overview

A single relationship to any entry.

```json
// streams/users.json
"fields": {
    "home": {
        "type": "polymorphic"
    }
}
```

## Data Structure

```json
{
    "home": {
        "@stream": "pages",
        "key": "welcome"
    }
}
```

## Templating

Basic value access displays the entry instance:

```blade
@verbatim// Basic access
{{ $entry->home->title }}@endverbatim
```

### Decorated Value

The decorated value also provides the same instance.

```blade
@verbatim// Decorated value
{{ $entry->home()->title }}@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration

```json
// streams/users.json
"fields": {
    "home": {
        "type": "polymorphic",
        "config": {
            "allowed": [
                "pages",
                "dashboards"
            ]
        }
    }
}
```
