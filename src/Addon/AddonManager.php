<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonsRegistered;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Illuminate\Events\Dispatcher;

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
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

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
     * @param AddonPaths     $paths
     * @param AddonBinder    $binder
     * @param AddonLoader    $loader
     * @param Dispatcher     $dispatcher
     * @param ModuleModel    $modules
     * @param ExtensionModel $extensions
     */
    function __construct(
        AddonPaths $paths,
        AddonBinder $binder,
        AddonLoader $loader,
        Dispatcher $dispatcher,
        ModuleModel $modules,
        ExtensionModel $extensions
    ) {
        $this->paths      = $paths;
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

        foreach ($this->paths->all() as $path) {
            $this->loader->load($path);
            $this->binder->register($path, $enabled, $installed);
        }

        $this->dispatcher->fire(new AddonsRegistered());
    }

    /**
     * Get namespaces for enabled addons.
     *
     * @return array
     */
    protected function getEnabledAddonNamespaces()
    {
        if (env('INSTALLED')) {
            $modules    = $this->modules->getEnabledNamespaces();
            $extensions = $this->extensions->getEnabledNamespaces();
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
            $modules    = $this->modules->getInstalledNamespaces();
            $extensions = $this->extensions->getInstalledNamespaces();
        } else {
            $modules    = [];
            $extensions = [];
        }

        return array_merge($modules, $extensions);
    }
}
