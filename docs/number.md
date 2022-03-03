---
title: Number Type
link_title: Number
intro: Store numeric values.
category: field_types
stage: drafting
enabled: true
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

### Decorated Value

Boolean types also provide decorated values.

```blade
@verbatim// Decorated value
@if ($entry->price()->isOdd())
    // ...
@endif@endverbatim
```

#### Methods

@todo Generate methods from @docs
