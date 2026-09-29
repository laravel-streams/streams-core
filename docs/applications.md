---
title: Applications
nav_title: Applications
description: Multi-app URL matching, active application, and Integrator merge keys.
section: packages
package: core
order: 140
tags: [core, applications]
status: ready
---

Applications are entries in the stream identified by `config('streams.core.applications_id')` (default `applications`). They enable multi-tenant or multi-site setups where each application merges its own config and streams at boot.

The site-level picture, including what boot does not merge, is the [Tenancy guide](/docs/tenancy).

## Application entries

The stream schema declares `handle`, `match`, and `config`. Boot also reads these attributes when the entry JSON contains them:

- `match` — URL patterns compared with `Str::is` against `Request::fullUrl()` (include the scheme)
- `locale`
- `config` — merged into Laravel config
- `aliases`, `bindings`, `singletons`
- `streams` — paths passed to `Streams::load()`, or arrays passed to `Streams::register()`

`Integrator` can merge routes, but `bootApplication()` does not pass a `routes` key. Putting `routes` on the entry has no effect at boot.

Core activates the matching application via `Streams\Core\Support\Facades\Applications`.

## Activation flow

1. `StreamsServiceProvider` loads the applications stream
2. `ApplicationManager` matches the incoming request URL
3. `Applications::activate()` sets the active application
4. `Integrator::integrate()` merges the application's configuration

## Accessing the active application

```php
Applications::active();
Applications::activate($applicationEntry);
```

Application entries extend `Streams\Core\Application\Application` (subclass of `Entry`).

## Related

- [Tenancy guide](/docs/tenancy)
- [Integrator](/docs/core/integrator)
- [Routes](/docs/core/routes)
