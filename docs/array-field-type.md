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

Basic `array` access:

```blade
@verbatim// Array access
{{ $entry->items[0] }}

@foreach ($entry->items as $index => $value)
{{ $index }}: {{ $value }}
@endforeach
@endverbatim
```

### Decorator Usage

The decorated value provides [collection access](https://laravel.com/docs/collections) to the data.

```blade
@verbatim// Decorated value
{{ $entry->decorate('items')->implode(', ') }}
@endverbatim
```


## Configuration

### Wrapper

The array can optionally be wrapped with a generic **collection** or **arrayable** classname automatically when accessing the field.

```json
{
// streams/example.json
"fields": {
    "items": {
        "type": "array",
        "config": {
            "wrapper": "array|collection|App\\MyCollection"
        }
    }
}
```

```php
// welcome.blade.php
@verbatim@if($entry->items->isNotEmpty())
@foreach ($entry->items as $item)
// 
@endforeach
@endif
@endverbatim
```

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
                    "type": "object",
                    "config": {
                        "schemas": [
                            { "stream": "addresses" }
                        ]
                    }
                },
            ]
        }
    }
}
```
