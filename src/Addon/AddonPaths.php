<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Application\Application;

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
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AddonPaths instance.
     *
     * @param Application $application
     */
    function __construct(Application $application)
    {
        $this->application = $application;
    }


    /**
     * Return all addon paths in a given folder.
     *
     * @return array
     */
    public function all()
    {
        if (file_exists($addons = base_path('bootstrap/cache/addons.php'))) {
            return include $addons;
        }

        $core        = $this->core() ?: [];
        $shared      = $this->shared() ?: [];
        $application = $this->application() ?: [];

        return array_filter(array_merge($core, $shared, $application));
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
}
