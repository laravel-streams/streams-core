<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Container\Container;
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
     * @param  $type
     * @return array
     */
    public function all($type)
    {
        $core        = $this->core($type) ?: [];
        $shared      = $this->shared($type) ?: [];
        $application = $this->application($type) ?: [];

        return array_filter(array_merge($core, $shared, $application));
    }

    /**
     * Return all core addon paths in a given folder.
     *
     * @param  $type
     * @return bool
     */
    public function core($type)
    {
        $path = $this->container->make('path.base') . '/core';

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons($this->files->directories($path), $type);
    }

    /**
     * Return all shared addon paths in a given folder.
     *
     * @param  $type
     * @return bool
     */
    public function shared($type)
    {
        $path = $this->container->make('path.base') . '/addons/shared';

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons($this->files->directories($path), $type);
    }

    /**
     * Return all application addon paths in a given folder.
     *
     * @param  $type
     * @return bool
     */
    public function application($type)
    {
        $path = $this->container->make('path.base') . '/addons/' . $this->application->getReference();

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons($this->files->directories($path), $type);
    }

    /**
     * Return vendor addons of a given type.
     *
     * @param $directories
     * @param $type
     * @return array
     */
    protected function vendorAddons($directories, $type)
    {
        $paths = [];

        foreach ($directories as $vendor) {
            foreach ($this->files->directories($vendor) as $addon) {
                if (ends_with($addon, "-{$type}")) {
                    $paths[] = $addon;
                }
            }
        }

        return $paths;
    }
}
