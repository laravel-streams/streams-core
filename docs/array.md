---
title: Array Type
link_title: Array
category: field_types
intro: The `array` field type stores `key:value` array data.
stage: drafting
enabled: true
---

## Overview

The `array` field type is used for storing indexed arrays. Items can be simple or complex types. By default, any item type is valid.

```json
// streams/example.json
"fields": {
    "items": {
        "type": "array"
    }
}
```

### Data Structure

```json
{
    "items": [
        "John Doe",
        "Jane Smith"
    ]
}
```

## Templating

Basic `array` access:

```blade
@verbatim// Array access
{{ $entry->items[0] }}

@foreach ($entry->items as $index => $value)
{{ $index }}: {{ $value }}
@endforeach
@endverbatim
```

### Expanded Value

The expanded value provides collection access to the data.

```blade
@verbatim// Expanded value
{{ $entry->items()->implode(', ') }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration

### Items

Use the `items` configuration to specify the allowed item types using field configurations. If specified, each item must be valid against any of the provided types.

```json
// streams/example.json
"fields": {
    "items": {
        "type": "array",
        "config": {
            "wrapper": "array|collection|App\\MyCollection",
            "items": [
                { "type": "integer" },
                { "type": "string" },
                {
                    "type": "entry",
                    "config": {
                        "stream": "addresses"
                    }
                },
            ]
        }
    }
}
```
