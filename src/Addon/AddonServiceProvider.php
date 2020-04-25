<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Console\Application as Artisan;
use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Asset\AssetRegistry;
use Anomaly\Streams\Platform\Stream\StreamRegistry;
use Anomaly\Streams\Platform\Addon\Workflow\BindAddon;
use Anomaly\Streams\Platform\Provider\ServiceProvider;

/**
 * Class AddonServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonServiceProvider extends ServiceProvider
{

    /**
     * Register the addon.
     */
    public function registerAddon()
    {
        $addon     = $this->addon();
        $namespace = $this->namespace();

        [$vendor, $type, $slug] = explode('.', $namespace);

        $path = dirname((new \ReflectionClass(get_called_class()))->getFileName(), 2);

        $payload = compact(
            'addon',
            'namespace',
            'vendor',
            'type',
            'slug',
            'path'
        ) + ['app' => $this->app];

        (new Workflow([
            BindAddon::class,
            // @todo this works - move the rest in?
        ]))->process($payload);

        $this->mergeConfig($path, $namespace);

        $this->registerPublishables($path, $namespace);
        //$this->registerSchedules($namespace);

        $this->registerHints($namespace, $path);
        $this->registerFactories($namespace, $path);

        if (is_dir($translations = ($path . '/resources/lang'))) {
            $this->loadTranslationsFrom($translations, $namespace);
        }

        $this->registerCommon();
    }

    /**
     * Merge automatic config.
     *
     * @param string $path
     * @param string $namespace
     */
    protected function mergeConfig(string $path, string $namespace)
    {
        [$vendor, $type, $slug] = explode('.', $namespace);

        if (file_exists($config = $path . '/resources/config/addon.php')) {
            $this->mergeConfigFrom($config, $slug);
        }

        // $override = implode(DIRECTORY_SEPARATOR, array_merge(['vendor', $vendor, $type, $slug], ['addon.php']));

        // if (file_exists($override = config_path($override))) {
        //     $this->mergeConfigFrom($override, $slug);
        // }
    }

    /**
     * Register the publishable material.
     * 
     * @param string $path
     * @param string $namespace
     */
    protected function registerPublishables(string $path, string $namespace)
    {
        [$vendor, $type, $slug] = explode('.', $namespace);

        /**
         * If an assets directory exists
         * within the addon directory
         * then push automatically.
         */
        if (is_dir($assets = $path . DIRECTORY_SEPARATOR . 'assets')) {
            $this->publishes([
                $assets => public_path(
                    implode(DIRECTORY_SEPARATOR, array_merge(['vendor'], explode('.', $namespace)))
                )
            ], ['assets', 'public']);
        }

        /**
         * If a dist directory exists
         * within the addon resources
         * then push automatically.
         */
        if (is_dir($dist = implode(DIRECTORY_SEPARATOR, [$path, 'resources', 'dist']))) {
            $this->publishes([
                $dist => public_path(
                    implode(DIRECTORY_SEPARATOR, array_merge(['vendor'], explode('.', $namespace)))
                )
            ], ['assets', 'public']);
        }

        /**
         * Automatically publish
         * addon.php configuration.
         */
        if (file_exists($config = implode(DIRECTORY_SEPARATOR, [$path, 'resources', 'config', 'addon.php']))) {
            $this->publishes([
                $config => config_path(
                    implode(DIRECTORY_SEPARATOR, array_merge(['vendor'], explode('.', $namespace), ['addon.php']))
                )
            ], 'config');
        }
    }

    /**
     * Register paths to be published by the publish command.
     *
     * @param  array  $paths
     * @param  mixed  $groups
     * @return void
     */
    protected function publishes(array $paths, $groups = null)
    {
        $this->ensurePublishArrayInitialized($class = static::class);

        static::$publishes[$class] = array_merge(static::$publishes[$class], $paths);

        foreach ((array) $groups as $group) {
            $this->addPublishGroup($group, $paths);
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
