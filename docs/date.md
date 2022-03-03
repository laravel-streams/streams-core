---
title: Date Type
link_title: Date
intro: Store date values.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `date` field type stores only date.

```json
// streams/example.json
"fields": {
    "starts_at": {
        "type": "date"
    }
}
```

### Configuration

@todo Generate config options from class::configuration

```json
// streams/example.json
"fields": {
    "starts_at": {
        "type": "date",
        "config": {
            "default": "today"
        }
    }
}
```

## Data Structure

```json
{
    "starts_at": "2021-01-01"
}
```

## Templating

Basic value access returns the stored value:

```blade
@verbatim// Basic access
{{ $entry->starts_at }}@endverbatim
```

### Decorated Value

Date types also provide decorated values which returns a [Carbon](https://carbon.nesbot.com/) instance.

```blade
@verbatim// Decorated value
{{ $entry->startsAt()->isWeekend() }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
