---
title: Encrypted Text
link_title: Encrypted
intro: Store non-readable text that can be decrypted.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `encrypted` field type stores a two-way encrypted string.

```json
// streams/example.json
"fields": {
    "secret": {
        "type": "encrypted"
    }
}
```

## Data Structure

```json
{
    "secret": "eyJpdiI6IkRKSWdqMDVDUXYzR3pJRTkwZjJZRmc9PSIsInZhbHVlIjoic3NrUHF4RE1jVnFBVFIrNG85Rjh4VlZkU1kzQUs5VEp5b3Y5VVU2cUZYYz0iLCJtYWMiOiIyNWFhZTM1MDBhZTdmNDZiY2E2NzM2NjE1NjYzYThmMmMzYTczNGJhM2VlNjBiZDdkZmNlOGFhMWVkZmQwN2RjIiwidGFnIjoiIn0="
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
{{ $entry->secret()->decrypt() }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
