<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use TwigBridge\Bridge;

/**
 * Class AddonServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonServiceProvider extends ServiceProvider
{

    use DispatchesJobs;

    /**
     * Class bindings.
     *
     * @var array
     */
    protected $bindings = [];

    /**
     * The addon commands.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * The addon command schedules.
     *
     * @var array
     */
    protected $schedules = [];

    /**
     * The addon view overrides.
     *
     * @var array
     */
    protected $overrides = [];

    /**
     * The addon plugins.
     *
     * @var array
     */
    protected $plugins = [];

    /**
     * Addon routes.
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Addon middleware.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Addon event listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Addon providers.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * Singleton bindings.
     *
     * @var array
     */
    protected $singletons = [];

    /**
     * The addon view overrides
     * for mobile agents only.
     *
     * @var array
     */
    protected $mobile = [];

    /**
     * Cached services.
     *
     * @var array
     */
    protected $cached = [];

    /**
     * The twig instance.
     *
     * @var Bridge
     */
    protected $twig;

    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The router utility.
     *
     * @var Router
     */
    protected $router;

    /**
     * The command scheduler.
     *
     * @var Schedule
     */
    protected $scheduler;

    /**
     * The middleware collection.
     *
     * @var MiddlewareCollection
     */
    protected $middlewares;

    /**
     * Create a new AddonServiceProvider instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param Addon                                        $addon
     */
    public function __construct($app, Addon $addon)
    {
        $this->addon = $addon;

        $this->twig            = $app->make('twig');
        $this->router          = $app->make('router');
        $this->events          = $app->make('events');
        $this->scheduler       = $app->make('Illuminate\Console\Scheduling\Schedule');
        $this->viewOverrides   = $app->make('Anomaly\Streams\Platform\View\ViewOverrides');
        $this->mobileOverrides = $app->make('Anomaly\Streams\Platform\View\ViewMobileOverrides');
        $this->middlewares     = $app->make('Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection');

        parent::__construct($app);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->registerSchedules();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->bindClasses();
        $this->bindSingletons();

        $this->registerRoutes();
        $this->registerEvents();
        $this->registerPlugins();
        $this->registerCommands();
        $this->registerProviders();
        $this->registerOverrides();
        $this->registerMiddleware();
        $this->registerAdditionalRoutes();
    }

    /**
     * Register the addon providers.
     */
    protected function registerProviders()
    {
        foreach ($this->getProviders() as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register the addon commands.
     */
    protected function registerCommands()
    {
        foreach ($this->getCommands() as $command) {
            $this->commands($command);
        }
    }

    /**
     * Bind addon classes.
     */
    protected function bindClasses()
    {
        foreach ($this->getBindings() as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bind addon singletons.
     */
    protected function bindSingletons()
    {
        foreach ($this->getSingletons() as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    /**
     * Register the addon events.
     */
    protected function registerEvents()
    {
        if (!$listen = $this->getListeners()) {
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
     */
    protected function registerRoutes()
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (!$routes = $this->getRoutes()) {
            return;
        }

        foreach ($routes as $uri => $route) {

            /**
             * If the route definition is an
             * not an array then let's make it one.
             * Array type routes give us more control
             * and allow us to pass information in the
             * request's route action array.
             */
            if (!is_array($route)) {
                $route = [
                    'uses' => $route
                ];
            }

            $verb        = array_pull($route, 'verb', 'any');
            $constraints = array_pull($route, 'constraints', []);

            array_set($route, 'streams::addon', $this->addon->getNamespace());

            if (!str_contains($route['uses'], '@')) {
                $this->router->controller($uri, $route['uses']);
            } else {
                $this->router->{$verb}($uri, $route)->where($constraints);
            }
        }
    }

    /**
     * Register the addon plugins.
     */
    protected function registerPlugins()
    {
        if (!$plugins = $this->getPlugins()) {
            return;
        }

        foreach ($plugins as $plugin) {
            $this->twig->addExtension($this->app->make($plugin));
        }
    }

    /**
     * Register the addon schedules.
     */
    protected function registerSchedules()
    {
        if (!$schedules = $this->getSchedules()) {
            return;
        }

        foreach ($schedules as $command => $cron) {
            $this->scheduler->command($command)->cron($cron);
        }
    }

    /**
     * Register view overrides.
     */
    protected function registerOverrides()
    {
        $overrides = $this->getOverrides();
        $mobiles   = $this->getMobile();

        if (!$overrides && !$mobiles) {
            return;
        }

        $this->viewOverrides->put($this->addon->getNamespace(), $overrides);
        $this->mobileOverrides->put($this->addon->getNamespace(), $mobiles);
    }

    /**
     * Register middleware.
     */
    protected function registerMiddleware()
    {
        if (!$middleware = $this->getMiddleware()) {
            return;
        }

        foreach ($middleware as $class) {
            $this->middlewares->push($class);
        }
    }

    /**
     * Register additional routes.
     */
    protected function registerAdditionalRoutes()
    {
        if ($this->routesAreCached()) {
            return;
        }

        if (method_exists($this, 'map')) {
            $this->app->call([$this, 'map']);
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

    /**
     * Get class bindings.
     *
     * @return array
     */
    public function getBindings()
    {
        return $this->bindings;
    }

    /**
     * Get the singleton bindings.
     *
     * @return array
     */
    public function getSingletons()
    {
        return $this->singletons;
    }

    /**
     * Get the providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Get the addon commands.
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Get the addon command schedules.
     *
     * @return array
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * Get the addon view overrides.
     *
     * @return array
     */
    public function getOverrides()
    {
        return $this->overrides;
    }

    /**
     * Get the mobile view overrides.
     *
     * @return array
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Ge the event listeners.
     *
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * Get the addon routes.
     *
     * @return array
     */
    public function getRoutes()
    {
        $routes = $this->routes;

        foreach (glob($this->addon->getPath('resources/routes/*')) as $include) {
            $routes = array_merge(require $include, $routes);
        }

        return $routes;
    }

    /**
     * Get the middleware.
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * Get the addon plugins.
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }
}
