---
title: 'Core: Addons'
nav_title: Addons
description: streams-addon Composer discovery and the Addons facade.
section: packages
package: core
order: 160
tags: [core, addons]
editorial_status: ready
status: implemented
tracking_task: 256
---

Addons are Composer packages with type `streams-addon` or the `extra.streams.addon` flag. Their Laravel service providers can register streams, routes, and config through Core's Integrator at boot.

## Composer discovery

Add to your addon's `composer.json`:

```json
{
    "extra": {
        "laravel": {
            "providers": ["MyVendor\\MyAddon\\ServiceProvider"]
        },
        "streams": {
            "addon": true
        }
    }
}
```

The addon service provider typically calls `Integrator::integrate()` with streams and bindings.

Core discovers flagged packages from Composer's lock file, including development packages. The `streams-addon` Composer type remains supported without the flag. Laravel provider discovery uses `extra.laravel.providers` separately.

## Addons facade

```php
use Streams\Core\Support\Facades\Addons;

$paths = [
    'path' => __DIR__,
    'assets' => __DIR__.'/resources/public',
];

Addons::register('my-addon', $paths);
```

Use the facade to inspect registered addon paths and assets.

The attribute-array form also remains supported: `Addons::register(['name' => 'my-addon', 'path' => __DIR__, 'composer' => []])`.

## Related

- [Integrator](/docs/core/integrator)
- [Hub: Addons](/docs/addons)
