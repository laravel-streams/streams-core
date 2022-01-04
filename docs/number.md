---
title: Number Type
link_title: Number
intro: Store numeric values.
category: field_types
stage: drafting
enabled: true
sort: 0
---

## Overview

The `number` field type stores numeric values including floating point numbers. If you need to support fixed-precision numbers, check out the [decimal](decimal) field type.

```json
// streams/example.json
"fields": {
    "price": {
        "type": "number"
    }
}
```

### Configuration

@todo Generate config options from class::configuration


## Data Structure

```json
{
    "price": 89.95
}
```

## Templating

Basic value access displays the stored value:

```blade
@verbatim// Basic access
{{ $entry->price }}@endverbatim
```

### Expanded Value

Boolean types also provide expanded values.

```blade
@verbatim// Expanded value
@if ($entry->price()->isOdd())
    // ...
@endif@endverbatim
```

#### Methods

@todo Generate methods from @docs
