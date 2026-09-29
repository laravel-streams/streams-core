---
title: 'Core: Images'
nav_title: Images
description: 'Images::make, alterations, picture/srcset, versioning, and auto-alt.'
section: packages
package: core
order: 180
tags: [core, images]
status: ready
---

Core image handling wraps Intervention Image with stream-aware URL generation, alterations, and responsive output.

## Creating images

```php
use Streams\Core\Support\Facades\Images;

$url = Images::make('storage://uploads/photo.jpg')
    ->resize(800, 600)
    ->crop(400, 400)
    ->url();
```

`Images::make()` accepts path strings or arrays and detects local, remote, and storage sources.

## Alterations

Alterations chain via `__call()` — common methods include `resize`, `crop`, `fit`, `widen`, `heighten`, `blur`, `greyscale`, and `quality`.

## Responsive output

```php
Images::make('photo.jpg')->picture();
Images::make('photo.jpg')->srcset();
Images::make('photo.jpg')->img();
```

## Configuration

| Key | Purpose |
|-----|---------|
| `streams.core.auto_alt` | Generate alt text when missing |
| `streams.core.version_images` | Append version query for cache busting |

## Related

- [Assets](/docs/core/assets)
- [Hub: Images](/docs/images)
