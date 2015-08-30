<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;
use Anomaly\Streams\Platform\View\ViewMobileOverrides;
use Anomaly\Streams\Platform\View\ViewOverrides;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use TwigBridge\Bridge;

/**
 * Class AddonProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
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
     * The Twig instance.
     *
     * @var Bridge
     */
    protected $twig;

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
     * @param Bridge      $twig
     * @param Router      $router
     * @param Dispatcher  $events
     * @param Schedule    $schedule
     * @param Application $application
     */
    public function __construct(
        Bridge $twig,
        Router $router,
        Dispatcher $events,
        Schedule $schedule,
        Application $application,
        ViewOverrides $viewOverrides,
        MiddlewareCollection $middlewares,
        ViewMobileOverrides $viewMobileOverrides
    ) {
        $this->twig                = $twig;
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

        $provider = get_class($addon) . 'ServiceProvider';

        if (!class_exists($provider)) {
            return;
        }

        $provider = new $provider($this->application, $addon);

        $this->bindClasses($provider);
        $this->bindSingletons($provider);

        $this->registerRoutes($provider, $addon);
        $this->registerOverrides($provider, $addon);

        $this->registerEvents($provider);
        $this->registerPlugins($provider);
        $this->registerCommands($provider);
        $this->registerSchedules($provider);
        $this->registerProviders($provider);
        $this->registerMiddleware($provider);
        $this->registerAdditionalRoutes($provider);

        $this->application->register($provider);
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
            $provider->commands($commands);
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
     * @param Addon                $addon
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

            array_set($route, 'streams::addon', $addon->getNamespace());

            if (!str_contains($route['uses'], '@')) {
                $this->router->controller($uri, $route['uses']);
            } else {
                $this->router->{$verb}($uri, $route)->where($constraints);
            }
        }
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

        foreach ($plugins as $plugin) {
            $this->twig->addExtension(app($plugin));
        }
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

        foreach ($schedules as $command => $cron) {
            $this->scheduler->command($command)->cron($cron);
        }
    }

    /**
     * Register view overrides.
     *
     * @param AddonServiceProvider $provider
     * @param Addon                $addon
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
        if (!$middleware = $provider->getMiddleware()) {
            return;
        }

        $this->middlewares->merge($middleware);
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
            $this->application->call([$provider, 'map']);
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
