---
title: Polymorphic Type
link_title: Polymorphic
intro: Relate to any stream entry.
category: field_types
enabled: true
sort: 0
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
    "home": [
        {
            "stream": "pages",
            "value": "welcome"
        }
    ]
}
```

## Templating

Basic value access displays the entry instance:

```blade
@verbatim// Basic access
{{ $entry->home->title }}@endverbatim
```

### Expanded Value

The expanded value also provides the same instance.

```blade
@verbatim// Expanded value
{{ $entry->home()->title }}@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration
