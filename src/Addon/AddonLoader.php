<?php namespace Anomaly\Streams\Platform\Addon;

use Composer\Autoload\ClassLoader;

/**
 * Class AddonLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonLoader extends ClassLoader
{

    /**
     * Load the addon's src folder.
     *
     * @param $type
     * @param $slug
     * @param $path
     */
    public function load($type, $slug, $path)
    {
        $namespace = 'Anomaly\Streams\Addon\\' . studly_case($type) . '\\' . studly_case($slug) . '\\';

        parent::addPsr4($namespace, $path . '/src', false);

        parent::register();
    }
}
