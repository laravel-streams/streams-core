<?php namespace Anomaly\Streams\Platform\Addon;

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
     * Return all addon paths in a given folder.
     *
     * @param  $type
     * @return array
     */
    public function all($type)
    {
        $core        = $this->core($type) ? : [];
        $shared      = $this->shared($type) ? : [];
        $application = $this->application($type) ? : [];

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
        $path = base_path('core');

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(app('files')->directories($path), $type);
    }

    /**
     * Return all shared addon paths in a given folder.
     *
     * @param  $type
     * @return bool
     */
    public function shared($type)
    {
        $path = base_path('addons/shared');

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(app('files')->directories($path), $type);
    }

    /**
     * Return all application addon paths in a given folder.
     *
     * @param  $type
     * @return bool
     */
    public function application($type)
    {
        $reference = app('streams.application')->getReference();

        $path = base_path('addons/' . $reference);

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(app('files')->directories($path), $type);
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
            foreach (app('files')->directories($vendor) as $addon) {
                if (ends_with($addon, "-{$type}")) {
                    $paths[] = $addon;
                }
            }
        }

        return $paths;
    }
}
