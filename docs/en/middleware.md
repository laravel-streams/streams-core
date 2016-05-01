# Middleware

- [Introduction](#introduction)
- [Addon Middleware](#addon-middleware)

<hr>

<a name="introduction"></a>
## Introduction

Middleware in PyroCMS works exactly the same as [middleware in Laravel](https://laravel.com/docs/5.1/middleware).

#### Middleware Collection

PyroCMS offers a simple collection that you can push middleware into that will be registered after PyroCMS's core middleware.

    app(MiddlewareCollection::class)->push(MyCustomMiddleware::class);

<hr>

<a name="addon-middleware"></a>
## Addon Middleware

Every addon type supports [service providers](service-providers). The `AddonServiceProvider` makes it easy to register middleware using the `$middleware` property.

    protected $middleware = [
        'Anomaly\UsersModule\Http\Middleware\AuthorizeModuleAccess',
        'Anomaly\UsersModule\Http\Middleware\AuthorizeControlPanel',
        'Anomaly\UsersModule\Http\Middleware\AuthorizeRoutePermission'
    ];
