<?php

namespace Anomaly\Streams\Platform\Addon;

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
     * The addon identifier.
     *
     * @var string
     */
    public $addon = null;

    /**
     * Class aliases.
     *
     * @var array
     */
    public $aliases = [];

    /**
     * Class bindings.
     *
     * @var array
     */
    public $bindings = [];

    /**
     * The addon commands.
     *
     * @var array
     */
    public $commands = [];

    /**
     * The addon command schedules.
     *
     * @var array
     */
    public $schedules = [];

    /**
     * The addon view overrides.
     *
     * @var array
     */
    public $overrides = [];

    /**
     * The addon plugins.
     *
     * @var array
     */
    public $plugins = [];

    /**
     * Addon routes.
     *
     * @var array
     */
    public $routes = [];

    /**
     * Addon API routes.
     *
     * @var array
     */
    public $api = [];

    /**
     * Addon middleware.
     *
     * @var array
     */
    public $middleware = [];

    /**
     * Addon group middleware.
     *
     * @var array
     */
    public $groupMiddleware = [];

    /**
     * Addon route middleware.
     *
     * @var array
     */
    public $routeMiddleware = [];

    /**
     * Addon event listeners.
     *
     * @var array
     */
    public $listeners = [];

    /**
     * Addon providers.
     *
     * @var array
     */
    public $providers = [];

    /**
     * Singleton bindings.
     *
     * @var array
     */
    public $singletons = [];

    /**
     * The addon view overrides
     * for mobile agents only.
     *
     * @var array
     */
    public $mobile = [];

    /**
     * Register the addon.
     */
    public function register()
    {
        //
    }

    /**
     * Boot the addon.
     */
    public function boot()
    {

        // Determine the namespace.
        $namespace = $this->addon();

        $this->loadRoutes($namespace);

        if (is_dir($migrations = (__DIR__ . '/../../migrations'))) {
            $this->loadMigrationsFrom($migrations);
        }

        if (is_dir($translations = (__DIR__ . '/../../resources/lang'))) {
            $this->loadTranslationsFrom($translations, $namespace);
        }

        if (is_dir($routes = (__DIR__ . '/../../routes'))) {
            $this->loadRoutesFrom($routes);
        }
    }

    /**
     * Load the routes.
     */
    protected function loadRoutes()
    {

        /**
         * Skip if there is nothing to do.
         */
        if (!$this->routes || $this->app->routesAreCached()) {
            return;
        }

        /**
         * Loop over the routes and normalize
         */
        foreach ($this->routes as $uri => $route) {

            /*
             * If the route definition is an
             * not an array then let's make it one.
             * Array type routes give us more control
             * and allow us to pass information in the
             * request's route action array.
             */
            if (!is_array($route) && str_contains($route, ['::', '.'])) {
                $this->router->view($uri, $route);
            }

            if (!is_array($route)) {
                $route = [
                    'uses' => $route,
                ];
            }

            $verb = array_pull($route, 'verb', 'any');

            $group       = array_pull($route, 'group', []);
            $middleware  = array_pull($route, 'middleware', []);
            $constraints = array_pull($route, 'constraints', []);

            if ($this->addon) {
                array_set($route, 'addon', $this->addon());
            }

            if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                \Route::resource($uri, $route['uses']);
            } else {
                $route = \Router::{$verb}($uri, $route)->where($constraints);

                if ($middleware) {
                    call_user_func_array([$route, 'middleware'], (array) $middleware);
                }

                if ($group) {
                    call_user_func_array([$route, 'group'], (array) $group);
                }
            }
        }
    }

    /**
     * Return the detected addon namespace.
     * 
     * @return string
     */
    protected function addon()
    {
        $class = explode('\\', get_class($this));
        $vendor = snake_case(array_shift($class));
        $addon  = snake_case(array_shift($class));

        preg_match('/_' . implode('$|', [
            'field_type',
            'extension',
            'module',
            'plugin',
            'theme',
        ]) . '$/', $addon, $type);

        $addon = str_replace($type, '', $addon);
        $type = ltrim(array_shift($type), '_');

        return "{$vendor}.{$type}.{$addon}";
    }
}
