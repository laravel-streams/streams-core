<?php namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

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
        foreach ($this->getProviders() as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register the addon events.
     */
    protected function registerEvents()
    {
        /* @var Dispatcher $events */
        $events = $this->app->make('events');

        foreach ($this->getListeners() as $event => $listeners) {
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
        /* @var Router $router */
        $router = $this->app->make('router');

        foreach ($this->getRoutes() as $uri => $action) {
            $router->any($uri, $action);
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
}
