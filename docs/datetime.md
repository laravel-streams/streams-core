---
title: Datetime Type
link_title: Datetime
intro: Store datetime values.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `datetime` field type stores both date and time.

```json
// streams/example.json
"fields": {
    "starts_at": {
        "type": "datetime"
    }
}
```

### Configuration

@todo Generate config options from class::configuration

```json
// streams/example.json
"fields": {
    "starts_at": {
        "type": "datetime",
        "config": {
            "default": "now"
        }
    }
}
```

## Data Structure

```json
{
    "starts_at": "2021-01-01 09:30:00"
}
```

## Templating

Basic value access returns the stored value:

```blade
@verbatim// Basic access
{{ $entry->starts_at }}@endverbatim
```

### Expanded Value

Datetime types also provide expanded values which returns a [Carbon](https://carbon.nesbot.com/) instance.

```blade
@verbatim// Expanded value
{{ $entry->startsAt()->diffForHumans() }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
