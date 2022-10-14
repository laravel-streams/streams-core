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

## Configuration

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
