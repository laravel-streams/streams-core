<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;

/**
 * Class AddonServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonServiceProvider extends ServiceProvider
{
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
        $namespace = $this->packageNamespace();

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
     * Get class aliases.
     *
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
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
        $routes = [];

        foreach (glob($this->addon->getPath('resources/routes/*')) as $include) {
            $include = require $include;

            if (!is_array($include)) {
                continue;
            }

            $routes = array_merge($include, $routes);
        }

        return array_merge($this->routes, $routes);
    }

    /**
     * Get the addon API routes.
     *
     * @return array
     */
    public function getApi()
    {
        return $this->api;
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
     * Get the group middleware.
     *
     * @return array
     */
    public function getGroupMiddleware()
    {
        return $this->groupMiddleware;
    }

    /**
     * Get the route middleware.
     *
     * @return array
     */
    public function getRouteMiddleware()
    {
        return $this->routeMiddleware;
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

    /**
     * Return the generated package namespace.
     */
    protected function packageNamespace()
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
