<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonTypeWasRegistered;
use Illuminate\Events\Dispatcher;

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
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new AddonManager instance.
     *
     * @param AddonPaths  $paths
     * @param AddonBinder $binder
     * @param AddonLoader $loader
     * @param Dispatcher  $dispatcher
     */
    function __construct(AddonPaths $paths, AddonBinder $binder, AddonLoader $loader, Dispatcher $dispatcher)
    {
        $this->paths      = $paths;
        $this->binder     = $binder;
        $this->loader     = $loader;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Register all addons of a given type.
     *
     * @param $type
     */
    public function register($type)
    {
        foreach ($this->paths->all($type) as $path) {

            $this->loader->load($path);
            $this->binder->register($path);
        }
    }
}
