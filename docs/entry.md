---
title: Entry Type
link_title: Entry
intro: Store stream configured values.
category: field_types
enabled: true
sort: 0
---

## Overview

```json
// streams/users.json
"fields": {
    "profile": {
        "type": "entry",
        "config": {
            "stream": "profiles"
        }
    }
}
```

### Configuration

@todo Generate config options from class::configuration


## Data Structure

```json
{
    "profile": {
        "first_name": "John",
        "last_name": "Doe",
        "username": "TheRealJohnDoe"
    }
}
```

## Templating

Basic value access returns the entry instance:

```blade
@verbatim// Basic access
{{ $entry->profile->username }}@endverbatim
```

### Expanded Value

Expanded values provide the same instance.

```blade
@verbatim// Expanded value
{{ $entry->profile()->username }}@endverbatim
```

#### Methods

@todo Generate methods from @docs
