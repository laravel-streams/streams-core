---
title: Macros
nav_title: Macros
description: 'Route::streams, Str::parse, Arr::make, Factory includes, and more.'
section: packages
package: core
order: 210
tags: [core, macros]
status: ready
---

Core registers macros on Laravel classes during `StreamsServiceProvider::registerMacros()`.

## Route and URL

```php
Route::streams('posts/{id}', ['stream' => 'posts', 'view' => 'posts.show']);
URL::streams('posts/{id}', ['id' => 'hello']);
```

## Str

| Macro | Purpose |
|-------|---------|
| `Str::parse()` | Parse template strings with entry data |
| `Str::purify()` | Sanitize HTML |
| `Str::humanize()` | Human-readable strings |
| `Str::truncate()` | Truncate with ellipsis |
| `Str::isSerialized()` | Detect serialized PHP values |

## Arr

| Macro | Purpose |
|-------|---------|
| `Arr::make()` | Normalize array input |
| `Arr::parse()` | Parse nested structures |
| `Arr::export()` | Export array to string |
| `Arr::htmlAttributes()` | Build HTML attributes |

## Factory (View)

```php
Factory::parse($content, $data);
Factory::include($partial, $data);
Factory::includes($map);
```

## Translator

```php
Translator::translate($key, $replace, $locale);
```

## Related

- [Routes](/docs/core/routes)
- [Views and includes](/docs/core/views-and-includes)
