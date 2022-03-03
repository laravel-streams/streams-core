---
title: Multiselect Type
link_title: Multiselect
intro: Store multiple enumerated values.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `multiselect` field type stores an array of selections from a list of options. The multiselect field type also supports [callable options](#callable-options).

```json
// streams/users.json
"fields": {
    "picks": {
        "type": "multiselect",
        "config": {
            "options": {
                "star": "Star",
                "circle": "Circle",
                "umbrella": "Umbrella",
                "triangle": "Triangle"
            }
        }
    }
}
```

#### Callable Options

Besides basic array and associated arrays, you may specify a callable string:

```json
{
    "type": "multiselect",
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
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];
    }
}
```

## Data Structure

```json
{
    "picks": ["circle", "triangle"]
}
```

Basic value access displays the stored key value:

```blade
@verbatim// Basic access
[{{ implode(', ', $entry->picks) }}]@endverbatim
```

### Decorator Usage

Multiselect types also provide decorated values.

```blade
@verbatim// Decorated value
[{{ implode(',' $entry->picks()->values()) }}]@endverbatim
```

#### Methods

@todo Generate methods from @docs

## Configuration

@todo Generate config options from class::configuration
