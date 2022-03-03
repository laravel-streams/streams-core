---
title: Relationship Type
link_title: Relationship
intro: Relate to any stream entry.
category: field_types
stage: drafting
enabled: true
---

## Overview

A single relationship to a stream entry.

```json
// streams/users.json
"fields": {
    "user": {
        "type": "relationship",
        "config": {
            "related": "users"
        }
    }
}
```

## Data Structure

```json
{
    "user": "655de760-6ba0-3f4f-ad0c-8051588ad6e2"
}
```

Basic value access displays the entry instance:

```blade
@verbatim// Basic access
{{ $entry->user->email }}@endverbatim
```

### Decorator Usage

The decorated value also provides the same instance.

```blade
@verbatim// Decorated value
{{ $entry->user()->email }}
{!! $entry->user()->email()->mailto() !!}@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration

```json
// streams/users.json
"fields": {
    "user": {
        "type": "relationship",
        "config": {
            "related": "users"
        }
    }
}
```
