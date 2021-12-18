---
title: Time Type
link_title: Time
intro: Store time values.
category: field_types
enabled: true
sort: 0
---

## Overview

The `time` field type stores only time.

```json
// streams/example.json
"fields": {
    "starts_at": {
        "type": "time"
    }
}
```

### Configuration

@todo Generate config options from class::configuration


## Data Structure

```json
{
    "starts_at": "09:30:00"
}
```

## Templating

Basic value access returns the stored value:

```blade
@verbatim// Basic access
{{ $entry->starts_at }}@endverbatim
```

### Expanded Value

Date types also provide expanded values which returns a [Carbon](https://carbon.nesbot.com/) instance.

```blade
@verbatim// Expanded value
{{ $entry->startsAt()->format('g:i a') }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
