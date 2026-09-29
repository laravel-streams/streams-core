---
title: Facades and helpers
nav_title: Facades and helpers
description: Streams, Assets, Images, Applications facades and global helpers.
section: packages
package: core
order: 200
tags: [core, facades, helpers]
status: ready
---

Core registers facades and global helpers for common stream operations.

## Facades

| Facade | Accessor | Purpose |
|--------|----------|---------|
| `Streams` | `streams` | Stream manager, make, load |
| `Assets` | `assets` | Asset registry |
| `Images` | `images` | Image alterations |
| `Includes` | `includes` | View include slots |
| `Applications` | `applications` | Multi-app activation |
| `Addons` | `addons` | Addon registry |

## Global helpers

Defined in `src/helpers.php`:

```php
stream('posts');           // Stream instance
entries('posts');          // Criteria
repository('posts');       // Repository
html_attributes($attrs);   // HTML attribute string
response_time();           // Debug helper
memory_usage();            // Debug helper
```

Prefer `Streams::make()`, `Streams::entries()`, and `Streams::repository()` when facades are not imported.

## Related

- [Repositories](/docs/core/repositories)
- [Assets](/docs/core/assets)
- [Macros](/docs/core/macros)
