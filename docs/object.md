---
title: Object Type
link_title: Object
category: field_types
intro: The `object` field type stores structured `key:value` data.
stage: drafting
enabled: true
---

## Overview

The `object` field type is used for storing objects. Objects can be simple or complex types. By default, any type is valid.

```json
// streams/example.json
"fields": {
    "address": {
        "type": "object"
    }
}
```

### Data Structure

```json
{
    "address": {
        "street": "3159 W 11th St",
        "city": "Cleveland",
        "state": "OH"
    }
}
```

Basic object access:

```blade
@verbatim// Array access
{{ $entry->address->street }}
@endverbatim
```

### Decorator Usage

The decorated value provides an object as well.

```blade
@verbatim// Decorated value
{{ $entry->address->street }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration

### Schemas

Use the `sdchemas` configuration to specify the allowed types. If specified, each item must be valid against one of the provided types.

```json
// streams/example.json
"fields": {
    "items": {
        "type": "object",
        "config": {
            "schemas": [
                { "stream": "addresses" },
                { "abstract": "App\\Support\\Address" }
            ]
        }
    }
}
```
