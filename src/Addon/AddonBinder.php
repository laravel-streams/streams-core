<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

/**
 * Class AddonBinder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonBinder
{

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new AddonBinder instance.
     *
     * @param Container  $container
     * @param Dispatcher $dispatcher
     */
    public function __construct(Container $container, Dispatcher $dispatcher)
    {
        $this->container  = $container;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Register an addon.
     *
     * @param $path
     */
    public function register($path)
    {
        $vendor = basename(dirname($path));
        $slug   = substr(basename($path), 0, strpos(basename($path), '-'));
        $type   = substr(basename($path), strpos(basename($path), '-') + 1);

        $addon = studly_case($vendor) . '\\' . studly_case($slug) . studly_case($type) . '\\' . studly_case(
                $slug
            ) . studly_case($type);

        $addon = app($addon)
            ->setPath($path)
            ->setType($type)
            ->setSlug($slug)
            ->setVendor($vendor);

        $this->container->instance(get_class($addon), $addon);

        $this->dispatcher->fire(new AddonWasRegistered($addon));
    }
}
