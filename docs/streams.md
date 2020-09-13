---
title: Streams
category: database
intro: Streams are code-configured data-structures.
sort: 1
references:
    - https://craftcms.com/docs/3.x/elements.html
    - https://craftcms.com/docs/3.x/element-queries.html
---

## Introduction

Streams are the foundation of building with the Streams platform. A stream represents a domain object in your application. For example, a CRM might have a stream for `people` and one for `companies`. Streams can extend and relate to each other and offer streamlined integration with Laravel to quickly build up basic appliction behavior.

## Defining Streams

Stream configurations are stored in the `streams/` directory as JSON files. The filenames are used as the `handle` which you can use to reference the stream later.

Stream configurations only _require_ field configurations to get started. This makes it easy to test structural ideas and firm them up later with more detail as needed.

A very basic Stream structure might look like this:

```json
// streams/contacts.json
{
    "name": "Contacts",
    "fields": {
        "name": "string",
        "email": "email",
        "company": {
            "type": "relationship",
            "stream": "companies"
        }
    }
}
```

### Stream Fields

Fields define the properties or attributes of the stream's entry data. They provide type casting, data validation, and other helpful functionality. 

- [Learn more about Fields](fields)

### Stream Routes

Stream configurations help organize routing by domain with named routes.

- [Learn more about Routing](routing)

### Stream Sources

Source configuration is defined in the Stream configuration. It defines where the source of the data for the Stream.

> If not specified, the built-in flat-file database will be used by default.

- [Learn more about Sources](sources)

### JSON References

You can use JSON file references anywhere in Stream configuration to reuse various configurations or tidy up larger ones. The JSON reference will be directly replaced with the referenced file's JSON data.

> Note all references are relative to the base installation path.

```json
// streams/contacts.json
{
    "name": "Contacts",
    "fields": "@streams/fields/contacts.json"
}
```

```json
// streams/fields/contacts.json
{
    "name": "string",
    "email": "email",
    "company": {
        "type": "relationship",
        "stream": "company"
    }
}
```

## Querying Entries

You can use entry `Criteria` to query entries from your database much like a Laravel query builder:

- [Learn more about querying](querying)

## Entries

Entries are like the rows of your database. They behave much like an `Eloquent` model. Entries will leverage the Stream configuration to maximize what you can do with your data with minimal input.

### Repositories

Repositories are the most basic way of access stream entries.

```php
foreach (Streams::repository('contacts')->all() as $entry) {
    echo $entry->expand('email')->mailto($entry->name); // <a href="mailto:obfuscated">Ryan Thompson</a>
}
```

- [Learn more about repositories](repositories)




- Introduction
- Defining Streams
    - Stream Fields
    - Stream Routes
    - Stream Sources
    - JSON References
- Querying Entries
- Entry Repositories
- Extending a Stream
