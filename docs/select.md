---
title: Select Type
link_title: Select
intro: Store enumerated values.
category: field_types
stage: drafting
enabled: true
sort: 0
---

## Overview

The `select` field type stores a selection from a list of options.

```json
// streams/users.json
"fields": {
    "status": {
        "type": "select",
        "config": {
            "options": {
                "enabled": "Enabled",
                "pending": "Pending",
                "disabled": "Disabled"
            },
            "default": "pending"
        }
    }
}
```

#### Callable Options

Besides basic array and associated arrays, you may specify a callable string:

```json
{
    "type": "select",
    "config": {
        "options": "\\App\\CustomOptions@handle"
    }
}
```

The `$type` can be injected in order aid in returning options:

```php
// app/CustomOptions.php
class CustomOptions
{
    public function handle($type)
    {
        return [
            'foo' => 'Bar',
        ];
    }
}
```

## Data Structure

```json
{
    "status": "enabled"
}
```

## Templating

Basic value access displays the stored key value:

```blade
@verbatim// Basic access
{{ $entry->status }}@endverbatim
```

### Expanded Value

Select types also provide expanded values.

```blade
@verbatim// Expanded value
Status: {{ $entry->status()->value() }}@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration
