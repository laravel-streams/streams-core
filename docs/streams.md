---
title: Streams
category: core_concepts
intro: Code-configured domain information.
sort: 1
stage: drafting
enabled: true
references:
    - https://craftcms.com/docs/3.x/elements.html
    - https://craftcms.com/docs/3.x/element-queries.html
todo:
    - Finish streams routes
---

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
    "source": {
        "type": "filebase",
        "filename": "streams/data/contacts",
        "format": "json"
    },
    "abstract": "Streams\\Core\\Entry\\Entry",
    "repository": "Streams\\Core\\Repository\\Repository",
    "collection": "Illuminate\\Support\\Collection",
    "fields": {
        "name": "string",
        "email": "email",
        "company": {
            "type": "relationship",
            "config": {
                "related": "companies"
            }
        }
    }
}
```

### Fields

- [Fields](fields)
- [Field Types](fields#field-types)

**Fields** are an essential descriptor of the domain object. They describe what properties the domain object will have available and how the property data works. Things like accessors, data mutation, and casting can be controlled by the field's **type**.

The **fieldsconfiguration keys** serve as a `handle`, which you can use to reference the field later. For example, the above contact fields can be accessed later like this:

```php
$entry->email;              // The email value.
$entry->company->email;     // The related company's email value.
```

### Stream Routes

- [Stream Routes](routing#stream-routes)
- [Route Options](routing#route-optionss)

Streams can streamline **routing** by defining routes in their configuration.

```json
// streams/contacts.json
{
    "routes": {
        "index": "contacts",
        "view": "contacts/{id}"
    }
}
```

You can also use an array to include other **route options**.

```json
// streams/contacts.json
{
    "routes": {
        "contact": {
            "csrf": false,
            "uri": "form/{entry.email}"
        }
    }
}
```

### Stream Validation

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

### Security

Specify the [Laravel policy](https://laravel.com/docs/authorization#creating-policies) to use for [security](security).

```json
// streams/contacts.json
{
    "policy": "App\\Contacts\\ContactPolicy"
}
```

### Caching

Streams provides a touch-free caching system you can define in the configuration.

- [Defining Rules](validation#rule-configuration)

```json
// streams/contacts.json
{
    "cache": false,
    "ttl": 1800 // 30 minutes
}
```

### Sources

Sources define the source information for entry data which you can define in the configuration.

- [Defining Sources](sources#defining-sources)

```json
// streams/contacts.json
{
    "source": {
        "type": "filebase",
        "format": "md"
    }
}
```

## Stream Entries

Domain entities are called `entries` within the Streams platform. A stream defines entry attributes, or `fields`, that dictate the entry's properties, data-casting, and more.

- [Defining Entries](entries#defining-entries)

### Abstracts

The **abstract** parameter defines the class to use when constructing entry instances.

- [Entry Abstracts](entries#entry-objects)

```json
// streams/contacts.json
{
    "abstract": "App\\Contacts\\Contact"
}
```

> When defining Elqouent stream sources, the sources model will be used as the abstract.

### Criteria

The **criteria** parameter defines the class to use when building entry queries.

- [Querying Entries](querying)

```json
// streams/contacts.json
{
    "criteria": "App\\Contacts\\ContactCriteria"
}
```

### Repositories

The **repository** parameter defines the repository class to use for the stream entries.

- [Entry Repositories](repositories)

```json
// streams/contacts.json
{
    "repository": "App\\Contacts\\ContactRepository"
}
```

## Advanced Streams

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

### Extend a Stream

A stream can `extend` another stream, which works like a recursive **merge**.

```json
// streams/family.json
{
    "name": "Family Members",
    "extend": "contacts",
    "fields": {
        "relation": {
            "type": "select",
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
$entry->relation;   // The relation value.
```

### Stream Sources

You can configure the flat-file database as well as other sources for storing data including any Laravel database. No code changes required.
