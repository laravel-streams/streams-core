---
title: String Type
link_title: String
intro: Store text values.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `string` field type stores a basic string.

```json
// streams/example.json
"fields": {
    "name": {
        "type": "string"
    }
}
```

## Data Structure

```json
{
    "name": "John"
}
```

Basic value access displays encrypted value:

```blade
@verbatim// Basic access
{{ $entry->name }}
@endverbatim
```

### Decorator Usage

Strings also provide decorated values.

```blade
@verbatim// Decorated value
{{ implode('; ', $entry->example()->lines()) }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
