# Views

- [Introduction](#introduction)
    - [Paths](#paths)
    - [Paths](#paths)

<hr>

<a name="introduction"></a>
## Introduction

Views in PyroCMS work almost exactly the same as [views in Laravel](https://laravel.com/docs/5.1/views).

The primary difference between PyroCMS and Laravel views is that PyroCMS uses [Twig](http://twig.sensiolabs.org) as it's primary templating language.

<a name="paths"></a>
### Paths

To avoid having to use full paths to your views there are a number of path hints available. Hints are a namespace that prefixes the view path.

	"theme::hello"

	"anomaly.module.products::products"

#### Available Path Hints

All paths are relative to your applications base path.

- `storage`: storage/streams/{app_reference}/
- `streams`: vendor/anomaly/streams-platform/resources/views/
- `theme`: {active\_theme\_path}/resources/views/
- `module`: {active\_module\_path}/resources/views/
- `app`: resources/{app_reference}/views/
- `shared`: resources/core/views/
- `root`: /

<div class="alert alert-info">
<strong>Note:</strong> Every single addon also registers a prefix for it's view path like <strong>vendor.module.example</strong>
</div>

<a name="presenters"></a>
### Presenters

PyroCMS uses a view composer that automatically decorates all data passed into it. For more information check out the [presenter documentation](presenters).