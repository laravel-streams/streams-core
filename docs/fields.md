---
title: Fields
category: core_concepts
intro:
enabled: true
sort: 10
---

## Introduction
## Defining Fields
### The Basics
### Field Validation

Streams simplify **validation** by defining validation in their configuration.

- [Defining Rules](validation#rule-configuration)

```json
// streams/contacts.json
{
    "rules": {
        "name": [
            "required",
            "max:100"
        ],
        "email": [
            "required",
            "email:rfc,dns"
        ],
        "company": "required|unique"
    }
}
```

## Field Types

- String Types
    - String
    - Select
    - Text
    - Url
    - Markdown
- Array Types
    - Arr
    - Multiselect
- Object Types
    - Entry
    - Entries
    - Polymorphic
- Relationships
    - Relationship
    - Multiple
    - Image
- Date & Time
    - Datetime
    - Integer
- Others
    - Boolean
    - Collection
    - Template
