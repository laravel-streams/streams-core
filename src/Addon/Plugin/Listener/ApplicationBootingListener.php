<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Listener;

/**
 * Class ApplicationBootingListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Plugin\Listener
 */
class ApplicationBootingListener
{

    /**
     * When the application starts booting we need
     * to register all plugins as Twig extensions.
     */
    public function handle()
    {
        foreach (app('Anomaly\Streams\Platform\Addon\Plugin\PluginCollection') as $plugin) {
            app('twig')->addExtension($plugin);
        }
    }
}
