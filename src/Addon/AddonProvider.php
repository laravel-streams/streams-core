<?php namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

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
     * The application container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new AddonProvider instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register the service provider for an addon.
     *
     * @param Addon $addon
     */
    public function register(Addon $addon)
    {
        $provider = get_class($addon) . 'ServiceProvider';

        if (class_exists($provider)) {
            $this->container->register(new $provider($this->container));
        }
    }
}
