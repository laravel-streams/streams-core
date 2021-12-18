---
title: Grid Type
link_title: Grid
intro: Store multiple entry objects.
category: field_types
enabled: true
sort: 0
---

## Overview

Multiple entries of mixed types.

```json
// streams/users.json
"fields": {
    "content": {
        "type": "grid"
    }
}
```

## Data Structure

```json
{
    "content": [
        {
            "stream": "banner",
            "data": {
                // ...
            }
        }
    ]
}
```

## Templating

Basic value access displays the entry collection:

```blade
@verbatim// Basic access
{{ $entry->content->count() }}@endverbatim
```

### Expanded Value

The expanded value also provides the same collection.

```blade
@verbatim// Expanded value
{{ $entry->content()->count() }}@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration
