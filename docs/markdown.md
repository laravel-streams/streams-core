---
title: Markdown Text
link_title: Markdown
intro: Store [markdown](https://commonmark.org/help/) formatted text.
category: field_types
enabled: true
sort: 0
---

## Overview

The `markdown` field type stores a one-way hashed string.

```json
// streams/example.json
"fields": {
    "text": {
        "type": "markdown"
    }
}
```

## Data Structure

```json
{
    "text": "An **example** string."
}
```

## Templating

Basic value access displays the unparsed value:

```blade
@verbatim// Basic access
{{ $entry->text }}
@endverbatim
```

### Expanded Value

To get anything out of your stored value you will need to expand it.

```blade
@verbatim// Expanded value
{{ $entry->text()->parse() }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
