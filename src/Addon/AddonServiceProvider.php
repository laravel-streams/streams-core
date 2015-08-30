<?php namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Foundation\Bus\DispatchesJobs;
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
     * Boot the service provider.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
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
