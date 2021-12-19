---
title: Entries Type
link_title: Entries
intro: Store multiple stream configured values.
category: field_types
enabled: true
sort: 0
---

## Overview

Store multiple stream entries.

```json
// streams/users.json
"fields": {
    "permissions": {
        "type": "entries",
        "config": {
            "stream": "permissions"
        }
    }
}
```

### Configuration

@todo Generate config options from class::configuration


## Data Structure

```json
{
    "permissions": [
        {
            "key": "pages.preview",
            "info": "Can preview pages"
        }
    ]
}
```

## Templating

Basic value access returns the entry collection:

```blade
@verbatim// Basic access
{{ $entry->permissions->first()->info }}@endverbatim
```

### Expanded Value

Expanded values provide the same collection.

```blade
@verbatim// Expanded value
{{ $entry->permissions()
    ->pluck('key')
    ->implode(', ') }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
