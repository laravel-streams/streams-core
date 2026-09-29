---
title: Callbacks
nav_title: Callbacks
description: FiresCallbacks on streams, entries, repositories, and criteria.
section: packages
package: core
order: 220
tags: [core, callbacks]
status: ready
---

Core uses the `FiresCallbacks` trait for lifecycle hooks. These are **not** Laravel `Event::` events — they fire synchronously on the object that defines them.

## Trait API

Classes using `Streams\Core\Support\Traits\FiresCallbacks`:

| Method | Purpose |
|--------|---------|
| `addCallback($name, $callback)` | Register callback |
| `addCallbackListener($name, $callback)` | Listen without replacing |
| `observeCallbacks($object)` | Copy callbacks from another object |
| `fire($name, $payload)` | Invoke callbacks |
| `hasCallback($name)` | Check registration |

## Entry lifecycle callbacks

| Callback | When |
|----------|------|
| `creating` | Before create persists |
| `created` | After create persists |
| `saving` | Before save |
| `saved` | After save |
| `deleting` | Before delete |

## Stream callbacks

Streams fire callbacks such as `built` when the stream definition is assembled.

## Example

```php
Streams::make('posts')->addCallbackListener('creating', function ($payload) {
    // inspect $payload['entry']
});
```

## Related

- [Entries](/docs/core/entries)
- [Repositories](/docs/core/repositories)
