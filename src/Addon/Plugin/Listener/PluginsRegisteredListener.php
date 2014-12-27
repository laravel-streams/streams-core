<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Listener;

/**
 * Class PluginsRegisteredListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Plugin\Listener
 */
class PluginsRegisteredListener
{

    /**
     * After all the tags have been registered
     * we need to register them as Twig extensions.
     */
    public function handle()
    {
        foreach (app('streams.plugins') as $plugin) {
            app('twig')->addExtension($plugin);
        }
    }
}
