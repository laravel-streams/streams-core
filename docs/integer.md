---
title: Integer Type
link_title: Integer
intro: Store integer values.
category: field_types
enabled: true
sort: 0
---

## Overview

The `integer` field type stores whole number values.

```json
// streams/example.json
"fields": {
    "count": {
        "type": "integer"
    }
}
```


## Data Structure

```json
{
    "count": 100
}
```

## Templating

Basic value access displays the stored value:

```blade
@verbatim// Basic access
{{ $entry->count }}@endverbatim
```

### Expanded Value

Boolean types also provide expanded values.

```blade
@verbatim// Expanded value
@if ($entry->count()->isEven())
    // ...
@endif@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration
