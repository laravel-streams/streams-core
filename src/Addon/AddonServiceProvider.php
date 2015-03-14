<?php namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Events\Dispatcher;
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

        $this->registerProviders();
        $this->registerEvents();
        $this->registerRoutes();
        $this->registerPlugins();
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
     * Register the addon providers.
     */
    protected function registerProviders()
    {
        if (!$providers = $this->getProviders()) {
            return;
        }

        foreach ($providers as $provider) {
            $this->app->register($provider);
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
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
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

        /* @var Router $router */
        $router = $this->app->make('router');

        foreach ($routes as $uri => $action) {
            $router->any($uri, $action);
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
     * Get the addon plugins.
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }
}
