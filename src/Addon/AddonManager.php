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
     * The addon paths.
     *
     * @var AddonPaths
     */
    protected $paths;

    /**
     * The addon loader.
     *
     * @var AddonLoader
     */
    protected $loader;

    /**
     * The addon binder.
     *
     * @var AddonBinder
     */
    protected $binder;

    /**
     * Create a new AddonManager instance.
     *
     * @param AddonPaths  $paths
     * @param AddonBinder $binder
     * @param AddonLoader $loader
     */
    function __construct(AddonPaths $paths, AddonBinder $binder, AddonLoader $loader)
    {
        $this->paths  = $paths;
        $this->binder = $binder;
        $this->loader = $loader;
    }

    /**
     * Register all addons of a given type.
     */
    public function register($type)
    {
        $plural = str_plural($type);

        foreach ($this->paths->all($type) as $path) {

            $this->loader->load($path);
            $this->binder->register($path);

            app('events')->fire("streams::{$plural}.registered");
        }
    }
}
