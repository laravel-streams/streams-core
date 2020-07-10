<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Support\Facades\Assets;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;

/**
 * Class ServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    use Macroable;
    use HasMemory;

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
    protected function register()
    {
        //$this->fire('registering');

        $this->registerAssets();
        $this->registerRoutes();
        $this->registerStreams();
        $this->registerCommands();
        $this->registerPolicies();
        $this->registerListeners();
        $this->registerProviders();
        $this->registerSchedules();
        $this->registerMiddleware();

        //$this->fire('registered');
    }

    /**
     * Register the named assets.
     */
    protected function registerAssets()
    {
        foreach ($this->assets as $name => $assets) {
            Assets::register($name, $assets);
        }
    }

    /**
     * Register the addon routes.
     */
    protected function registerRoutes()
    {
        foreach ($this->routes as $group => $routes) {
            Route::middleware($group)->group(function () use ($routes) {
                foreach ($routes as $uri => $route) {

                    /*
                     * Normalize the route
                     * into an array as needed.
                     */
                    if (is_string($route)) {
                        $route = [
                            'uses' => $route,
                        ];
                    }

                    /**
                     * Pull out post-route configuration. 
                     */
                    $verb        = Arr::pull($route, 'verb', 'any');
                    $middleware  = Arr::pull($route, 'middleware', []);
                    $constraints = Arr::pull($route, 'constraints', []);

                    /**
                     * If the route contains a
                     * controller@action then 
                     * create a normal route.
                     * -----------------------
                     * If the route does NOT
                     * contain an action then
                     * treat it as a resource.
                     */
                    if (str_contains($route['uses'], '@')) {
                        $route = Route::{$verb}($uri, $route);
                    } else {
                        $route = Route::resource($uri, $route['uses']);
                    }

                    /**
                     * Call constraints if
                     * any are provided.
                     */
                    if ($constraints) {
                        call_user_func_array([$route, 'constraints'], (array) $constraints);
                    }

                    /**
                     * Call middleware if
                     * any are provided.
                     */
                    if ($middleware) {
                        call_user_func_array([$route, 'middleware'], (array) $middleware);
                    }
                }
            });
        }
    }

    /**
     * Register Streams.
     */
    public function registerStreams()
    {
        foreach ($this->streams as $handle => $stream) {

            Arr::set($stream, 'handle', Arr::get($stream, 'handle', $handle));

            Streams::register($stream);
        }
    }

    /**
     * Register the Artisan commands.
     */
    protected function registerCommands()
    {
        if (!$this->commands) {
            return;
        }

        Application::starting(function ($artisan) {
            $artisan->resolveCommands($this->commands);
        });
    }

    /**
     * Register policies
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * Register the event listeners.
     */
    protected function registerListeners()
    {
        foreach ($this->listeners as $event => $classes) {

            foreach ($classes as $key => $listener) {

                $priority = 0;

                /**
                 * If the listener is an integer
                 * then the key is the listener
                 * and listener is priority.
                 */
                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                }

                Event::listen($event, $listener, $priority);
            }
        }
    }

    /**
     * Register the additional providers.
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            App::register($provider);
        }
    }

    /**
     * Register the scheduled commands.
     */
    protected function registerSchedules()
    {
        if (!$this->schedules) {
            return;
        }

        $schedule = App::make(Schedule::class);

        foreach ($this->schedules as $frequency => $commands) {

            foreach (array_filter($commands) as $command => $options) {

                /**
                 * If the option is a string
                 * then treat it as the command.
                 */
                if (is_string($options)) {
                    $command = $options;
                    $options = [];
                }

                /**
                 * If the frequency is a CRON
                 * expression then use that.
                 */
                if (Str::is('* * * *', $frequency)) {
                    $command = $schedule
                        ->command($command)
                        ->cron($frequency);
                }

                /**
                 * If the frequency is not a CRON
                 * expression then it's a method.
                 */
                if (!Str::is('* * * *', $frequency)) {

                    // Unpack {method}:{arg1},{arg2},...
                    $parts = explode(':', $frequency);

                    // First part is the method.
                    $method = Str::camel(array_shift($parts));

                    // The rest are arguments.
                    $arguments = explode(',', array_shift($parts));

                    // Use the method to create the command.
                    $command = call_user_func_array([
                        $schedule->command($command), $method
                    ], $arguments);
                }

                /**
                 * Loop over any options and chain them
                 * onto the command we just built.
                 * 
                 * Option keys are snake-cased to form
                 * the methods used to configure the command.
                 */
                foreach ($options as $option => $arguments) {

                    /**
                     * If the arguments are a string
                     * then treat them like the method
                     * and just run it with no arguments.
                     */
                    if (is_string($arguments)) {
                        $option    = $arguments;
                        $arguments = [];
                    }

                    $command = call_user_func_array([
                        $command, Str::camel($option)
                    ], (array) $arguments);
                }
            }
        }
    }

    /**
     * Register middleware by group.
     */
    protected function registerMiddleware()
    {
        foreach ($this->middleware as $group => $middlewares) {
            foreach ($middlewares as $middleware) {
                Route::pushMiddlewareToGroup($group, $middleware);
            }
        }
    }
}
