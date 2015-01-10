<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\View\Factory;

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

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * Create a new AddonIntegrator instance.
     *
     * @param Asset   $asset
     * @param Image   $image
     * @param Factory $views
     */
    public function __construct(Asset $asset, Image $image)
    {
        $this->asset = $asset;
        $this->image = $image;
    }

    /**
     * Register integrations for an addon.
     *
     * @param Addon $addon
     */
    public function register(Addon $addon)
    {
        app('view')->addNamespace($addon->getKey(), $addon->getPath('resources/views'));

        foreach (app('files')->files($addon->getPath('resources/config')) as $config) {
            app('config')->set($addon->getKey(basename(trim($config, '.php'))), app('files')->getRequire($config));
        }

        app('translator')->addNamespace($addon->getKey(), $addon->getPath('resources/lang'));

        $this->asset->addNamespace($addon->getKey(), $addon->getPath('resources'));
        $this->image->addNamespace($addon->getKey(), $addon->getPath('resources'));
    }
}
