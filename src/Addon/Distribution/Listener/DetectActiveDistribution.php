<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Listener;

use Anomaly\Streams\Platform\Addon\Distribution\Distribution;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;

/**
 * Class DetectActiveDistribution
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class DetectActiveDistribution
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
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The services container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new DetectActiveDistribution instance.
     *
     * @param Asset      $asset
     * @param Image      $image
     * @param Repository $config
     * @param Container  $container
     */
    public function __construct(Asset $asset, Image $image, Repository $config, Container $container)
    {
        $this->asset     = $asset;
        $this->image     = $image;
        $this->config    = $config;
        $this->container = $container;
    }


    /**
     * Handle the event.
     */
    public function handle()
    {
        /* @var Distribution $distribution */
        $distribution = $this->container->make(config('streams.distribution'))->setActive(true);

        $this->container->make('view')->addNamespace('distribution', $distribution->getPath('resources/views'));
        $this->container->make('translator')->addNamespace('distribution', $distribution->getPath('resources/lang'));

        $this->asset->addNamespace('distribution', $distribution->getPath('resources'));
        $this->image->addNamespace('distribution', $distribution->getPath('resources'));
    }
}
