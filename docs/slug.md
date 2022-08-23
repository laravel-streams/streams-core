---
title: Slug Type
link_title: Slug
category: field_types
intro: The `slug` field type stores `key:value` slug data.
stage: drafting
enabled: true
---

## Overview

The `slug` field type is used for storing indexed arrays. Items can be simple or complex types. By default, any item type is valid.

```json
// streams/example.json
"fields": {
    "id": {
        "type": "slug"
    }
}
```

### Data Structure

```json
{
    "id": "john-doe"
}
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
