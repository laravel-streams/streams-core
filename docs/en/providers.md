# Providers

- [Introduction](#introduction)
- [Addon Service Providers](#addon-service-providers)
    - [Register Method](#register)
    - [Boot Method](#boot)
    - [Routes](#routes)
    - [Bindings](#bindings)
    - [Singletons](#singletons)
    - [Aliases](#aliases)
    - [Events](#events)
    - [Plugins](#plugins)
    - [Commands](#commands)
    - [Schedule](#schedule)
    - [Providers](#providers)
    - [Middleware](#middleware)
    - [Route Middleware](#route-middleware)
    
<hr>

<a name="introduction"></a>
## Introduction

Service providers in PyroCMS work very similar to service providers in Laravel. In fact, they all extend Laravel's base service providers.

You can register your own custom service providers in the `config/streams.php` configuration file under `providers`.

<a name="register"></a>
## Register Method

Addon service providers' `register` method is called via the service container. Feel free to method inject anything you need.

    public function register(Repository $config)
    {
        if ($config->get('anomaly.module.users::example.test')) {
            $this->dispatch(new AwesomeCommand());
        }
    }

<div class="alert alert-info">
<strong>Note:</strong> The register method can also replace any of the following "shortcut" methods.
</div>

<a name="boot"></a>
## Boot Method

The `boot` method is called after all the addon service providers have been registered and ran. 

    public function boot(AddonCollection $addons)
    {
        if ($addons->has('anomaly.module.comments')) {
            $this->dispatch(new DoSomethingCool());
        }
    }

<a name="addon-service-providers"></a>
## Addon Service Providers

In PyroCMS all addons generally live within an addon. Every single addon type supports addon service providers.

All you have to do to get started is simply create an addon service provider next to your addon class. Addons automatically detect matching addon service providers via class name transformation.

    Anomaly\PostsModule\PostModule
    Anomaly\PostsModule\PostModuleServiceProvider // Detected automatically

Your addon service provider should extend `Anomaly\Streams\Platform\Addon\AddonServiceProvider`.

    class PostModuleServiceProvider extends AddonServiceProvider
    {
        // Service provider contents
    }

<a name="routes"></a>
### Routes

Routing in PyroCMS could not be easier using the `$routes` parameter.

    protected $routes = [
        'products/preview/{id}' => 'Anomaly\ProductsModule\Http\Controller\ProductsController@preview',
        'products' => [
            'verb' => 'get',
            'as' => 'anomaly.module.products::products.index',
            'uses' => 'Anomaly\ProductsModule\Http\Controller\ProductsController@index'
        ],
        'products/{slug}' => [
            'as' => 'anomaly.module.products::products.view',
            'uses' => 'Anomaly\ProductsModule\Http\Controller\ProductsController@view',
        ],
        'products/categories/{path}' => [
            'as' => 'anomaly.module.products::categories.view',
            'uses' => 'Anomaly\ProductsModule\Http\Controller\CategoriesController@view',
            'constraints' => [
                'path' => '(.*)',
            ]
        ],
    ];

<div class="alert alert-info">
<strong>Note:</strong> Named routes can easily be accessed via model routers. See the documentation on routers services for more information.
</div>

<a name="bindings"></a>
### Bindings

Binding classes and abstracts to concrete implementations works very much the same as routing. Simply add them to the `$bindings` property.

    protected $bindings = [
        'login' => 'Anomaly\UsersModule\User\Login\LoginFormBuilder',
    ];

<a name="singletons"></a>
### Singletons

Singletons can be bound nearly exactly the same as regular bindings using the `$singletons` property.

    protected $singletons = [
        'Anomaly\ProductsModule\Product\Contract\ProductRepositoryInterface' => 'Anomaly\ProductsModule\Product\ProductRepository',
    ];

<a name="aliases"></a>
### Aliases

Aliases can be bound nearly exactly the same as regular bindings using the `$aliases` property.

    protected $aliases = [
        'products' => 'Anomaly\ProductsModule\Product\ProductRepository',
    ];

<a name="events"></a>
### Events

Events can easily be registered via the `$listeners` property.

    protected $listeners = [
        'Anomaly\UsersModule\User\Event\UserWasLoggedIn'                  => [
            'Anomaly\UsersModule\User\Listener\TouchLastLogin'
        ],
        'Anomaly\Streams\Platform\Application\Event\ApplicationHasLoaded' => [
            'Anomaly\UsersModule\User\Listener\TouchLastActivity'
        ]
    ];

You can also provide a priority with event listeners.

    protected $listeners = [
        'Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered' => [
            'Anomaly\ExampleModule\Foo\Listener\DoSomething' => -10
        ]
    ];

<a name="plugins"></a>
### Plugins

To load plugins from within an another addon add the addon classes to the `$plugins` array.
 
    protected $plugins = [
        'Anomaly\UsersModule\UsersModulePlugin'
    ]; 

<a name="commands"></a>
### Commands

To register artisan commands add the command classes to the `$commands` array.
 
    protected $commands = [
        'Anomaly\SearchModule\Search\Console\Destroy',
        'Anomaly\SearchModule\Search\Console\Rebuild',
    ];

<a name="schedules"></a>
### Schedules

To register scheduled commands add them to the `$schedules` array.
 
    protected $schedules = [
        '* * * * *' => [
            'queue:send'
        ],
        'hourly' => [
            'stats:process'
        ]
    ];

<a name="providers"></a>
### Providers

To register other service providers add them to the `$providers` array.
 
    protected $providers = [
        'Mmanos\Search\SearchServiceProvider',
    ];

<a name="middleware"></a>
### Middleware

To register middleware add them to the `$middlewares` array.
 
    protected $middleware = [
        'Anomaly\UsersModule\Http\Middleware\CheckSecurity',
        'Anomaly\UsersModule\Http\Middleware\AuthorizeRouteRoles',
        'Anomaly\UsersModule\Http\Middleware\AuthorizeModuleAccess',
        'Anomaly\UsersModule\Http\Middleware\AuthorizeControlPanel',
        'Anomaly\UsersModule\Http\Middleware\AuthorizeRoutePermission',
    ];

<a name="route-middleware"></a>
### Route Middleware

    protected $routeMiddleware = [
        'auth' => 'Anomaly\UsersModule\Http\Middleware\Authorize',
    ];
