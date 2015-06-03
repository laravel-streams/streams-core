<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\View\ViewMobileOverrides;
use Anomaly\Streams\Platform\View\ViewOverrides;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesCommands;
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

    use DispatchesCommands;

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
     * Addon route constraints.
     *
     * @var array
     */
    protected $constraints = [];

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
     * The addon view overrides
     * for mobile agents only.
     *
     * @var array
     */
    protected $mobile = [];

    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * Create a new AddonServiceProvider instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param Addon                                        $addon
     */
    public function __construct($app, Addon $addon)
    {
        $this->addon = $addon;

        parent::__construct($app);
    }

    /**
     * Register the service provider.
     *
     * @return void
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
        $this->registerSchedules();
        $this->registerOverrides();
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

        /* @var Dispatcher $events */
        $events = $this->app->make('events');

        foreach ($listen as $event => $listeners) {
            foreach ($listeners as $key => $listener) {

                if (is_integer($listener)) {
                    $listener = $key;
                    $priority = $listener;
                } else {
                    $priority = 0;
                }

                $events->listen($event, $listener, $priority);
            }
        }
    }

    /**
     * Register the addon routes.
     */
    protected function registerRoutes()
    {
        if (!$routes = $this->getRoutes()) {
            return;
        }

        $constraints = $this->getConstraints();

        /* @var Router $router */
        $router = $this->app->make('router');

        foreach ($routes as $uri => $action) {

            $route = $router->any($uri, $action);

            if ($patterns = array_get($constraints, $uri)) {
                $route->where($patterns);
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

        /* @var Bridge $twig */
        $twig = $this->app->make('twig');

        foreach ($plugins as $plugin) {
            $twig->addExtension($this->app->make($plugin));
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

        /* @var Schedule $scheduler */
        $scheduler = $this->app->make('Illuminate\Console\Scheduling\Schedule');

        foreach ($schedules as $command => $cron) {
            $scheduler->command($command)->cron($cron);
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

        /* @var ViewOverrides $viewOverrides */
        /* @var ViewMobileOverrides $mobileOverrides */
        $viewOverrides   = $this->app->make('Anomaly\Streams\Platform\View\ViewOverrides');
        $mobileOverrides = $this->app->make('Anomaly\Streams\Platform\View\ViewMobileOverrides');

        $viewOverrides->put($this->addon->getNamespace(), $overrides);
        $mobileOverrides->put($this->addon->getNamespace(), $mobiles);
    }

    /**
     * Register additional routes.
     */
    protected function registerAdditionalRoutes()
    {
        if (method_exists($this, 'map')) {
            $this->app->call([$this, 'map']);
        }
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
        return $this->routes;
    }

    /**
     * Get the addon route constraints.
     *
     * @return array
     */
    public function getConstraints()
    {
        return $this->constraints;
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
