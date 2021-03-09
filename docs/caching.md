---
title: Caching
category: basics
intro: 
sort: 21
stage: drafting
enabled: true
---

## Introduction

Besides [Laravel cache](https://laravel.com/docs/cache) you may use domain-linked caching. Domain-linked caching is similar to [caching with tags](https://laravel.com/docs/cache#cache-tags) but automated around [configured streams](streams#defining-streams).

### Configuration

Domain-linked caching uses the default Laravel storage driver. 

## Basic Usage

You can interact with domain-linked cache stores directly using stream instances.

### Inserting Items

You can insert an item into domain-linked cache for a given number of **seconds** using the `cache` method:

```php
Streams::make('contacts')->cache('favorites', 600, function() {
    return $this->entries()->where('favorited', true)
});
```

### Retrieving Items

You can retreive cached items using the `cached` method:

```php
$favorites = Streams::make('contacts')->cached('favorites');
```

### Forgetting Items

You can forget a specific domain-linked cached item using the `forget` method:

```php
Streams::make('contacts')->forget('favorites');
```

You can forget all domain-linked cached items for a stream using the `flush` method:

```php
Streams::make('contacts')->flush();
```

> Write operations automatically forget/flush cache.

## Related Documentation

- [Query Cache](querying#caching)
<!-- - [@todo Response Cache](routing#caching-responses) -->
<!-- - [@todo View Cache](querying#caching-results) -->
<!-- - [@todo API Cache](querying#caching-results) -->
