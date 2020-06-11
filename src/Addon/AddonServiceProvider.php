<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
     * The addon class.
     *
     * @var string
     */
    protected $addon;

    /**
     * The addon namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Register the addon.
     */
    public function registerAddon()
    {
        $addon     = $this->addon();
        $namespace = $this->namespace();

        [$vendor, $type, $slug] = explode('.', $namespace);

        $path = dirname((new \ReflectionClass(get_called_class()))->getFileName(), 2);

        $this->bindAddon($addon, $namespace, $vendor, $type, $slug, $path);

        $this->mergeConfig($path, $namespace);
        $this->loadTranslations($namespace, $path);

        $this->registerHints($namespace, $path);
        $this->registerPublishables($path, $namespace);

        $this->registerCommon();
    }

    /**
     * Bind the addon instance.
     *
     * @param string $addon
     * @param string $namespace
     * @param string $vendor
     * @param string $type
     * @param string $slug
     * @param string $path
     */
    protected function bindAddon($addon, $namespace, $vendor, $type, $slug, $path)
    {
        $this->app->singleton($namespace, function () use (
            $addon,
            $namespace,
            $vendor,
            $type,
            $slug,
            $path
        ) {

            // @var Addon $addon
            $addon = $this->app->make($addon)
                ->setSlug($slug)
                ->setVendor($vendor)
                ->setAttribute('type', $type)
                ->setAttribute('path', $path);

            if (!config('streams.installed')) {
                return $addon;
            }

            if ($data = $this->app->make('addon.collection')->get($namespace)) {
                $addon->enabled = Arr::get($data, 'enabled');
                $addon->installed = Arr::get($data, 'installed');
            }

            return $addon;
        });
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
    }

    /**
     * Load the addon's lang files.
     *
     * @param string $namespace
     * @param string $path
     */
    protected function loadTranslations($namespace, $path)
    {
        if (is_dir($translations = ($path . '/resources/lang'))) {
            $this->loadTranslationsFrom($translations, $namespace);
        }
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
     * Return the detected addon namespace.
     * 
     * @return string
     */
    protected function namespace()
    {
        if ($this->namespace) {
            return $this->namespace;
        }

        $class  = explode('\\', $this->addon());
        $vendor = Str::snake(array_shift($class));
        $addon  = Str::snake(array_shift($class));

        preg_match('/' . implode('$|', [
            'field_type',
            'extension',
            'module',
            'theme',
        ]) . '$/', $addon, $type);

        $addon = str_replace('_' . $type[0], '', $addon);
        $type = ltrim(array_shift($type), '_');

        return $this->namespace = "{$vendor}.{$type}.{$addon}";
    }

    /**
     * Return the detected addon class.
     * 
     * @return string
     */
    protected function addon()
    {
        if ($this->addon) {
            return $this->addon;
        }

        return $this->addon = str_replace('ServiceProvider', '', get_class($this));
    }
}
