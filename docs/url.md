---
title: URL Type
link_title: URL
intro: Store URL strings.
category: field_types
enabled: true
sort: 0
---

## Overview

The `url` field type stores a url string.

```json
// streams/example.json
"fields": {
    "website": {
        "type": "url"
    }
}
```

## Data Structure

```json
{
    "website": "https://website.com"
}
```

## Templating

Basic value access displays the stored value:

```blade
@verbatim// Basic access
{{ $entry->website }}@endverbatim
```

### Expanded Value

Strings also provide expanded values.

```blade
@verbatim// Expanded value
@if ($entry->website)
    {!! $entry->website()->to('Visit Website') !!}
@endif@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
