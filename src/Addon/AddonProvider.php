<?php namespace Anomaly\Streams\Platform\Addon;

/**
 * Class AddonProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonProvider
{

    /**
     * Register all addon's of a given type.
     *
     * @param $type
     */
    public function register($type)
    {
        $type = ucfirst(camel_case($type));

        $loaded = app("Anomaly\\Streams\\Platform\\Addon\\{$type}\\{$type}Collection");

        foreach ($loaded as $addon) {

            $provider = get_class($addon) . 'ServiceProvider';

            if (!class_exists($provider)) {
                continue;
            }

            app()->register($provider);
        }
    }
}
