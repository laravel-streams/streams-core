<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Illuminate\Contracts\Container\Container;

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
        if ($addon instanceof Module && !$addon->isEnabled() && $addon->getSlug() !== 'installer') {
            return;
        }

        if ($addon instanceof Extension && !$addon->isEnabled()) {
            return;
        }

        $provider = get_class($addon) . 'ServiceProvider';

        if (class_exists($provider)) {
            $this->container->register(new $provider($this->container, $addon));
        }
    }
}
