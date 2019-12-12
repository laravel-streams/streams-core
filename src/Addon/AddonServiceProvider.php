<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Application as Artisan;

/**
 * Class AddonServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonServiceProvider extends ServiceProvider
{
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
     * The addon publishables.
     *
     * @var array
     */
    public static $publishes = [];

    /**
     * Register the addon.
     */
    public function register()
    {
        $addon     = $this->addon();
        $namespace = $this->namespace();

        [$vendor, $type, $slug] = explode('.', $namespace);

        $path = base_path("vendor/{$vendor}/{$slug}-{$type}");

        // if ($type !== 'module' && !$addon->isEnabled() && $addon->getSlug() !== 'installer') {
        //     return;
        // }

        // if ($addon instanceof Extension && !$addon->isEnabled()) {
        //     return;
        // }

        // if ($addon instanceof Theme && !$addon->isActive()) {
        //     return;
        // }

        // $provider = $addon->getServiceProvider();

        // if (!class_exists($provider)) {
        //     return;
        // }

        $this->app->singleton($namespace, function ($app) use ($addon, $type, $slug, $vendor, $path) {

            // @var Addon $addon
            $addon = $app->make($addon)
                ->setType($type)
                ->setSlug($slug)
                ->setVendor($vendor)
                ->setPath($path);

            if ($addon->getType() === 'module' || $addon->getType() === 'extension') {
                $addon->setEnabled(true);
                $addon->setInstalled(true);
            }

            return $addon;
        });

        $this->registerApi($namespace);
        $this->registerRoutes($namespace);

        $this->mergeConfig($path, $slug);

        $this->registerEvents();
        $this->registerMiddleware();
        $this->registerGroupMiddleware();
        $this->registerRouteMiddleware();

        // Lastly
        $this->registerProviders();

        //event(new AddonWasRegistered($namespace));
    }

    /**
     * Boot the addon.
     */
    public function boot()
    {
        // Determine the namespace.
        $namespace = $this->namespace();
        //$addon = $this->addon();

        [$vendor, $type, $slug] = explode('.', $namespace);

        $path = base_path("vendor/{$vendor}/{$slug}-{$type}");

        $this->registerCommands();
        $this->registerPublishables($path, $namespace);
        // $this->registerSchedules($namespace);

        $this->registerHints($namespace, $path);
        $this->registerFactories($namespace, $path);

        if (is_dir($translations = ($path . '/resources/lang'))) {
            $this->loadTranslationsFrom($translations, $namespace);
        }
    }

    /**
     * Undocumented function
     *
     * @param string $namespace
     **/
    protected function registerRoutes(string $namespace)
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
            $middleware  = array_pull($route, 'middleware', ['web']);
            $constraints = array_pull($route, 'constraints', []);

            if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                \Route::middleware('web')->group(function () use ($uri, $route) {
                    \Route::resource($uri, $route['uses']);
                });
            } else {
                \Route::middleware('web')->group(function () use ($uri, $verb, $route, $group, $middleware, $constraints) {

                    $route = \Route::{$verb}($uri, $route)->where($constraints);

                    if ($middleware) {
                        call_user_func_array([$route, 'middleware'], (array) $middleware);
                    }

                    if ($group) {
                        call_user_func_array([$route, 'group'], (array) $group);
                    }
                });
            }
        }
    }

    /**
     * Register the addon routes.
     *
     * @param string $namespace
     */
    protected function registerApi(string $namespace)
    {
        /**
         * Skip if there is nothing to do.
         */
        if (!$this->api || $this->app->routesAreCached()) {
            return;
        }

        /**
         * Loop over the routes and normalize
         */
        $this->router->group(
            [
                'middleware' => 'auth:api',
            ],
            function () use ($namespace) {
                foreach ($this->api as $uri => $route) {

                    /*
                     * If the route definition is an
                     * not an array then let's make it one.
                     * Array type routes give us more control
                     * and allow us to pass information in the
                     * request's route action array.
                     */
                    if (!is_array($route)) {
                        $route = [
                            'uses' => $route,
                        ];
                    }

                    $verb        = array_pull($route, 'verb', 'any');
                    $middleware  = array_pull($route, 'middleware', []);
                    $constraints = array_pull($route, 'constraints', []);

                    array_set($route, 'streams::addon', $namespace);

                    if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                        \Route::resource($uri, $route['uses']);
                    } else {
                        $route = \Route::{$verb}($uri, $route)->where($constraints);

                        if ($middleware) {
                            call_user_func_array([$route, 'middleware'], (array) $middleware);
                        }
                    }
                }
            }
        );
    }

    /**
     * Bind class aliases.
     */
    protected function bindAliases()
    {
        if ($this->aliases) {
            AliasLoader::getInstance($this->aliases)->register();
        }
    }

    /**
     * Merge automatic config.
     *
     * @param string $path
     * @param string $slug
     */
    protected function mergeConfig(string $path, string $slug)
    {
        if (file_exists($config = $path . '/resources/config/addon.php')) {
            $this->mergeConfigFrom($config, $slug);
        }
    }

    /**
     * Register the addon events.
     */
    protected function registerEvents()
    {
        foreach ($this->listeners as $event => $classes) {
            foreach ($classes as $key => $listener) {

                $priority = 0;

                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                }

                \Event::listen($event, $listener, $priority);
            }
        }
    }

    /**
     * Register the addon commands.
     */
    protected function registerCommands()
    {
        if ($this->commands) {

            // To register the commands with Artisan, we will grab each of the arguments
            // passed into the method and listen for Artisan "start" event which will
            // give us the Artisan console instance which we will give commands to.
            Artisan::starting(function ($artisan) {
                $artisan->resolveCommands($this->commands);
            });
        }
    }

    /**
     * Register the publishable material.
     * 
     * @param string $path
     * @param string $namespace
     */
    protected function registerPublishables($path, $namespace)
    {
        if (is_dir($assets = $path . DIRECTORY_SEPARATOR . 'assets')) {
            $this->publishes([
                $assets => public_path(
                    implode(DIRECTORY_SEPARATOR, array_merge(['vendor'], explode('.', $namespace)))
                )
            ], 'assets');
        }
    }

    /**
     * Register middleware.
     */
    protected function registerMiddleware()
    {
        foreach ($this->middleware as $middleware) {
            \Route::pushMiddlewareToGroup('web', $middleware);
        }
    }

    /**
     * Register group middleware.
     */
    protected function registerGroupMiddleware()
    {
        foreach ($this->groupMiddleware as $group => $classes) {
            \Route::pushMiddlewareToGroup($group, $classes);
        }
    }

    /**
     * Register route middleware.
     */
    protected function registerRouteMiddleware()
    {
        foreach ($this->routeMiddleware as $name => $class) {
            \Route::aliasMiddleware($name, $class);
        }
    }

    /**
     * Register the addon hints.
     * 
     * @param string $namespace
     * @param string $path
     */
    protected function registerHints(string $namespace, string $path)
    {
        if (is_dir($views = ($path . '/resources/views'))) {
            $this->loadViewsFrom($views, $namespace);
        }

        if (is_dir($migrations = ($path . '/migrations'))) {
            $this->loadMigrationsFrom($migrations);
        }

        if (is_dir($routes = ($path . '/routes'))) {
            $this->loadRoutesFrom($routes);
        }

        img()->addPath($namespace, $path . '/resources');
        assets()->addPath($namespace, $path . '/resources');
    }

    /**
     * Register the addon commands.
     * 
     * @param string $namespace
     * @param string $path
     */
    protected function registerFactories(string $namespace, string $path)
    {
        // @todo not sure about this - beaks CLI
        // if (
        //     ($this->app->runningUnitTests() || $this->app->runningInConsole())
        //     && is_dir($path)
        // ) {
        //     app(Factory::class)->load($path);
        // }
    }

    /**
     * Register the addon providers.
     */
    public function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Return the detected addon namespace.
     * 
     * @return string
     */
    protected function namespace()
    {
        $class  = explode('\\', get_class($this));
        $vendor = snake_case(array_shift($class));
        $addon  = snake_case(array_shift($class));

        preg_match('/' . implode('$|', [
            'field_type',
            'extension',
            'module',
            'plugin',
            'theme',
        ]) . '$/', $addon, $type);

        $addon = str_replace('_' . $type[0], '', $addon);
        $type = ltrim(array_shift($type), '_');

        return "{$vendor}.{$type}.{$addon}";
    }

    /**
     * Return the detected addon class.
     * 
     * @return string
     */
    protected function addon()
    {
        return str_replace('ServiceProvider', '', get_class($this));
    }
}
