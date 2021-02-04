---
title: Installation
category: getting_started
intro:
enabled: true
---

### Download

Download the Streams Core package using Composer.

```bash
composer require streams/core
```

You might consider starting with the [Streams starter application](/docs/installation).

### Publish Assets

Use the following command to publish the public assets required for this package.

```bash
php artisan vendor:publish --vendor=Streams\\Core\\CoreServiceProvider --tag=public
```

## Updating

From within your project, use Composer to update individual packages:

```bash
composer update streams/core --with-dependencies
```

You can, of course, update your entire project using `composer update`.
