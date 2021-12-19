---
title: Prototype Type
link_title: Prototype
intro: Store any prototype object.
category: field_types
enabled: true
sort: 0
---

## Overview

Store an abstract object.

```json
// streams/users.json
"fields": {
    "extension": {
        "type": "prototype"
    }
}
```

### Configuration

@todo Generate config options from class::configuration

## Data Structure

```json
{
    "extension": [
        {
            "type": "App\\ExampleExtension",
            "data": {
                "name": "Example Extension"
            }
        }
    ]
}
```

## Templating

Basic value access returns the instance:

```blade
@verbatim// Basic access
{{ $entry->permissions->first()->info }}@endverbatim
```

### Expanded Value

Expanded values provide the same instance.

```blade
@verbatim// Expanded value
{{ $entry->permissions()
    ->pluck('key')
    ->implode(',t ') }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
