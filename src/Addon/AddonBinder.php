<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonRegisteredEvent;
use Illuminate\Container\Container;

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
     * Create a new AddonBinder instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
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

        $this->bind($addon);

        app('events')->fire("streams::addon.registered", new AddonRegisteredEvent($addon));
        app('events')->fire("streams::{$type}.registered", new AddonRegisteredEvent($addon));
        app('events')->fire("streams::{$type}.{$slug}.registered", new AddonRegisteredEvent($addon));
    }

    /**
     * Bind the addon to the IoC container.
     *
     * @param Addon $addon
     */
    protected function bind(Addon $addon)
    {
        $this->container->instance(get_class($addon), $addon);
    }
}
