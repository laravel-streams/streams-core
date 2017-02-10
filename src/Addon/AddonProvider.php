<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Anomaly\Streams\Platform\View\ViewMobileOverrides;
use Anomaly\Streams\Platform\View\ViewOverrides;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
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
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

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
     * @param Dispatcher $events
     * @param Schedule $schedule
     * @param Application $application
     * @param ViewOverrides $viewOverrides
     * @param MiddlewareCollection $middlewares
     * @param ViewMobileOverrides $viewMobileOverrides
     */
    public function __construct(
        Router $router,
        Dispatcher $events,
        Schedule $schedule,
        Application $application,
        ViewOverrides $viewOverrides,
        MiddlewareCollection $middlewares,
        ViewMobileOverrides $viewMobileOverrides
    ) {
        $this->router              = $router;
        $this->events              = $events;
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

        $provider = $addon->getServiceProvider();

        if (!class_exists($provider)) {
            return;
        }

        $this->providers[] = $provider = $addon->newServiceProvider();

        $this->bindAliases($provider);
        $this->bindClasses($provider);
        $this->bindSingletons($provider);

        $this->registerRoutes($provider, $addon);
        $this->registerOverrides($provider, $addon);
        $this->registerApi($provider, $addon);

        $this->registerEvents($provider);
        $this->registerPlugins($provider);
        $this->registerCommands($provider);
        $this->registerSchedules($provider);
        $this->registerMiddleware($provider);
        $this->registerRouteMiddleware($provider);

        if (method_exists($provider, 'register')) {
            $this->application->call([$provider, 'register']);
        }

        // Call other providers last.
        $this->registerProviders($provider);
    }

    /**
     * Boot the service providers.
     */
    public function boot()
    {
        foreach ($this->providers as $provider) {
            if (method_exists($provider, 'boot')) {
                $this->application->call([$provider, 'boot']);
            }

            $this->registerAdditionalRoutes($provider);
        }
    }

    /**
     * Register the addon providers.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerProviders(AddonServiceProvider $provider)
    {
        foreach ($provider->getProviders() as $provider) {
            $this->application->register($provider);
        }
    }

    /**
     * Register the addon commands.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerCommands(AddonServiceProvider $provider)
    {
        if ($commands = $provider->getCommands()) {

            // To register the commands with Artisan, we will grab each of the arguments
            // passed into the method and listen for Artisan "start" event which will
            // give us the Artisan console instance which we will give commands to.
            $this->events->listen(
                'Illuminate\Console\Events\ArtisanStarting',
                function (ArtisanStarting $event) use ($commands) {
                    $event->artisan->resolveCommands($commands);
                }
            );
        }
    }

    /**
     * Bind class aliases.
     *
     * @param AddonServiceProvider $provider
     */
    protected function bindAliases(AddonServiceProvider $provider)
    {
        if ($aliases = $provider->getAliases()) {
            AliasLoader::getInstance($aliases)->register();
        }
    }

    /**
     * Bind addon classes.
     *
     * @param AddonServiceProvider $provider
     */
    protected function bindClasses(AddonServiceProvider $provider)
    {
        foreach ($provider->getBindings() as $abstract => $concrete) {
            $this->application->bind($abstract, $concrete);
        }
    }

    /**
     * Bind addon singletons.
     *
     * @param AddonServiceProvider $provider
     */
    protected function bindSingletons(AddonServiceProvider $provider)
    {
        foreach ($provider->getSingletons() as $abstract => $concrete) {
            $this->application->singleton($abstract, $concrete);
        }
    }

    /**
     * Register the addon events.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerEvents(AddonServiceProvider $provider)
    {
        if (!$listen = $provider->getListeners()) {
            return;
        }

        foreach ($listen as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (is_integer($listener)) {
                    $listener = $key;
                    $priority = $listener;
                } else {
                    $priority = 0;
                }

                $this->events->listen($event, $listener, $priority);
            }
        }
    }

    /**
     * Register the addon routes.
     *
     * @param AddonServiceProvider $provider
     * @param Addon $addon
     */
    protected function registerRoutes(AddonServiceProvider $provider, Addon $addon)
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (!$routes = $provider->getRoutes()) {
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
     * Register the addon routes.
     *
     * @param AddonServiceProvider $provider
     * @param Addon $addon
     */
    protected function registerApi(AddonServiceProvider $provider, Addon $addon)
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (!$routes = $provider->getApi()) {
            return;
        }

        $this->router->group(
            [
                'middleware' => 'auth:api',
                'prefix'     => 'api',
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

                    array_set($route, 'streams::addon', $addon->getNamespace());

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
     * Register the addon plugins.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerPlugins(AddonServiceProvider $provider)
    {
        if (!$plugins = $provider->getPlugins()) {
            return;
        }

        $this->events->listen(
            'Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins',
            function (RegisteringTwigPlugins $event) use ($plugins) {
                $twig = $event->getTwig();

                foreach ($plugins as $plugin) {
                    $twig->addExtension(app($plugin));
                }
            }
        );
    }

    /**
     * Register the addon schedules.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerSchedules(AddonServiceProvider $provider)
    {
        if (!$schedules = $provider->getSchedules()) {
            return;
        }

        foreach ($schedules as $frequency => $commands) {
            foreach (array_filter($commands) as $command) {
                if (str_is('* * * *', $frequency)) {
                    $this->schedule->command($command)->cron($frequency);
                } else {

                    $parts = explode('|', $frequency);

                    $method    = array_shift($parts);
                    $arguments = explode(',', array_shift($parts));

                    call_user_func_array([$this->schedule->command($command), $method], $arguments);
                }
            }
        }
    }

    /**
     * Register view overrides.
     *
     * @param AddonServiceProvider $provider
     * @param Addon $addon
     */
    protected function registerOverrides(AddonServiceProvider $provider, Addon $addon)
    {
        $overrides = $provider->getOverrides();
        $mobiles   = $provider->getMobile();

        if (!$overrides && !$mobiles) {
            return;
        }

        $this->viewOverrides->put($addon->getNamespace(), $overrides);
        $this->viewMobileOverrides->put($addon->getNamespace(), $mobiles);
    }

    /**
     * Register middleware.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerMiddleware(AddonServiceProvider $provider)
    {
        foreach ($provider->getMiddleware() as $middleware) {
            $this->middlewares->push($middleware);
        }
    }

    /**
     * Register route middleware.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerRouteMiddleware(AddonServiceProvider $provider)
    {
        foreach ($provider->getRouteMiddleware() as $name => $class) {
            $this->router->middleware($name, $class);
        }
    }

    /**
     * Register additional routes.
     *
     * @param AddonServiceProvider $provider
     */
    protected function registerAdditionalRoutes(AddonServiceProvider $provider)
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
    protected function routesAreCached()
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
