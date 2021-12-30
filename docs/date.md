---
title: Date Type
link_title: Date
intro: Store date values.
category: field_types
enabled: true
sort: 0
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

### Expanded Value

Date types also provide expanded values which returns a [Carbon](https://carbon.nesbot.com/) instance.

```blade
@verbatim// Expanded value
{{ $entry->startsAt()->isWeekend() }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
