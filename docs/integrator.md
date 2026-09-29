---
title: Integrator
nav_title: Integrator
description: Wire application entries into config, streams, routes, and providers at boot.
section: packages
package: core
order: 150
tags: [core, integrator]
status: ready
---

`Streams\Core\Support\Integrator` merges application (or addon) configuration into Laravel during boot.

## integrate()

```php
Integrator::integrate([
    'locale' => 'en',
    'config' => ['app.name' => 'Acme'],
    'streams' => [
        'pages' => ['name' => 'Pages', 'fields' => []],
    ],
    'routes' => function ($router) {
        // register routes
    },
]);
```

## Available merge keys

| Key | Method | Purpose |
|-----|--------|---------|
| `locale` | `Integrator::locale()` | App locale |
| `config` | `Integrator::config()` | Config values |
| `assets` | `Integrator::assets()` | Asset paths |
| `aliases` | `Integrator::aliases()` | Class aliases |
| `bindings` | `Integrator::bindings()` | Container bindings |
| `singletons` | `Integrator::singletons()` | Singleton bindings |
| `commands` | `Integrator::commands()` | Artisan commands |
| `listeners` | `Integrator::listeners()` | Event listeners |
| `policies` | `Integrator::policies()` | Authorization policies |
| `routes` | `Integrator::routes()` | Route closures |
| `providers` | `Integrator::providers()` | Service providers |
| `schedules` | `Integrator::schedules()` | Scheduled tasks |
| `middleware` | `Integrator::middleware()` | Middleware aliases |
| `streams` | `Integrator::streams()` | Stream definitions |
| `includes` | `Integrator::includes()` | View includes |

Applications call `Integrator::integrate()` automatically when activated. Addons use the same mechanism during package boot.

## Related

- [Applications](/docs/core/applications)
- [Addons](/docs/core/addons)
