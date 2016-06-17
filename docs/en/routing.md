# Routing

- [Basic Routing](#basic-routing)
- [Addon Routing](#addon-routing)

<hr>

<a name="basic-routing"></a>
## Basic Routing

Basic routing in PyroCMS works exactly the same as [routing in Laravel](https://laravel.com/docs/5.1/routing).

### Deferred Routes

Similar to Laravel you can create a `/resources/core/routes.php` file to define routes. The primary difference is that it is loaded second to last.

You can also create a site specific `/resources/{$appReference}/routes.php` file to define routes specific to a single application in a multisite setup. These routes are only loaded last.

<div class="alert alert-primary">
<strong>Pro Tip:</strong> A route with the same name or path as another route defined <strong>before</strong> it will take precedence.
</div>

<hr>

<a name="addon-routing"></a>
## Addon Routing

Addons are responsible for routing themselves. There are a couple extra ways that make it convenient to do this. Of course you can still use basic Laravel routing, it's just that addons typically contain their own routing.

#### Route Files

Every addon type supports _multiple_ `*.php` files in it's `resources/routes` directory.

    // example-module/resources/routes/widgets.php
    \Route::get($uri, $callback);
    \Route::post($uri, $callback);
    \Route::put($uri, $callback);
    \Route::patch($uri, $callback);
    \Route::delete($uri, $callback);
    \Route::options($uri, $callback);

#### Addon Service Provider

Every addon type supports [service providers](service-providers). The `AddonServiceProvider` supports a `$routes` property that makes routing easy.

    protected $routes = [
        'admin/files/folders'                   => 'Anomaly\FilesModule\Http\Controller\Admin\FoldersController@index',
        'admin/files/folders/create'            => 'Anomaly\FilesModule\Http\Controller\Admin\FoldersController@create',
        'admin/files/folders/edit/{id}'         => 'Anomaly\FilesModule\Http\Controller\Admin\FoldersController@edit',
        'admin/files/folders/assignments/{id}'  => 'Anomaly\FilesModule\Http\Controller\Admin\FoldersController@fields'
    ];

You can also route more complex routes using constraints and specific HTTP verbs this way.

    protected $routes = [
        'admin/files/upload/{disk}/{path?}'                            => [
            'uses'        => 'Anomaly\FilesModule\Http\Controller\Admin\FilesController@upload',
            'verb'        => 'post',
            'constraints' => [
                'disk' => '^[a-z0-9_]+$',
                'path' => '(.*)'
            ]
        ],
    ];
