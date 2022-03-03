---
title: Hash Text
link_title: Hash
intro: Store non-readable, one-way hashed text.
category: field_types
enabled: true
stage: drafting
---

## Overview

The `hashed` field type stores a one-way hashed string.

```json
// streams/example.json
"fields": {
    "secret": {
        "type": "hashed"
    }
}
```

## Data Structure

```json
{
    "secret": "$2y$10$bd4ATnlv.fApn0OGSMwU7.rBOUMP2cBaFQY20NFTNdpGCYUIZMEMm"
}
```

Basic value access displays encrypted value:

```blade
@verbatim// Basic access
{{ $entry->secret }}
@endverbatim
```

### Decorator Usage

To get anything out of your stored value you will need to expand it.

```blade
@verbatim// Decorated value
@if ($entry->secret()->check('check me'))
    // Matches
@endif
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
