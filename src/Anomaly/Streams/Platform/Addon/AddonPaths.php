<?php namespace Anomaly\Streams\Platform\Addon;

/**
 * Class AddonPaths
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonPaths
{

    /**
     * Return all addon paths in a given folder.
     *
     * @param $folder
     * @return array
     */
    public function all($folder)
    {
        $core        = $this->core($folder) ? : [];
        $shared      = $this->shared($folder) ? : [];
        $application = $this->application($folder) ? : [];

        return array_filter(array_merge($core, $shared, $application));
    }

    /**
     * Return all core addon paths in a given folder.
     *
     * @param $folder
     * @return bool
     */
    public function core($folder)
    {
        $path = base_path('core/' . $folder);

        if (!is_dir($path)) {

            return false;
        }

        return app('files')->directories($path);
    }

    /**
     * Return all shared addon paths in a given folder.
     *
     * @param $folder
     * @return bool
     */
    public function shared($folder)
    {
        $path = base_path('addons/shared/' . $folder);

        if (!is_dir($path)) {

            return false;
        }

        return app('files')->directories($path);
    }

    /**
     * Return all application addon paths in a given folder.
     *
     * @param $folder
     * @return bool
     */
    public function application($folder)
    {
        $reference = app('streams.application')->getReference();

        $path = base_path('addons/' . $reference . '/' . $folder);

        if (!is_dir($path)) {

            return false;
        }

        return app('files')->directories($path);
    }
}
