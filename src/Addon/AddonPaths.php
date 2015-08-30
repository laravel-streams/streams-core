<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;

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
     * The file system.
     *
     * @var FileSystem
     */
    protected $files;

    /**
     * The application container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AddonPaths instance.
     *
     * @param Filesystem  $files
     * @param Container   $container
     * @param Application $application
     */
    function __construct(Filesystem $files, Container $container, Application $application)
    {
        $this->files       = $files;
        $this->container   = $container;
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
        $path = $this->container->make('path.base') . '/core';

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons($this->files->directories($path));
    }

    /**
     * Return all shared addon paths in a given folder.
     *
     * @return bool
     */
    public function shared()
    {
        $path = $this->container->make('path.base') . '/addons/shared';

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons($this->files->directories($path));
    }

    /**
     * Return all application addon paths in a given folder.
     *
     * @return bool
     */
    public function application()
    {
        $path = $this->container->make('path.base') . '/addons/' . $this->application->getReference();

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons($this->files->directories($path));
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
            foreach ($this->files->directories($vendor) as $addon) {
                $paths[] = $addon;
            }
        }

        return $paths;
    }
}
