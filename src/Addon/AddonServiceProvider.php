<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class AddonServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonServiceProvider extends ServiceProvider
{

    /**
     * The addon routes.
     *
     * @var array
     */
    public $routes = [
        'web' => [],
        'cp' => [],
    ];

    /**
     * The middleware by group.
     *
     * @var array
     */
    public $middleware = [
        'web' => [],
        'cp' => [],
    ];

    /**
     * Artisan commands.
     *
     * @var array
     */
    public $commands = [];

    /**
     * Event listeners.
     *
     * @var array
     */
    public $listeners = [];

    /**
     * Register the addon.
     */
    public function register()
    {
        $this->registerRoutes();
        $this->registerMiddleware();
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
}
