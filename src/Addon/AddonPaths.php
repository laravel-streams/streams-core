<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;

/**
 * Class AddonPaths
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonPaths
{

    /**
     * The runtime cache.
     *
     * @var null
     */
    protected $cache = null;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AddonPaths instance.
     *
     * @param Application $application
     * @param Repository  $config
     */
    function __construct(Application $application, Repository $config)
    {
        $this->config      = $config;
        $this->application = $application;
    }


    /**
     * Return all addon paths in a given folder.
     *
     * @return array
     */
    public function all()
    {
        if ($this->cache) {
            return $this->cache;
        }

        if (file_exists($addons = base_path('bootstrap/cache/addons.php'))) {
            return include $addons;
        }

        $eager    = $this->eager();
        $deferred = $this->deferred();

        $core        = $this->core() ?: [];
        $shared      = $this->shared() ?: [];
        $application = $this->application() ?: [];

        return array_filter(array_unique(array_merge($eager, $core, $shared, $application, $deferred)));
    }

    /**
     * Return all core addon paths in a given folder.
     *
     * @return bool
     */
    public function core()
    {
        $path = base_path('core');

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return all shared addon paths in a given folder.
     *
     * @return bool
     */
    public function shared()
    {
        $path = base_path('addons/shared');

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return all application addon paths in a given folder.
     *
     * @return bool
     */
    public function application()
    {
        $path = base_path('addons/' . $this->application->getReference());

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return vendor addons of a given type.
     *
     * @param $directories
     * @return array
     */
    protected function vendorAddons($directories)
    {
        $paths = [];

        foreach ($directories as $vendor) {
            foreach (glob("{$vendor}/*", GLOB_ONLYDIR) as $addon) {
                $paths[] = $addon;
            }
        }

        return $paths;
    }

    /**
     * Return paths to eager loaded addons.
     *
     * @return array
     */
    protected function eager()
    {
        return array_map(
            function ($path) {
                return base_path($path);
            },
            $this->config->get('streams::addons.eager', [])
        );
    }

    /**
     * Return paths to deferred addons.
     *
     * @return array
     */
    protected function deferred()
    {
        return array_map(
            function ($path) {
                return base_path($path);
            },
            $this->config->get('streams::addons.deferred', [])
        );
    }
}
