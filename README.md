# Streams Platform

A cohesive development system for building, administrating, and interacting with data-driven Laravel applications.

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
