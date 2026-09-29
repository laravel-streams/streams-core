---
title: 'Core: Installation'
nav_title: Installation
description: Composer, publish config/streams, env vars, and first stream.
section: packages
package: core
order: 20
tags: [core, installation]
status: ready
---

Install Streams Core in a Laravel 10, 11, or 12 application via Composer. Core declares `php: ^8.2` and `laravel/framework ^10|^11|^12`. This site runs Core on Laravel 12. Core's own test suite still runs on Laravel 10, because the `streams/testing` harness is Laravel 10 only until it is widened. See the [version matrix](/docs/installation#version-matrix).

## Require the package

```bash
composer require streams/core:2.0.x-dev
```

Core 2.0 has no stable tag yet. Without the `2.0.x-dev` constraint (or `"minimum-stability": "dev"` in your `composer.json`), Composer installs the old Core 1.10.4 instead.

Laravel auto-discovers `Streams\Core\StreamsServiceProvider`.

## Publish assets

Nothing has to be published; Core runs on its defaults. Publish what you want to change:

```bash
php artisan vendor:publish --provider="Streams\Core\StreamsServiceProvider" --tag=config
php artisan vendor:publish --provider="Streams\Core\StreamsServiceProvider" --tag=streams
php artisan vendor:publish --provider="Streams\Core\StreamsServiceProvider" --tag=public
```

| Tag | Copies | To |
|-----|--------|----|
| `config` | `resources/config/core.php` | `config/streams/core.php` |
| `streams` | Core's own stream definitions (`resources/streams/`: `streams.json`, `applications.json`) | `streams/` |
| `public` | `resources/public/` | `public/vendor/streams/core` |

Always pass `--provider`. `streams/ui` and `streams/api` register a `config` tag too, so `--tag=config` on its own publishes every package's config. The `public` tag publishes nothing when the installed Core build ships no `resources/public` directory.

## Environment variables

| Variable | Purpose |
|----------|---------|
| `STREAMS_DATA_PATH` | Filebase data directory (default `streams/data`) |
| `STREAMS_SOURCE` | Default source adapter (default `filebase`) |
| `STREAMS_DEFAULT_FORMAT` | Default file format (default `json`) |

## Verify installation

Create `streams/posts.json` and query entries:

```php
Streams::entries('posts')->count();
```

## Related

- [Configuration](/docs/core/configuration)
- [Streams](/docs/core/streams)
- [Hub: Installation](/docs/installation)
