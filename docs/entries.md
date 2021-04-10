---
title: Entries
category: core_concepts
intro:
stage: drafting
enabled: true
sort: 2
todo:
    - This needs to be organized slightly better.
---

## Introduction

Domain entities are called `entries` within the Streams platform. Please familiarize yourself with [streams](streams) before getting started with entries.

## Defining Entries

### Flat File Storage

You can define entry data using the default flat-file database within the `streams/{stream}/` directory where stream is the stream **handle** to which the entry belongs.

Like streams, entry filenames serve as an **id** called a **handle**, which you can use to reference the entry the same as you would its numeric ID. JSON is the default data format, though other [data formats](sources#data-format) are available through [source configuration](sources).

```json
// streams/contacts/ryan_thompson.json
{
    "name": "Ryan Thompson",
    "email": "ryan@domain.com",
    "company": "fundamental_llc"
}
```

## Basic Usage
### Expanding Fields

You can use the `expand` function to return expanded field values.

```php
foreach (Streams::entries('family')->where('relation', 'brother')->get() as $sibling) {
    
    // The raw value.
    $entry->email;

     // An email link.
    $entry->expand('email')->mailto();
    $entry->email()->mailto();
}
```

- [Querying Entries](querying)

### Entry Repositories

Repositories are responsible for encapsulating storage and querying logic.

Entry repositories are accessed via the `Streams` facade:

```php
foreach (Streams::repository('contacts')->all() as $entry) {
    $entry->name; // The name value.
}
```

You can also retrieve specific entries by their `handle`:

```php
$entry = Streams::repository('contacts')->find('ryan_thompson');
```

- [Entry Repositories](repositories)








## Updating Entries

Updating entries is easy. You can, of course, directly modify the flat-file data. But let's take a look at a couple of other methods.

### Entry Repositories

Like the operations above, you can use the `Stream` facade to `save` and `delete` entries.

```php
$entry->name = "Mr Ryan Thompson";

Streams::repository('contacts')->save($entry);
```

```php
Streams::repository('contacts')->delete($entry);
```

- [Entry Repositories](repositories)

### Storage Methods

You can use a few storage methods directly on the entry instance itself.

```php
$entry->name = "Mr Ryan Thompson";

$entry->save(); // Returns bool.
```

```php
$entry->delete(); // Returns bool.
```

## Entry Objects

Working with entry objects is the same regardless of the source of the stream entries. With this, you can quickly scaffold projects using flat-file storage, then easily migrate stream schema into a database and manage entries there with zero code changes.

### Configuring Abstracts

Entry abstracts are configured on the [domain model](streams#).

### Expanding Entry Values

Each field type provides it's own expanded data type besides the primary accessor and mutator casting. Please refer to individual [field type documentation] to learn more about their expanded values.

Use the `expand` method and specify the `handle` of the field to expand the value of:

```php
$entry = Streams::repository('contacts')->find('ryan_thompson');

$entry->expand('email')->mailto($entry->name); // Mailto link with custom link text.
```

- [Field Types](fields#field-types)
