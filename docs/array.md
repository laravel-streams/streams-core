---
title: Array Type
link_title: Array
category: field_types
intro: The `array` field type stores `key:value` array data.
enabled: true
---

## Overview

The `array` field type is the type to use for storing `key:value` data.

```json
// streams/example.json
"fields": {
    "address": {
        "type": "array"
    }
}
```

## Data Structure

```json
{
    "address": {
        "street": "3159 W 11th St",
        "city": "Cleveland",
        "state": "OH"
    }
}
```

## Templating

Basic `array` access:

```blade
@verbatim// Array access
{{ $entry->address['city'] }}

@foreach ($entry->address $key => $value)
{{ $key }}: {{ $value }}
@endforeach
@endverbatim
```

### Expanded Value

The expanded value provides collection-like access to the data.

```blade
@verbatim// Expanded value
{{ $entry->address()->implode(', ') }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
