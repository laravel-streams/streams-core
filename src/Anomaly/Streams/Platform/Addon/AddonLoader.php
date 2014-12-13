<?php namespace Anomaly\Streams\Platform\Addon;

use Composer\Autoload\ClassLoader;

class AddonLoader extends ClassLoader
{
    public function load($type, $slug, $path)
    {
        $namespace = 'Anomaly\Streams\Addon\\' . studly_case($type) . '\\' . studly_case($slug) . '\\';

        parent::addPsr4($namespace, $path . '/src', false);

        parent::register();
    }
}
