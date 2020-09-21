---
title: Streams
category: basics
intro: Streams are code-configured data-structures.
sort: 1
stage: drafting
enabled: true
references:
    - https://craftcms.com/docs/3.x/elements.html
    - https://craftcms.com/docs/3.x/element-queries.html
todo:
    - Finish streams routes
---


- Introduction
- Defining Streams
    - The Basics
    - Field Types
    - Stream Routes
- Advanced Streams
    - Extend a Stream
- Managing Entries
    - Flat File Storage
    - Entry Repositories
    - Querying Entries


## Introduction

The Streams platform leans heavily on domain-driven design (DDD). We call these domain abstractions `streams`, hence our namesake.

An example could be configuring a domain model (a stream) for a website's pages, users of an application, or feedback submissions from a form.

## Defining Streams

You can define stream configurations in the `streams/` directory using JSON files. The filenames serve as a `handle`, which you can use to reference the stream later.

It is highly encouraged to use the plural form of a noun when naming Streams—for example, contacts and people. You may also use naming conventions like `business_contacts` or `neat-people`.

### The Basics

To get started, you need only specify the `handle`, which is the filename itself, and some `fields` to describe the domain object's structure.

Let's create a little stream to hold information for a simple CRM.

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

### Field Configuration

Fields are an essential descriptor of the domain object. They describe what properties the domain object will have available and how the property data works like accessors and data mutation and casting.

The `fields` configuration keys serve as a `handle`, which you can use to reference the field later. For example, the above contact fields can be accessed later like this:

```php
$entry->email;                  // The email value.
$entry->company->email;     // The related company's email value.
```

- [Learn more about fields](fields)

### Source Configuration

If not configured otherwise, streams will utilize the flat-file database that comes built-in. In this case, **you are ready to use the stream now**.

- [Stream Entries](entries)
- [Entry Repositories](repositories)
- [Querying Entries](querying)

All databases available to Laravel are supported, though additional steps may be necessary before leveraging them.

- [Stream Sources](sources)

### Route Configuration

Stream can define routes named routes which make it easy to reference later by name.

```json
{
    "routes": {
        "index": "contacts",
        "view": "contacts/{id}"
    }
}
```

You can also use 

```json
{
    "routes": {
        "index": "contacts/{entry.email}"
    }
}
```

- [Stream Routes](routing#stream-routes)

### JSON References

You can use JSON file references within stream configurations to point to other JSON files using the `@` symbol followed by a relative path to the file. In this way, you can reuse various configuration information or tidy up larger files. **The referenced file's JSON data directly replaces the reference.**

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

### Extending Other Streams

A stream can `extend` another stream, which works like a recursive **merge**.

```json
// streams/family.json
{
    "name": "Family Members",
    "fields": {
        "relation": {
            "type": "selection",
            "config": {
                "options": {
                    "mother": "Mother",
                    "father": "Father",
                    "brother": "Brother",
                    "sister": "Sister"
                }
            }
        }
    }
}
```

In the above example, all `contacts` fields are available to you, as well as the new `relation` field.

```php
$entry->email;      // The email value.
$entry->relation;       // The relation value.
```

## Stream Entries

Domain entities are called `entries` within the Streams platform. A stream defines entry attributes, or `fields`, that dictate the entry's properties, data-casting, and more.

- [Stream Entries](entries)
- [Entry Fields](fields)
- [Field Types](fields#field-types)

### Retrieving Entities

The Streams platform separates methods to retrieve and store entries from the entry objects themselves, less a few convenient functions like `save` and `delete`, by using a repository pattern.

- [Repositories](/docs/core/repositories)
- [Querying Entries](/docs/core/querying)
