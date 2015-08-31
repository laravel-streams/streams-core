<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class AddonManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
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
     * The addon binder.
     *
     * @var AddonBinder
     */
    protected $binder;

    /**
     * The modules model.
     *
     * @var ModuleModel
     */
    protected $modules;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * The extensions model.
     *
     * @var ExtensionModel
     */
    protected $extensions;

    /**
     * Create a new AddonManager instance.
     *
     * @param AddonPaths      $paths
     * @param AddonBinder     $binder
     * @param AddonLoader     $loader
     * @param ModuleModel     $modules
     * @param Dispatcher      $dispatcher
     * @param ExtensionModel  $extensions
     * @param AddonCollection $collection
     */
    function __construct(
        AddonPaths $paths,
        AddonBinder $binder,
        AddonLoader $loader,
        ModuleModel $modules,
        Dispatcher $dispatcher,
        ExtensionModel $extensions,
        AddonCollection $addons
    ) {
        $this->paths      = $paths;
        $this->addons     = $addons;
        $this->binder     = $binder;
        $this->loader     = $loader;
        $this->modules    = $modules;
        $this->dispatcher = $dispatcher;
        $this->extensions = $extensions;
    }

    /**
     * Register all addons.
     */
    public function register()
    {
        $enabled   = $this->getEnabledAddonNamespaces();
        $installed = $this->getInstalledAddonNamespaces();

        $paths = $this->paths->all();

        /**
         * First load all the addons
         * so they're available.
         */
        if (env('APP_DEBUG')) {

            foreach ($paths as $path) {
                $this->loader->load($path);
            }

            $this->loader->register();
        }

        /**
         * Then register all of the addons now
         * that they're all PSR autoloaded.
         */
        foreach ($paths as $path) {
            $this->binder->register($path, $enabled, $installed);
        }

        /**
         * Disperse addons to their
         * respective collections.
         */
        $this->addons->disperse();

        $this->dispatcher->fire(new AddonsHaveRegistered($this->addons));
    }

    /**
     * Get namespaces for enabled addons.
     *
     * @return array
     */
    protected function getEnabledAddonNamespaces()
    {
        if (env('INSTALLED')) {
            $modules    = $this->modules->getEnabledNamespaces()->all();
            $extensions = $this->extensions->getEnabledNamespaces()->all();
        } else {
            $modules    = [];
            $extensions = [];
        }

        return array_merge($modules, $extensions);
    }

    /**
     * Get namespaces for installed addons.
     *
     * @return array
     */
    protected function getInstalledAddonNamespaces()
    {
        if (env('INSTALLED')) {
            $modules    = $this->modules->getInstalledNamespaces()->all();
            $extensions = $this->extensions->getInstalledNamespaces()->all();
        } else {
            $modules    = [];
            $extensions = [];
        }

        return array_merge($modules, $extensions);
    }
}