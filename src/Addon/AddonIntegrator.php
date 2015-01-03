<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;

/**
 * Class AddonIntegrator
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonIntegrator
{

    protected $asset;

    protected $image;

    public function __construct(Asset $asset, Image $image)
    {
        $this->asset = $asset;
        $this->image = $image;
    }

    /**
     * Register the namespaces and integrations for
     * all registered addons of a given type.
     *
     * @param $type
     */
    public function register($type)
    {
        $type = ucfirst(camel_case(str_replace('-', '_', $type)));

        $loaded = app("Anomaly\\Streams\\Platform\\Addon\\{$type}\\{$type}Collection");

        foreach ($loaded as $addon) {
            $this->addNamespaces($addon);
        }
    }

    /**
     * Add utility namespaces for an addon.
     *
     * @param Addon $addon
     */
    protected function addNamespaces(Addon $addon)
    {
        $abstract = str_replace('streams.', '', $addon->getAbstract());

        app('view')->addNamespace($abstract, $addon->getPath('resources/views'));
        app('config')->addNamespace($abstract, $addon->getPath('resources/config'));
        app('translator')->addNamespace($abstract, $addon->getPath('resources/lang'));

        $this->asset->addNamespace($abstract, $addon->getPath('resources'));
        $this->image->addNamespace($abstract, $addon->getPath('resources'));
    }
}
