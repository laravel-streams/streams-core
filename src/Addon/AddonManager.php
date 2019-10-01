<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Contracts\Events\Dispatcher;
use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;
use Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;

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
     * @var AddonProvider
     */
    private $provider;

    /**
     * Create a new AddonManager instance.
     *
     * @param AddonPaths $paths
     * @param AddonLoader $loader
     * @param ModuleModel $modules
     * @param AddonProvider $provider
     * @param AddonCollection $addons
     * @param ExtensionModel $extensions
     * @param AddonIntegrator $integrator
     */
    public function __construct(
        AddonPaths $paths,
        AddonLoader $loader,
        ModuleModel $modules,
        AddonProvider $provider,
        AddonCollection $addons,
        ExtensionModel $extensions,
        AddonIntegrator $integrator
    ) {
        $this->paths      = $paths;
        $this->loader     = $loader;
        $this->addons     = $addons;
        $this->modules    = $modules;
        $this->provider   = $provider;
        $this->extensions = $extensions;
        $this->integrator = $integrator;
    }

    /**
     * Register all addons.
     *
     * @param bool $reload
     */
    public function register($reload = false)
    {
        if (PHP_SAPI != 'cli' && file_exists($manifest = base_path('bootstrap/cache/addons.php'))) {

            $config = [];

            $manifest = include $manifest;

            foreach (array_get($manifest, 'config', []) as $key => $value) {
                array_set($config, $key, $value);
            }

            config($config);

            $this->provider->bindAliases(array_get($manifest, 'aliases', []));
            $this->provider->bindClasses(array_get($manifest, 'bindings', []));
            $this->provider->registerMobile(array_get($manifest, 'overrides', []));
            $this->provider->bindSingletons(array_get($manifest, 'singletons', []));
            $this->provider->registerOverrides(array_get($manifest, 'overrides', []));

            $this->provider->registerApi(array_get($manifest, 'api', []));
            $this->provider->registerRoutes(array_get($manifest, 'routes', []));

            $this->provider->registerPlugins(array_get($manifest, 'plugins', []));
            $this->provider->registerEvents(array_get($manifest, 'listeners', []));
            $this->provider->registerCommands(array_get($manifest, 'commands', []));
            $this->provider->registerSchedules(array_get($manifest, 'schedules', []));
            $this->provider->registerMiddleware(array_get($manifest, 'middleware', []));
            $this->provider->registerGroupMiddleware(array_get($manifest, 'group_middleware', []));
            $this->provider->registerRouteMiddleware(array_get($manifest, 'route_middleware', []));

            // Call other providers last.
            $this->provider->registerProviders(array_get($manifest, 'providers', []));

            foreach (array_get($manifest, 'loaded', []) as $namespace => $addon) {

                /* @var Addon $instance */
                $instance = app($addon['definition']);

                $this->addons->put($namespace, $instance = (new Hydrator)->hydrate($instance, $addon));

                app()->alias($namespace, $addon['definition']);
                app()->instance($addon['definition'], $instance);

                // Add the view / translation namespaces.
                view()->addNamespace(
                    $instance->getNamespace(),
                    [
                        application()->getResourcesPath(
                            "addons/{$instance->getVendor()}/{$instance->getSlug()}-{$instance->getType()}/views/"
                        ),
                        base_path("resources/instances/{$instance->getVendor()}/{$instance->getSlug()}-{$instance->getType()}/views/"),
                        $instance->getPath('resources/views'),
                    ]
                );
                trans()->addNamespace($instance->getNamespace(), $instance->getPath('resources/lang'));

                if ($instance->getType() === 'plugin') {
                    app(Dispatcher::class)->listen(
                        'Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins',
                        function (RegisteringTwigPlugins $event) use ($instance) {
                            $twig = $event->getTwig();

                            if ($twig->hasExtension(get_class($instance))) {
                                return;
                            }

                            $twig->addExtension($instance);
                        }
                    );
                }
            }

            foreach (array_get($manifest, 'registered', []) as $namespace => $provider) {
                //app()->call([app($provider, ['addon' => $this->addons->get($namespace)]), 'register']);
            }

            foreach (array_get($manifest, 'booted', []) as $namespace => $provider) {
                //app()->call([app($provider, ['addon' => $this->addons->get($namespace)]), 'boot']);
            }

            foreach (array_get($manifest, 'mapped', []) as $namespace => $provider) {
                //app()->call([app($provider, ['addon' => $this->addons->get($namespace)]), 'map']);
            }

            /*
             * Disperse addons to their
             * respective collections and
             * finish the integration service.
             */
            $this->addons->disperse();
            $this->addons->registered();
            $this->integrator->finish();

            event(new AddonsHaveRegistered($this->addons));

            return;
        }

        $enabled   = $this->getEnabledAddonNamespaces();
        $installed = $this->getInstalledAddonNamespaces();

        app()->bind(
            'streams::addons.enabled',
            function () use ($enabled) {
                return $enabled;
            }
        );

        app()->bind(
            'streams::addons.installed',
            function () use ($installed) {
                return $installed;
            }
        );

        $paths = $this->paths->all();

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
                base_path('vendor/anomaly/streams-platform/tests')
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

            if (!$addon) {
                throw new \Exception("Addon path not found [{$path}]. Check [resources/streams/config/addons.php]");
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
        $this->addons = $this->addons->sort();

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
        if (!env('INSTALLED')) {
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
        if (!env('INSTALLED')) {
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

        return "{$vendor}.{$type}.{$slug}";
    }
}
