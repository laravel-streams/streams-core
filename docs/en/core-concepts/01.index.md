---
title: Core Concepts
---

## Core Concepts[](#core-concepts)

This section will go over the core concepts of the Streams Platform so that you can identify, understand, and apply them in your development.


### Service Container[](#core-concepts/service-container)

The service container can be used exactly the same as described in [Laravel documentation](https://laravel.com/docs/5.3/container).

The Laravel service container is a powerful tool for managing class dependencies and performing dependency injection. Dependency injection is a fancy phrase that essentially means this: class dependencies are "injected" into the class via the constructor or, in some cases, "setter" methods.

Let's look at a simple example:

    <?php namespace Anomaly\UsersModule\Http\Controller;

    use Anomaly\Streams\Platform\Http\Controller\PublicController;
    use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;

    class UsersController extends PublicController
    {

        public function view(UserRepositoryInterface $users)
        {
            if (!$user = $users->findByUsername($this->route->getParameter('username'))) {
                abort(404);
            }

            return $this->view->make('anomaly.module.users::users/view', compact('user'));
        }
    }

In this example, the `UserController` needs to retrieve a specific user from a data source. So, we will **inject** a service that is able to retrieve users. In this context, our `UserRepositoryInterface` to retrieve user information from the database. However, since the repository interface is injected, we are able to easily swap it out with another implementation. We are also able to easily "mock", or create a dummy implementation of the `UserRepository` when testing our application.

A deep understanding of the service container is essential to building a large powerful application.


#### Bindings[](#core-concepts/service-container/bindings)

This section will go over how to define a bindings in the service container.

Almost all of your service container bindings in PyroCMS will be registered within [addon service providers](#service-providers), so most of these examples will demonstrate binding in that context.

For more information on registering bindings with native Laravel service providers please refer to Laravel documentation on [Service Container > Binding](https://laravel.com/docs/5.3/container#binding).


##### The Bindings Property[](#core-concepts/service-container/bindings/the-bindings-property)

Within an addon service provider you can register a binding by defining them in the `$bindings` array. Bindings should be defined in an `Abstract => Instance` format:

    protected $bindings = [
        'login'                                                     => 'Anomaly\UsersModule\User\Login\LoginFormBuilder',
        'register'                                                  => 'Anomaly\UsersModule\User\Register\RegisterFormBuilder',
        'reset_password'                                            => 'Anomaly\UsersModule\User\Password\ResetPasswordFormBuilder',
        'forgot_password'                                           => 'Anomaly\UsersModule\User\Password\ForgotPasswordFormBuilder',
        'Illuminate\Auth\Middleware\Authenticate'                   => 'Anomaly\UsersModule\Http\Middleware\Authenticate',
        'Anomaly\Streams\Platform\Http\Middleware\Authenticate'     => 'Anomaly\UsersModule\Http\Middleware\Authenticate',
        'Anomaly\Streams\Platform\Model\Users\UsersUsersEntryModel' => 'Anomaly\UsersModule\User\UserModel',
        'Anomaly\Streams\Platform\Model\Users\UsersRolesEntryModel' => 'Anomaly\UsersModule\Role\RoleModel',
    ];

Note that we can also bind simple strings instead of interfaces. This will let us easily resolve the binding out of the container later.


##### Using the container directly[](#core-concepts/service-container/bindings/using-the-container-directly)

Within an addon service provider, you always have access to the container via the `$this->app` property. We can register also bindings using the `bind` method, passing the class or interface name that we wish to register along with a `Closure` that returns an instance of the class:

    $this->app->bind('HelpSpot\API', function ($app) {
        return new HelpSpot\API($app->make('HttpClient'));
    });

Note that we receive the container itself as an argument to the resolver. We can then use the container to resolve sub-dependencies of the object we are building.

An example of using this method within the context of an addon service provider might look like this:

    public function register() {

        $this->app->bind('HelpSpot\API', function ($app) {
            return new HelpSpot\API($app->make('HttpClient'));
        });
    }


#### Binding a Singleton[](#core-concepts/service-container/binding-a-singleton)

The `singleton` method binds a class or interface into the container that should only be resolved one time. Once a singleton binding is resolved, the same object instance will be returned on subsequent calls into the container:

    protected $singletons = [
        'Anomaly\UsersModule\User\Contract\UserRepositoryInterface'               => 'Anomaly\UsersModule\User\UserRepository',
        'Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface'               => 'Anomaly\UsersModule\Role\RoleRepository',
        'Anomaly\UsersModule\Authenticator\Authenticator'                         => 'Anomaly\UsersModule\Authenticator\Authenticator',
    ];

You can also define them by access the container directly:

    $this->app->singleton('HelpSpot\API', function ($app) {
        return new HelpSpot\API($app->make('HttpClient'));
    });


#### Binding an existing object[](#core-concepts/service-container/binding-an-existing-object)

You may also bind an existing object instance into the container using the `instance` method. The given instance will always be returned on subsequent calls into the container:

    $api = new HelpSpot\API(new HttpClient);

    $this->app->instance('HelpSpot\Api', $api);


#### Binding Primitives[](#core-concepts/service-container/binding-primitives)

Sometimes you may have a class that receives some injected classes, but also needs an injected primitive value such as an integer. You may easily use contextual binding to inject any value your class may need:

    $this->app->when('App\Http\Controllers\UserController')
              ->needs('$variableName')
              ->give($value);


#### Binding Interfaces To Implementations[](#core-concepts/service-container/binding-interfaces-to-implementations)

A very powerful feature of the service container is its ability to bind an interface to a given implementation. For example, let's assume we have an `UserRepositoryInterface` interface and a `CustomUserRepository` implementation. Once we have coded our `CustomUserRepository` implementation of this interface, we can register it with the service container like so:

    $this->app->bind(
        'Anomaly\UsersModule\User\Contract\UserRepositoryInterface',
        'App\User\CustomUserRepository'
    );

This statement tells the container that it should inject the `CustomUserRepository` when a class needs an implementation of `UserRepositoryInterface`. Now we can type-hint the `UserRepositoryInterface` interface in a constructor, or any other location where dependencies are injected by the service container:

    <?php namespace Anomaly\UsersModule\Http\Controller;

    use Anomaly\Streams\Platform\Http\Controller\PublicController;
    use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;

    class UsersController extends PublicController
    {

        public function view(UserRepositoryInterface $users)
        {
            if (!$user = $users->findByCustomMethod($this->route->getParameter('username'))) {
                abort(404);
            }

            return $this->view->make('anomaly.module.users::users/view', compact('user'));
        }
    }


#### Contextual Bindings[](#core-concepts/service-container/contextual-bindings)

Sometimes you may have two classes that utilize the same interface, but you wish to inject different implementations into each class. For example, two controllers may depend on different implementations of the `Illuminate\Contracts\Filesystem\Filesystem` contract. You can leverage Laravel's contextual binding to accomplish this behavior:

    use Illuminate\Support\Facades\Storage;
    use App\Http\Controllers\PhotoController;
    use App\Http\Controllers\VideoController;
    use Illuminate\Contracts\Filesystem\Filesystem;

    $this->app->when(PhotoController::class)
          ->needs(Filesystem::class)
          ->give(function () {
              return Storage::disk('local');
          });

    $this->app->when(VideoController::class)
          ->needs(Filesystem::class)
          ->give(function () {
              return Storage::disk('s3');
          });


### Service Providers[](#core-concepts/service-providers)

Service providers are the central place of all PyroCMS addon bootstrapping. Your own custom website or application, the Streams Platform, all addons, and all of Laravel's core services are bootstrapped via service providers.

But, what do we mean by "bootstrapped"? In general, we mean **registering** things, including registering service container bindings, event listeners, middleware, and even routes. Service providers are the central place to configure your application and addons.

PyroCMS uses primarily `addon service providers` to register things because Pyro has a modular addon-based infrastructure. However you can still use [Laravel service providers](https://laravel.com/docs/5.3/providers) all the same.

In this section you will learn how to write your own addon service providers and register various services with them.


#### Writing Service Providers[](#core-concepts/service-providers/writing-service-providers)

All addon service providers extend the `Anomaly\Streams\Platform\Addon\AddonServiceProvider` class. Addon service providers contain a number of properties to quickly define bindings, routes, and even views. They also contain the Laravel `register` and a `boot` methods.

<div class="alert alert-info">**Note:** The **register** and **boot** method are both called with the service container and support method injection.</div>

When creating an addon the service provider will automatically be created for you:

    php artisan make:addon example.module.test

You can also create your own addon service providers by transforming the addon class name into it's corresponding service provider class name:

    TestModule -> TestModuleServiceProvider

Here is what a generated addon service provider looks like:

    <?php namespace Example\TestModule;

    use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

    class TestModuleServiceProvider extends AddonServiceProvider
    {

        /**
         * The addon plugins.
         *
         * @var array
         */
        protected $plugins = [];

        /**
         * The addon routes.
         *
         * @var array
         */    
        protected $routes = [];

        /**
         * The addon middleware.
         *
         * @var array
         */
        protected $middleware = [];

        /**
         * The addon event listeners.
         *
         * @var array
         */
        protected $listeners = [];

        /**
         * The addon alias bindings.
         *
         * @var array
         */
        protected $aliases = [];

        /**
         * The addon simple bindings.
         *
         * @var array
         */
        protected $bindings = [];

        /**
         * Other addon service providers.
         *
         * @var array
         */
        protected $providers = [];

        /**
         * The addon singleton bindings.
         *
         * @var array
         */
        protected $singletons = [];

        /**
         * The addon view overrides.
         *
         * @var array
         */
        protected $overrides = [];

        /**
         * The addon mobile-only view overrides.
         *
         * @var array
         */
        protected $mobile = [];

        /**
         * Register the addon.
         *
         * @var void
         */
        public function register()
        {
        }

        /**
         * Boot the addon.
         *
         * @var void
         */
        public function map()
        {
        }
    }


##### AddonServiceProvider::$plugins[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-plugins)

The `$plugins` property let's you easily define plugins provided by the addon. This is helpful if you develop a module that has specific plugin functions to accomodate it's use.

**Example**

    protected $plugins = [
        \Anomaly\UsersModule\UsersModulePlugin::class,
    ];


##### AddonServiceProvider::$commands[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-commands)

The `$commands` property let's you easily define Artisan commands provided by the addon.

**Example**

    protected $commands = [
        \Anomaly\ExampleModule\Console\DoWork::class,
    ];


##### AddonServiceProvider::$schedules[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-schedules)

The `$schedules` property let's you easily define scheduled tasks.

**Example**

    protected $schedules = [
        'daily' => [
    		\Anomaly\LogsModule\Console\ArchiveLogs::class,
    	],
    	'*/10 * * * *' => [
    		\Anomaly\LogsModule\Console\ScrapeLogs::class,
    	],
    ];


##### AddonServiceProvider::$routes[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-routes)

The `routes` property let's you quickly define basic addon routes. Routes defined here are very similar to the arguments you would typically pass Laravel's `Router` class:

<div class="alert alert-info">**Learn More:** For more information on route definitions checkout the [documentation on routing](#the-basics/routing).</div>

**Example**

    protected $routes = [
        'login' => 'Anomaly\UsersModule\Http\Controller\LoginController@login',
    ];


##### AddonServiceProvider::$middleware[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-middleware)

The `$middleware` property let's you define middleware to push into the `MiddlewareCollection`. Middleware in this collection are ran for every request:

**Example**

    protected $middleware = [
        \Anomaly\UsersModule\Http\Middleware\CheckSecurity::class
    ];


##### AddonServiceProvider::$listeners[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-listeners)

The `$listeners` property let's you easily define event listeners. Event listeners are defined in an `Event => (array)Listeners` format.

<div class="alert alert-primary">**Pro Tip:** You can also dictate the listener's priority by including a priority value. Listeners are ran in order of highest to lowest priority.</div>

**Example**

    protected $listeners = [
        'Anomaly\UsersModule\User\Event\UserWasLoggedIn'                  => [
            'Anomaly\UsersModule\User\Listener\TouchLastLogin',
        ],
        'Anomaly\Streams\Platform\Application\Event\ApplicationHasLoaded' => [
            'Anomaly\UsersModule\User\Listener\TouchLastActivity' => -100,
        ],
    ];


##### AddonServiceProvider::$aliases[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-aliases)

The `$aliases` property lets you quickly define alias bindings.

**Example**

    protected $aliases = [
        'users' => \Anomaly\UsersModule\User\Contract\UserRepositoryInterface::class
    ];


##### AddonServiceProvider::$bindings[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-bindings)

The `$bindings` property lets you quickly define simple bindings.

**Example**

    protected $bindings = [
        'login' => 'Anomaly\UsersModule\User\Login\LoginFormBuilder',
    ];


##### AddonServiceProvider::$providers[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-providers)

Sometimes you might ship another package dependency with your addon. Or split up registration tasks between multiple service providers. The `$providers` property let's you do this.

**Example**

    protected $providers = [
        \TeamTNT\Scout\TNTSearchScoutServiceProvider::class
    ];


##### AddonServiceProvider::$singletons[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-singletons)

The `$singletons` let's you easily define singleton bindings.

**Example**

    protected $singletons = [
        'Anomaly\UsersModule\User\Contract\UserRepositoryInterface' => 'Anomaly\UsersModule\User\UserRepository',
    ];


##### AddonServiceProvider::$overrides[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-overrides)

The `$overrides` property allows you to define specific view override definitions for the `view composer`.

**Example**

    protected $overrides = [
        'streams::form/partials/wrapper' => 'example.theme.test::overrides/field_wrapper',
    ];


##### AddonServiceProvider::$mobile[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-mobile)

The `$mobile` property allows you to define specific mobile-only view override definitions for the `view composer`.

**Example**

    protected $mobile = [
        'streams::form/partials/wrapper' => 'example.theme.test::mobile/field_wrapper',
    ];


##### AddonServiceProvider::register()[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-register)

As mentioned previously, within the `register` method, you should only bind things into the [service container](#core-concepts/service-container). Typically, you should never attempt to register any event listeners, routes, or any other piece of functionality within the `register` method. Otherwise, you may accidentally use a service that is provided by a service provider which has not loaded yet.

In PyroCMS however there is a predictable loading order within the addon itself so you may inject any bindings defined in the properties for use. They have already been registered.

Let's take a look at a basic service provider. Within any of your service provider methods, you always have access to the `$app` property which provides access to the service container:

###### Returns: `void` or `null`

###### Example

    <?php

    namespace App\Providers;

    use Riak\Connection;
    use Illuminate\Support\ServiceProvider;

    class RiakServiceProvider extends ServiceProvider
    {
        /**
         * Register bindings in the container.
         *
         * @return void
         */
        public function register()
        {
            $this->app->singleton(Connection::class, function ($app) {
                return new Connection(config('riak'));
            });
        }
    }


##### AddonServiceProvider::boot()[](#core-concepts/service-providers/writing-service-providers/addonserviceprovider-boot)

So, what if we need to register a view composer within our service provider? This should be done within the `boot` method. **This method is called after all other addon service providers have been registered**, meaning you have access to all other services that have been registered by all other addons.

###### Returns: `void`

###### Example

    <?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;

    class ComposerServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot()
        {
            view()->composer('view', function () {
                //
            });
        }
    }
