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
     * Register common provisions.
     */
    public function registerProperty()
    {
        $this->fire('registering');

        $this->registerAssetsProperty();
        $this->registerRoutesProperty();
        $this->registerStreamsProperty();
        $this->registerCommandsProperty();
        $this->registerPoliciesProperty();
        $this->registerListenersProperty();
        $this->registerProvidersProperty();
        $this->registerSchedulesProperty();
        $this->registerMiddlewareProperty();

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
    protected function registerAssetsProperty()
    {
        Integrator::assets($this->assets);
    }

    /**
     * Register the addon routes.
     */
    protected function registerRoutesProperty()
    {
        Integrator::routes($this->routes);
    }

    /**
     * Register Streams.
     */
    public function registerStreamsProperty()
    {
        Integrator::streams($this->streams);
    }

    /**
     * Register the Artisan commands.
     */
    protected function registerCommandsProperty()
    {
        if (!$this->commands) {
            return;
        }

        Integrator::commands($this->commands);
    }

    /**
     * Register policies
     */
    protected function registerPoliciesProperty()
    {
        Integrator::policies($this->policies);
    }

    /**
     * Register the event listeners.
     */
    protected function registerListenersProperty()
    {
        Integrator::listeners($this->listeners);
    }

    /**
     * Register the additional providers.
     */
    protected function registerProvidersProperty()
    {
        Integrator::providers($this->providers);
    }

    /**
     * Register the scheduled commands.
     */
    protected function registerSchedulesProperty()
    {
        if (!$this->schedules) {
            return;
        }

        Integrator::schedules($this->schedules);
    }

    /**
     * Register middleware by group.
     */
    protected function registerMiddlewareProperty()
    {
        Integrator::middleware($this->middleware);
    }
}
