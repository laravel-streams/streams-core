---
title: Views and includes
nav_title: Views and includes
description: View namespaces, Includes slots, ViewTemplate, and Factory includes.
section: packages
package: core
order: 190
tags: [core, views, includes]
status: ready
---

Core extends Laravel views with named include slots and template parsing helpers.

## Includes facade

```php
use Streams\Core\Support\Facades\Includes;

Includes::include('sidebar', 'partials.sidebar');

echo Includes::render('sidebar', ['user' => $user]);
```

| Method | Purpose |
|--------|---------|
| `include($slot, $name, $include?)` | Register an include for a slot |
| `slot($name)` | Get slot contents |
| `render($slot, $payload)` | Render slot with data |

## Factory macros

Blade `@include` parsing extensions via Factory macros:

```php
Factory::parse($template, $data);
Factory::include($name, $data);
Factory::includes($includes);
```

## ViewTemplate

`ViewTemplate` tracks template paths for asset collection registration in `@assets` directives.

## Related

- [Assets](/docs/core/assets)
- [Macros](/docs/core/macros)
