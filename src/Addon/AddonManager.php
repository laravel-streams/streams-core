<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Command\GetNamespaceWithComposer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;
use Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered;

/**
 * Class AddonManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonManager
{

    /**
     * The addon paths.
     *
     * @var AddonPaths
     */
    protected $paths;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * The addon loader.
     *
     * @var AddonLoader
     */
    protected $loader;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The addon integrator.
     *
     * @var AddonIntegrator
     */
    protected $integrator;

    /**
     * The modules model.
     *
     * @var ModuleModel
     */
    protected $modules;

    /**
     * The extensions model.
     *
     * @var ExtensionModel
     */
    protected $extensions;

    /**
     * Create a new AddonManager instance.
     *
     * @param AddonPaths $paths
     * @param AddonLoader $loader
     * @param ModuleModel $modules
     * @param Container $container
     * @param ExtensionModel $extensions
     * @param AddonIntegrator $integrator
     * @param AddonCollection $addons
     */
    public function __construct(
        AddonPaths      $paths,
        AddonLoader     $loader,
        ModuleModel     $modules,
        Container       $container,
        ExtensionModel  $extensions,
        AddonIntegrator $integrator,
        AddonCollection $addons
    )
    {
        $this->paths = $paths;
        $this->addons = $addons;
        $this->loader = $loader;
        $this->modules = $modules;
        $this->container = $container;
        $this->integrator = $integrator;
        $this->extensions = $extensions;
        $this->loader = $loader;
    }

    /**
     * Register all addons.
     *
     * @param bool $reload
     */
    public function register($reload = false)
    {
        $enabled = $this->getEnabledAddonNamespaces();
        $installed = $this->getInstalledAddonNamespaces();

        $this->container->bind(
            'streams::addons.enabled',
            function () use ($enabled) {
                return $enabled;
            }
        );

        $this->container->bind(
            'streams::addons.installed',
            function () use ($installed) {
                return $installed;
            }
        );

        $paths = $this->paths->all();

        $addonsDirectory = base_path('addons');

        if (config('streams::addons.autoload', true)) {
            array_map(function ($path) {
                $this->loader->load($path);
            }, array_filter($paths, function ($path) use ($addonsDirectory) {
                return Str::startsWith($path, $addonsDirectory);
            }));
        }

        /**
         * If we need to load then
         * loop and load all the addons.
         */
        if ($reload) {
            $this->loader->load($paths);
            $this->loader->register();
            $this->loader->dump();
        }

        /**
         * Autoload testing addons.
         */
        if (env('APP_ENV') === 'testing' && $testing = $this->paths->testing()) {

            foreach ($testing as $path) {
                $this->loader->load($path);
            }

            $this->loader->classLoader()->addPsr4(
                'Anomaly\\StreamsPlatformTests\\',
                base_path('vendor/visiosoft/streams-platform/tests')
            );

            $this->loader->register();
        }

        /*
         * Register all of the addons.
         */
        foreach ($paths as $path) {

            $namespace = $this->getAddonNamespace($path);

            $addon = $this->integrator->register(
                $path,
                $namespace,
                in_array($namespace, $enabled),
                in_array($namespace, $installed)
            );

            /**
             * It's not an addon, k.
             * Debug your addon by noting it not being loaded O_O
             * Exception was forward...
             */
            if (!$addon) {
                continue;
            }

            foreach ($addon->getAddons() as $class) {

                $namespace = $this->getAddonNamespace(
                    $path = dirname(dirname((new \ReflectionClass($class))->getFileName()))
                );

                $this->integrator->register(
                    $path,
                    $namespace,
                    in_array($namespace, $enabled),
                    in_array($namespace, $installed)
                );
            }
        }

        // Sort all addons.
        /**
         * Commented because of the sort problem of modules
         */
        // $this->addons = $this->addons->sort();


        /*
         * Disperse addons to their
         * respective collections and
         * finish the integration service.
         */
        $this->addons->disperse();
        $this->addons->registered();
        $this->integrator->finish();

        event(new AddonsHaveRegistered($this->addons));
    }

    /**
     * Get namespaces for enabled addons.
     *
     * @return array
     */
    protected function getEnabledAddonNamespaces()
    {
        if (!env('INSTALLED') || (Request::segment(1) !== 'admin' && env('INSTALLED') === 'admin')) {
            return [];
        }

        $modules = $this->modules->cache(
            'streams::modules.enabled',
            9999,
            function () {
                return $this->modules->getEnabledNamespaces()->all();
            }
        );

        $extensions = $this->extensions->cache(
            'streams::extensions.enabled',
            9999,
            function () {
                return $this->extensions->getEnabledNamespaces()->all();
            }
        );

        $enabled = array_merge($modules, $extensions);

        /**
         * If we're testing then make the
         * test module enabled as well.
         */
        if (env('APP_ENV') === 'testing') {
            $enabled = array_merge(
                $enabled,
                [
                    'anomaly.module.test',
                ]
            );
        }

        return $enabled;
    }

    /**
     * Get namespaces for installed addons.
     *
     * @return array
     */
    protected function getInstalledAddonNamespaces()
    {
        if (!env('INSTALLED') || (Request::segment(1) !== 'admin' && env('INSTALLED') === 'admin')) {
            return [];
        }

        $modules = $this->modules->cache(
            'streams::modules.installed',
            9999,
            function () {
                return $this->modules->getInstalledNamespaces()->all();
            }
        );

        $extensions = $this->extensions->cache(
            'streams::extensions.installed',
            9999,
            function () {
                return $this->extensions->getInstalledNamespaces()->all();
            }
        );

        $installed = array_merge($modules, $extensions);

        /**
         * If we're testing then make the
         * test module installed as well.
         */
        if (env('APP_ENV') === 'testing') {
            $installed = array_merge(
                $installed,
                [
                    'anomaly.module.test',
                ]
            );
        }

        return $installed;
    }

    /**
     * Get the addon namespace.
     *
     * @param $path
     * @return string
     */
    protected function getAddonNamespace($path)
    {
        $vendor = strtolower(basename(dirname($path)));
        $slug   = strtolower(substr(basename($path), 0, strpos(basename($path), '-')));
        $type   = strtolower(substr(basename($path), strpos(basename($path), '-') + 1));

        $namespace = "{$vendor}.{$type}.{$slug}";

        list($vendor, $type, $slug) = explode('.', $namespace);

        $class = studly_case($vendor) . '\\' . studly_case($slug) . studly_case($type) . '\\' . studly_case(
                $slug
            ) . studly_case($type);

        if (!class_exists($class)) {
            $composer_namespace = dispatch_sync(new GetNamespaceWithComposer($path));

            list($vendor, $type, $slug) = explode('.', $composer_namespace);

            $class = studly_case($vendor) . '\\' . studly_case($slug) . studly_case($type) . '\\' . studly_case(
                    $slug
                ) . studly_case($type);

            if (class_exists($class)) {
                return $composer_namespace;
            }
        }

        return $namespace;
    }
}
