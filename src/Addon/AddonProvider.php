<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Anomaly\Streams\Platform\View\ViewMobileOverrides;
use Anomaly\Streams\Platform\View\ViewOverrides;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

/**
 * Class AddonProvider
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class AddonProvider
{

    /**
     * The cached services.
     *
     * @var array
     */
    protected $cached = [];

    /**
     * The registered providers.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * The router instance.
     *
     * @var Router
     */
    protected $router;

    /**
     * The factory manager.
     *
     * @var Factory
     */
    protected $factory;

    /**
     * The scheduler instance.
     *
     * @var Schedule
     */
    protected $schedule;

    /**
     * The application container.
     *
     * @var Application
     */
    protected $application;

    /**
     * The middleware collection.
     *
     * @var MiddlewareCollection
     */
    protected $middlewares;

    /**
     * The view overrides.
     *
     * @var ViewOverrides
     */
    protected $viewOverrides;

    /**
     * The mobile view overrides.
     *
     * @var ViewMobileOverrides
     */
    protected $viewMobileOverrides;

    /**
     * Create a new AddonProvider instance.
     *
     * @param Router $router
     * @param Schedule $schedule
     * @param Application $application
     * @param ViewOverrides $viewOverrides
     * @param MiddlewareCollection $middlewares
     * @param ViewMobileOverrides $viewMobileOverrides
     */
    public function __construct(
        Router $router,
        Schedule $schedule,
        Application $application,
        ViewOverrides $viewOverrides,
        MiddlewareCollection $middlewares,
        ViewMobileOverrides $viewMobileOverrides
    ) {
        $this->router              = $router;
        $this->schedule            = $schedule;
        $this->application         = $application;
        $this->middlewares         = $middlewares;
        $this->viewOverrides       = $viewOverrides;
        $this->viewMobileOverrides = $viewMobileOverrides;
    }

    /**
     * Register the service provider for an addon.
     *
     * @param Addon $addon
     */
    public function register(Addon $addon)
    {
        if ($addon instanceof Module && !$addon->isEnabled() && $addon->getSlug() !== 'installer') {
            return;
        }

        if ($addon instanceof Extension && !$addon->isEnabled()) {
            return;
        }

        if ($addon instanceof Theme && !$addon->isActive()) {
            return;
        }

        $provider = $addon->getServiceProvider();

        if (!class_exists($provider)) {
            return;
        }

        $this->providers[] = $provider = $addon->newServiceProvider();

        $this->bindAliases($provider->getAliases());
        $this->bindClasses($provider->getBindings());
        $this->registerMobile($provider->getOverrides());
        $this->bindSingletons($provider->getSingletons());
        $this->registerOverrides($provider->getOverrides());

        $this->registerRoutes($provider->getRoutes(), $addon->getNamespace());
        $this->registerApi($provider->getApi(), $addon->getNamespace());

        $this->registerEvents($provider->getListeners());
        $this->registerPlugins($provider->getPlugins());
        $this->registerCommands($provider->getCommands());
        $this->registerSchedules($provider->getSchedules());
        $this->registerMiddleware($provider->getMiddleware());
        $this->registerGroupMiddleware($provider->getGroupMiddleware());
        $this->registerRouteMiddleware($provider->getRouteMiddleware());

        $this->registerFactories($addon);

        if (method_exists($provider, 'register')) {
            $this->application->call([$provider, 'register'], ['provider' => $this]);
        }

        // Call other providers last.
        $this->registerProviders($provider->getProviders());
    }

    /**
     * Boot the service providers.
     */
    public function boot()
    {
        $booted = array_get($this->cached, 'booted', []);

        foreach ($this->providers as $provider) {
            if (in_array($class = get_class($provider), $booted)) {
                continue;
            }

            $this->cached['booted'][] = $class;

            if (method_exists($provider, 'boot')) {
                $this->application->call([$provider, 'boot']);
            }

            $this->registerAdditionalRoutes($provider);
        }
    }

    /**
     * Register the addon providers.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            $this->application->register($provider);
        }
    }

    /**
     * Register the addon commands.
     *
     * @param AddonServiceProvider $provider
     */
    public function registerCommands(array $commands)
    {
        if ($commands) {

            // To register the commands with Artisan, we will grab each of the arguments
            // passed into the method and listen for Artisan "start" event which will
            // give us the Artisan console instance which we will give commands to.
            app(Dispatcher::class)->listen(
                'Illuminate\Console\Events\ArtisanStarting',
                function (ArtisanStarting $event) use ($commands) {
                    $event->artisan->resolveCommands($commands);
                }
            );
        }
    }

    /**
     * Register the addon commands.
     *
     * @param Addon $addon
     */
    public function registerFactories(Addon $addon)
    {
        if (
            (env('APP_ENV') == 'testing' || $this->application->runningInConsole())
            && is_dir($factories = $addon->getPath('factories'))
        ) {
            app(Factory::class)->load($factories);
        }
    }

    /**
     * Bind class aliases.
     *
     * @param array $aliases
     */
    public function bindAliases(array $aliases)
    {
        if ($aliases) {
            AliasLoader::getInstance($aliases)->register();
        }
    }

    /**
     * Bind addon classes.
     *
     * @param array $bindings
     */
    public function bindClasses(array $bindings)
    {
        foreach ($bindings as $abstract => $concrete) {
            $this->application->bind($abstract, $concrete);
        }
    }

    /**
     * Bind addon singletons.
     *
     * @param array $singletons
     */
    public function bindSingletons(array $singletons)
    {
        foreach ($singletons as $abstract => $concrete) {
            $this->application->singleton($abstract, $concrete);
        }
    }

    /**
     * Register the addon events.
     *
     * @param array $listeners
     */
    public function registerEvents(array $listeners)
    {
        foreach ($listeners as $event => $classes) {
            foreach ($classes as $key => $listener) {

                $priority = 0;

                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                }

                app(Dispatcher::class)->listen($event, $listener, $priority);
            }
        }
    }

    /**
     * Register the addon routes.
     *
     * @param array $routes
     * @param null $addon
     */
    public function registerRoutes(array $routes, $addon = null)
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (!$routes) {
            return;
        }

        foreach ($routes as $uri => $route) {

            /*
             * If the route definition is an
             * not an array then let's make it one.
             * Array type routes give us more control
             * and allow us to pass information in the
             * request's route action array.
             */
            if (!is_array($route)) {
                $route = [
                    'uses' => $route,
                ];
            }

            $verb = array_pull($route, 'verb', 'any');

            $group       = array_pull($route, 'group', []);
            $middleware  = array_pull($route, 'middleware', []);
            $constraints = array_pull($route, 'constraints', []);

            if ($addon) {
                array_set($route, 'streams::addon', $addon);
            }

            if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                $this->router->resource($uri, $route['uses']);
            } else {
                $route = $this->router->{$verb}($uri, $route)->where($constraints);

                if ($middleware) {
                    call_user_func_array([$route, 'middleware'], (array)$middleware);
                }

                if ($group) {
                    call_user_func_array([$route, 'group'], (array)$group);
                }
            }
        }
    }

    /**
     * Register the addon routes.
     *
     * @param array $routes
     * @param null $addon
     */
    public function registerApi(array $routes, $addon = null)
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (!$routes) {
            return;
        }

        $this->router->group(
            [
                'middleware' => 'auth:api',
            ],
            function (Router $router) use ($routes, $addon) {
                foreach ($routes as $uri => $route) {

                    /*
                     * If the route definition is an
                     * not an array then let's make it one.
                     * Array type routes give us more control
                     * and allow us to pass information in the
                     * request's route action array.
                     */
                    if (!is_array($route)) {
                        $route = [
                            'uses' => $route,
                        ];
                    }

                    $verb        = array_pull($route, 'verb', 'any');
                    $middleware  = array_pull($route, 'middleware', []);
                    $constraints = array_pull($route, 'constraints', []);

                    if ($addon) {
                        array_set($route, 'streams::addon', $addon);
                    }

                    if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                        $router->resource($uri, $route['uses']);
                    } else {
                        $route = $router->{$verb}($uri, $route)->where($constraints);

                        if ($middleware) {
                            call_user_func_array([$route, 'middleware'], (array)$middleware);
                        }
                    }
                }
            }
        );
    }

    /**
     * Register field routes.
     *
     * @param Addon $addon
     * @param       $controller
     * @param null $segment
     */
    public function registerFieldsRoutes(Addon $addon, $controller, $segment = null)
    {
        if ($segment) {
            $segment = $addon->getSlug();
        }

        $routes = [
            'admin/' . $segment . '/fields'             => [
                'as'   => $addon->getNamespace('fields.index'),
                'uses' => $controller . '@index',
            ],
            'admin/' . $segment . '/fields/choose'      => [
                'as'   => $addon->getNamespace('fields.choose'),
                'uses' => $controller . '@choose',
            ],
            'admin/' . $segment . '/fields/create'      => [
                'as'   => $addon->getNamespace('fields.create'),
                'uses' => $controller . '@create',
            ],
            'admin/' . $segment . '/fields/edit/{id}'   => [
                'as'   => $addon->getNamespace('fields.edit'),
                'uses' => $controller . '@edit',
            ],
            'admin/' . $segment . '/fields/change/{id}' => [
                'as'   => $addon->getNamespace('fields.change'),
                'uses' => $controller . '@change',
            ],
        ];

        foreach ($routes as $uri => $route) {

            /*
             * If the route definition is an
             * not an array then let's make it one.
             * Array type routes give us more control
             * and allow us to pass information in the
             * request's route action array.
             */
            if (!is_array($route)) {
                $route = [
                    'uses' => $route,
                ];
            }

            $verb        = array_pull($route, 'verb', 'any');
            $middleware  = array_pull($route, 'middleware', []);
            $constraints = array_pull($route, 'constraints', []);

            array_set($route, 'streams::addon', $addon->getNamespace());

            if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                $this->router->resource($uri, $route['uses']);
            } else {
                $route = $this->router->{$verb}($uri, $route)->where($constraints);

                if ($middleware) {
                    call_user_func_array([$route, 'middleware'], (array)$middleware);
                }
            }
        }
    }

    /**
     * Register the addon plugins.
     *
     * @param array $plugins
     */
    public function registerPlugins(array $plugins)
    {
        if (!$plugins) {
            return;
        }

        app(Dispatcher::class)->listen(
            'Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins',
            function (RegisteringTwigPlugins $event) use ($plugins) {
                $twig = $event->getTwig();

                foreach ($plugins as $plugin) {
                    if ($twig->hasExtension($plugin)) {
                        continue;
                    }

                    $twig->addExtension(app($plugin));
                }
            }
        );
    }

    /**
     * Register the addon schedules.
     *
     * @param array $schedules
     */
    public function registerSchedules(array $schedules)
    {
        foreach ($schedules as $frequency => $commands) {
            foreach (array_filter($commands) as $command => $options) {
                if (!is_array($options)) {
                    $command = $options;
                    $options = [];
                }

                if (str_is('* * * *', $frequency)) {
                    $command = $this->schedule->command($command)->cron($frequency);
                } else {
                    $parts = explode('|', $frequency);

                    $method    = camel_case(array_shift($parts));
                    $arguments = explode(',', array_shift($parts));

                    $command = call_user_func_array([$this->schedule->command($command), $method], $arguments);
                }

                foreach ($options as $option => $arguments) {
                    if (!is_array($arguments)) {
                        $option    = $arguments;
                        $arguments = [];
                    }

                    $command = call_user_func_array([$command, camel_case($option)], (array)$arguments);
                }
            }
        }
    }

    /**
     * Register view overrides.
     *
     * @param array $overrides
     */
    public function registerMobile(array $overrides)
    {
        foreach ($overrides as $view => $override) {
            $this->viewMobileOverrides->put($view, $override);
        }
    }

    /**
     * Register view overrides.
     *
     * @param array $overrides
     */
    public function registerOverrides(array $overrides)
    {
        foreach ($overrides as $view => $override) {
            $this->viewOverrides->put($view, $override);
        }
    }

    /**
     * Register middleware.
     *
     * @param array $middleware
     */
    public function registerMiddleware(array $middleware)
    {
        foreach ($middleware as $class) {
            $this->middlewares->push($class);
        }
    }

    /**
     * Register group middleware.
     *
     * @param array $middleware
     */
    public function registerGroupMiddleware(array $middleware)
    {
        foreach ($middleware as $group => $classes) {
            $this->router->pushMiddlewareToGroup($group, $classes);
        }
    }

    /**
     * Register route middleware.
     *
     * @param array $middleware
     */
    public function registerRouteMiddleware(array $middleware)
    {
        foreach ($middleware as $name => $class) {
            $this->router->aliasMiddleware($name, $class);
        }
    }

    /**
     * Register additional routes.
     *
     * @param AddonServiceProvider $provider
     */
    public function registerAdditionalRoutes(AddonServiceProvider $provider)
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (method_exists($provider, 'map')) {
            try {
                $this->application->call([$provider, 'map']);
            } catch (\Exception $e) {
                /*
                 * If, for whatever reason, this fails let
                 * it fail silently. Mapping additional routes
                 * could be volatile at certain application states.
                 */
            }
        }
    }

    /**
     * Check if routes are cached.
     */
    public function routesAreCached()
    {
        if (in_array('routes', $this->cached)) {
            return true;
        }

        if (file_exists(base_path('bootstrap/cache/routes.php'))) {
            return $this->cached[] = 'routes';
        }

        return false;
    }
}
