---
title: Caching
category: basics
intro: 
sort: 21
stage: drafting
enabled: true
---

## Introduction

Streams provide a convenient service to manage [Laravel cache](https://laravel.com/docs/cache) data linked to a Stream. When caching in this way, all cached items linked to a Stream can be flushed together.

### Configuration

Domain-linked caching uses [Laravel cache configuration](https://laravel.com/docs/8.x/cache#configuration) for both cached data and the cache collection store itself.

@todo Document configuration for this.

```json
/streams/examples.json
{
    "config": {
        "cache.collection": "default",
        "cache.store": "default"
    }
}
```

## Cache Usage

You can interact with domain-linked cache stores directly using stream instances.

### Obtaining A Cache Instance

To obtain a Stream-linked cache instance service, you may use the `cache()` method on the desired Stream instance:

```php
Streams::make('examples')->cache()->get('key');
```

### Retrieving Items

The `get` method is used to retrieve items from the cache. If the item does not exist in the cache, `null` will be returned. If you wish, you may pass a second argument to the get method specifying the default value you wish to be returned if the item doesn't exist:

```php
$cache = Streams::make('examples')->cache();

$value = $cache->get('key');

$value = $cache->get('key', 'default');
```

You may even pass a closure as the default value. The result of the closure will be returned if the specified item does not exist in the cache. Passing a closure allows you to defer the retrieval of **default** values from a database or other external service:

```php
$stream = Streams::make('examples');

$value = $stream->cache()->get('key', function () use ($stream) {
    return $stream->entries()->get();
});
```

- [Query Cache](querying#caching)

### Checking Items

To check if a cached item exists, you may use the `exists` method:

```php
$cache = Streams::make('examples')->cache();

if ($cache->has('key')) {
    ...
}
```

### Incrementing/Decrementing Values

To increment or decrement the value of a cached integer value, you may use the `increment` and `decrement` methods respectively:

```php
$cache = Streams::make('examples')->cache();

$cache->increment('key');
$cache->increment('key', $amount);

$cache->decrement('key');
$cache->decrement('key', $amount);
```

### Inserting Items

You can insert an item into domain-linked cache for a given number of **seconds** using the `remember` method:

```php
$stream = Streams::make('examples');

$stream->cache()->remember('key', 600, function() use ($stream) {
    return $stream->entries()->get();
});
```

### Retrieving Items

You can retreive cached items using the `get` method:

```php
$favorites = Streams::make('contacts')->get('favorites', $default);
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
