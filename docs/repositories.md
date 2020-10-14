---
title: Repositories
category: database
intro: 
stage: outlining
enabled: true
sort: 10
---

## Introduction

The Streams platform separates methods to retrieve and store entries from the entry objects themselves via repositories.

### Getting Started

You can initialize an entry repository using the `Streams::repository()` method and specifying the **stream**.

```php
use Streams\Core\Support\Facades\Streams;

// Start using the repository.
Streams::repository('contacts');

// You can also access from the stream.
Streams::make('contacts')->repository();
```

### New Queries

New [queries](querying) can be started from the repository.

```php
// Start a new query.
Streams::entries('contacts');

// You can also start queries from the repository.
Streams::repository('contacts')->newQuery();
```

## The Basics
### Inserting Entries
### Updating Entries
### Deleting Entries
## Extending Repositories
### [Extending Basics](extending)
### Custom Repositories
