<?php

namespace Streams\Core\Support;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Integrator;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\View\ViewOverrides;

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
     * The stream defintions.
     *
     * @var array
     */
    public $streams = [];

    /**
     * The container bindings.
     *
     * @var array
     */
    public $bindings = [];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [];

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

        $this->registerStreamsDefinitions();

        $this->registerStreamsAssets();
        $this->registerStreamsRoutes();
        $this->registerStreamsCommands();
        $this->registerStreamsPolicies();
        $this->registerStreamsListeners();
        $this->registerStreamsProviders();
        $this->registerStreamsSchedules();
        $this->registerStreamsMiddleware();
        $this->registerStreamsViewOverrides();

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
    public function registerStreamsAssets()
    {
        Integrator::assets($this->assets);
    }

    /**
     * Register the addon routes.
     */
    public function registerStreamsRoutes()
    {
        Integrator::routes($this->routes);
    }

    /**
     * Register Streams.
     */
    public function registerStreamsDefinitions()
    {
        Integrator::streams($this->streams);
    }

    /**
     * Register the Artisan commands.
     */
    public function registerStreamsCommands()
    {
        if (!$this->commands) {
            return;
        }

        Integrator::commands($this->commands);
    }

    /**
     * Register policies
     */
    public function registerStreamsPolicies()
    {
        Integrator::policies($this->policies);
    }

    /**
     * Register the event listeners.
     */
    public function registerStreamsListeners()
    {
        Integrator::listeners($this->listeners);
    }

    /**
     * Register the additional providers.
     */
    public function registerStreamsProviders()
    {
        Integrator::providers($this->providers);
    }

    /**
     * Register the scheduled commands.
     */
    public function registerStreamsSchedules()
    {
        if (!$this->schedules) {
            return;
        }

        Integrator::schedules($this->schedules);
    }

    /**
     * Register middleware by group.
     */
    public function registerStreamsMiddleware()
    {
        Integrator::middleware($this->middleware);
    }

    /**
     * Register view overrides.
     */
    public function registerStreamsViewOverrides($viewOverrides)
    {
        foreach ($viewOverrides as $view => $override) {
            View::override($view, $override);
        }
    }
}
