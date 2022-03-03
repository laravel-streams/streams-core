---
title: Time Type
link_title: Time
intro: Store time values.
category: field_types
stage: drafting
enabled: true
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

Basic value access returns the stored value:

```blade
@verbatim// Basic access
{{ $entry->starts_at }}@endverbatim
```

### Decorator Usage

Date types also provide decorated values which returns a [Carbon](https://carbon.nesbot.com/) instance.

```blade
@verbatim// Decorated value
{{ $entry->startsAt()->format('g:i a') }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
