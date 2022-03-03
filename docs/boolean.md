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

## Templating

Basic value access displays the stored key value:

```blade
@verbatim// Basic access
{{ $entry->enabled }}@endverbatim
```

### Decorated Value

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
