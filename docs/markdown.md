---
title: Markdown Type
link_title: Markdown
intro: Store [markdown](https://commonmark.org/help/) formatted text.
category: field_types
stage: drafting
enabled: true
---

## Overview

The `markdown` field type stores markdown formatted text.

```json
// streams/example.json
"fields": {
    "content": {
        "type": "markdown"
    }
}
```

## Data Structure

```json
{
    "content": "An **example** string."
}
```

## Templating

Basic value access displays the unparsed value:

```blade
@verbatim// Basic access
{{ $entry->content }}
@endverbatim
```

### Expanded Value

To get anything out of your stored value you will need to expand it.

```blade
@verbatim// Parsed value
{{ $entry->content()->parse() }}

// Parsed and rendered value
{{ $entry->content()->render($payload) }}
@endverbatim
```

#### Methods

@todo Generate methods from @docs



## Configuration

@todo Generate config options from class::configuration
