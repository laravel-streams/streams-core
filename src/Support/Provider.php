<?php

namespace Streams\Core\Support;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Integrator;
use Streams\Core\Support\Traits\FiresCallbacks;

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
     * The view overrides.
     *
     * @var array
     */
    public $overrides = [];

    /**
     * The view includes.
     *
     * @var array
     */
    public $includes = [];

    /**
     * Register common provisions.
     */
    public function register()
    {
        $this->fire('registering');

        $this->registerStreamsDefinitions();

        Integrator::assets($this->assets);
        Integrator::routes($this->routes);

        $this->registerStreamsAliases();
        $this->registerStreamsCommands();
        $this->registerStreamsPolicies();
        $this->registerStreamsListeners();
        $this->registerStreamsProviders();
        $this->registerStreamsSchedules();
        $this->registerStreamsMiddleware();
        $this->registerStreamsViewIncludes();
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
     * Register Streams.
     */
    public function registerStreamsDefinitions()
    {
        array_walk($this->streams, function (&$stream) {
            if (is_string($stream)) {
                $stream = base_path($stream);
            }
        });

        Integrator::streams($this->streams);
    }

    /**
     * Register Asliases.
     */
    public function registerStreamsAliases()
    {
        if (!$this->aliases) {
            return;
        }

        Integrator::aliases($this->aliases);
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
    public function registerStreamsViewOverrides()
    {
        Integrator::overrides($this->overrides);
    }

    /**
     * Register view includes.
     */
    public function registerStreamsViewIncludes()
    {
        Integrator::includes($this->includes);
    }
}
