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
     * @param Asset $asset
     * @param Image $image
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
        app('view')->addNamespace($addon->getNamespace(), $addon->getPath('resources/views'));

        if (app('files')->isDirectory($addon->getPath('resources/config'))) {
            foreach (app('files')->allFiles($addon->getPath('resources/config')) as $file) {

                if (!$file instanceof \SplFileInfo) {
                    continue;
                }

                $key = ltrim(
                    str_replace(
                        $addon->getPath('resources/config'),
                        '',
                        $file->getPath()
                    ) . '/' . $file->getBaseName('.php'),
                    '/'
                );

                app('config')->set(
                    $addon->getNamespace($key),
                    app('files')->getRequire($file->getPathname())
                );
            }
        }

        app('translator')->addNamespace($addon->getNamespace(), $addon->getPath('resources/lang'));

        $this->asset->addNamespace($addon->getNamespace(), $addon->getPath('resources'));
        $this->image->addNamespace($addon->getNamespace(), $addon->getPath('resources'));
    }
}
