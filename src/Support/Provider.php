<?php

namespace Streams\Core\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Integrator;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * Class ServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Provider extends ServiceProvider
{

    use Macroable;
    use FiresCallbacks;

    /**
     * The named assets.
     *
     * @var array
     */
    public $assets = [];

    /**
     * The provider routes.
     *
     * @var array
     */
    public $routes = [];

    /**
     * Artisan commands.
     *
     * @var array
     */
    public $commands = [];

    /**
     * The gate policies.
     *
     * @var array
     */
    public $policies = [];

    /**
     * Event listeners.
     *
     * @var array
     */
    public $listeners = [];

    /**
     * Extra providers to register.
     *
     * @var array
     */
    public $providers = [];

    /**
     * The scheduled commands.
     *
     * @var array
     */
    public $schedules = [];

    /**
     * The middleware by group.
     *
     * @var array
     */
    public $middleware = [];

    /**
     * Register common provisions.
     */
    public function register()
    {
        $this->fire('registering');

        $this->registerAssets();
        $this->registerRoutes();
        $this->registerStreams();
        $this->registerCommands();
        $this->registerPolicies();
        $this->registerListeners();
        $this->registerProviders();
        $this->registerSchedules();
        $this->registerMiddleware();

        $this->fire('registered');
    }

    /**
     * Boot the provider.
     */
    public function boot()
    {
        $this->fire('booting');

        // Do something.

        $this->fire('booted');
    }

    /**
     * Register the named assets.
     */
    protected function registerAssets()
    {
        Integrator::assets($this->assets);
    }

    /**
     * Register the addon routes.
     */
    protected function registerRoutes()
    {
        Integrator::routes($this->routes);
    }

    /**
     * Register Streams.
     */
    public function registerStreams()
    {
        Integrator::streams($this->streams);
    }

    /**
     * Register the Artisan commands.
     */
    protected function registerCommands()
    {
        if (!$this->commands) {
            return;
        }

        Integrator::commands($this->commands);
    }

    /**
     * Register policies
     */
    protected function registerPolicies()
    {
        Integrator::policies($this->policies);
    }

    /**
     * Register the event listeners.
     */
    protected function registerListeners()
    {
        Integrator::listeners($this->listeners);
    }

    /**
     * Register the additional providers.
     */
    protected function registerProviders()
    {
        Integrator::providers($this->providers);
    }

    /**
     * Register the scheduled commands.
     */
    protected function registerSchedules()
    {
        if (!$this->schedules) {
            return;
        }

        Integrator::schedules($this->schedules);
    }

    /**
     * Register middleware by group.
     */
    protected function registerMiddleware()
    {
        Integrator::middleware($this->middleware);
    }
}
