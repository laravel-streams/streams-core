---
title: 'Core: Configuration'
nav_title: Configuration
description: 'config/streams/core.php — data path, sources, field types, and images.'
section: packages
package: core
order: 30
tags: [core, configuration]
status: ready
---

Core configuration lives in `config/streams/core.php`, published from the package. Environment variables override defaults for deployment-specific paths and sources.

## Key settings

| Key | Env | Default | Purpose |
|-----|-----|---------|---------|
| `streams_id` | — | `streams` | Meta-stream storing stream definitions |
| `applications_id` | — | `applications` | Multi-app configuration stream |
| `data_path` | `STREAMS_DATA_PATH` | `streams/data` | Filebase entry directory |
| `default_source` | `STREAMS_SOURCE` | `filebase` | Default adapter when omitted in stream JSON |
| `sources.filebase.default_format` | `STREAMS_DEFAULT_FORMAT` | `json` | Filebase format when a stream sets none |
| `auto_alt` | `STREAMS_AUTO_ALT` | `true` | Generate image alt text when missing |
| `version_images` | `STREAMS_VERSION_IMAGES` | `true` | Append cache-busting version to image URLs |

## OpenSearch connections

The `opensearch` source adapter reads connections from `opensearch`:

| Key | Env | Default |
|-----|-----|---------|
| `opensearch.default` | `OPENSEARCH_CONNECTION` | `default` |
| `opensearch.connections.default.hosts` | `OPENSEARCH_HOST` | `https://localhost:9200` |
| `opensearch.connections.default.username` | `OPENSEARCH_USERNAME` | none |
| `opensearch.connections.default.password` | `OPENSEARCH_PASSWORD` | none |
| `opensearch.connections.default.ssl_verification` | `OPENSEARCH_SSL_VERIFICATION` | `true` |

## Source formats

Under `sources.filebase.formats`, Core registers parsers for filebase entries:

| Format | Class |
|--------|-------|
| `json` | `Json` |
| `yaml` | `Yaml` |
| `html` | `Html` |
| `md` | `Markdown` |
| `tpl` | `Template` |

Set per-stream via `config.source.format`.

## Field types

The `field_types` array maps handle strings to PHP field type classes. Register custom types here when extending Core:

```php
'field_types' => [
    'string' => \Streams\Core\Field\Types\StringFieldType::class,
    // ...
    'my_type' => \App\Streams\MyFieldType::class,
],
```

See [Fields](/docs/core/fields) for registered handles.

## Per-stream config

Individual streams override global defaults in their JSON `config` block:

```json
{
    "config": {
        "source": { "type": "filebase", "format": "md" },
        "cache": { "enabled": true, "ttl": 3600, "store": "redis" }
    }
}
```

See [Caching](/docs/core/caching) and [Sources and adapters](/docs/core/sources-and-adapters).

## Related

- [Installation](/docs/core/installation)
- [Streams](/docs/core/streams)
- [Extending Core](/docs/core/extending-core)
