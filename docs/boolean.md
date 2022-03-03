---
title: Boolean Type
link_title: Boolean
intro: Store boolean values.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `boolean` field type stores true/false values.

```json
// streams/users.json
"fields": {
    "enabled": {
        "type": "boolean"
    }
}
```


## Data Structure

```json
{
    "enabled": true
}
```

Basic value access displays the stored key value:

```blade
@verbatim// Basic access
{{ $entry->enabled }}@endverbatim
```

### Decorator Usage

Boolean types also provide decorated values.

```blade
@verbatim// Decorated value
@if ($entry->enabled()->isTrue())
    // ...
@endif@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration

```json
// streams/users.json
"fields": {
    "enabled": {
        "type": "boolean",
        "config": {
            "default": false
        }
    }
}
```
