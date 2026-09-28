# Streams Platform

A cohesive development system for building, administrating, and interacting with data-driven Laravel applications.

> **Versions on Packagist.** `streams/core` **2.x** (this branch, namespace `Streams\Core\`) is the rewrite.
> The **v1.10.x** releases on Packagist are the old Anomaly platform (`Anomaly\Streams\Platform\`,
> branch `1.10`), a different codebase. Require `streams/core:^2.0` for the rewrite. Until a stable 2.0.0
> is tagged, allow the dev branch (`2.0.x-dev`) or an RC (`^2.0@RC`); a bare `composer require streams/core`
> with `prefer-stable` installs v1.10.x.

## Requirements

- PHP 8.2+
- Laravel 10, 11, or 12

## Testing

```bash
php vendor/bin/phpunit tests/

XDEBUG_MODE=coverage php vendor/bin/phpunit tests/ --coverage-html=./coverage
```

## Roadmap

- [ ] Gates based on Core/Laravel Gates for authorization and customized by stream config
- [ ] Add "when" to criteria abstract
- [ ] Fix tests as is to generate coverage
- [ ] Potentially remove "workflows" in favor of pipelines from Laravel
