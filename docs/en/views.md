# Views

- [Introduction](#introduction)
    - [Paths](#paths)
    - [Overriding Views](#overriding)

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

<a name="overriding"></a>
### Overriding Views

There are a few ways to override views from addons and Streams Platform.

##### Automatic Detection

The easiest way to override a view is to simply place your own view in your theme. The view must be placed within the appropriate directory and be named the same as the view you wish to override.

The override path pattern looks like this:
 
    your-theme/resources/addons/{vendor}/{addon}-{type}/{view}

You can also override views from the streams platform.

    your-theme/resources/streams/{view}

Let's assume we have a view `example.module.forum::discussions/view` that we want to override in our theme. The override path would look like this:

    your-theme/resources/addons/example/forum-module/discussions/view.twig

##### Addon Service Provider

All addons support an `AddonServiceProvider`. You can use the `$overrides` array to define view overrides manually. Views should be defined in a `view => override` pattern. The `$mobile` array can be used in the same way to override views for mobile devices only.

    protected $overrides = [
        'streams::form/partials/wrapper' => 'theme::example/override',
    ];
