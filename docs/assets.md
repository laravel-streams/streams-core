---
title: 'Core: Assets'
nav_title: Assets
description: 'Asset registry, path namespaces, @assets Blade, and HTML helpers.'
section: packages
package: core
order: 170
tags: [core, assets]
status: ready
---

Core provides an asset registry for grouping CSS, JS, and inline fragments referenced from Blade views. There is no built-in upload pipeline or CDN integration — register paths and emit tags yourself.

## Registering assets

```php
use Streams\Core\Support\Facades\Assets;

Assets::register('theme.css', 'resources/css/theme.css');
Assets::add('styles', 'theme.css');
```

Collections group assets by name (`styles`, `scripts`, etc.).

## HTML helpers

```php
Assets::url('theme.css');
Assets::tag('theme.css');
Assets::script('app.js');
Assets::style('theme.css');
Assets::inline('critical.css');
Assets::contents('public::img/logo.svg');
```

## @assets Blade directive

```blade
@assets('styles', 'theme.css')
<link rel="stylesheet" href="/css/theme.css">
@endassets
```

The directive captures the view path and registers inline content into the named collection.

## Path namespaces

UI and addons register namespaces via `Assets::addPath()` — for example `ui` maps to package resources.

## Related

- [Facades and helpers](/docs/core/facades-and-helpers)
- [Hub: Assets](/docs/assets)
