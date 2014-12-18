<?php namespace Anomaly\Streams\Platform\Addon;

/**
 * Class AddonManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonManager
{

    /**
     * Register all addons of a given type.
     */
    public function register($type)
    {
        $plural = str_plural($type);

        foreach (app('streams.addon.paths')->all($plural) as $path) {

            $slug = basename($path);

            app('streams.addon.vendor')->load($path);
            app('streams.addon.loader')->load($type, $slug, $path);
            app('streams.addon.binder')->register($type, $slug, $path);

            app('events')->fire("streams::{$plural}.registered");
        }
    }
}
