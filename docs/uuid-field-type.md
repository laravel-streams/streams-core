---
title: UUID Type
link_title: UUID
intro: Generate and store UUID keys.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `uuid` field type stores a UUID key.

```json
// streams/example.json
"fields": {
    "id": {
        "type": "uuid"
    }
}
```

## Data Structure

```json
{
    "id": "5fd1da4c-71d8-40e0-b723-da6dcb636d56"
}
```

Basic value access displays the stored value:

```blade
@verbatim// Basic access
{{ $entry->id }}@endverbatim
```

## Configuration

```json
// streams/example.json
"fields": {
    "id": {
        "type": "uuid",
        "unique": true,
        "config": {
            "default": true
        }
    }
}
```
