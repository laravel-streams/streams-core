<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command\Handler;

use Anomaly\Streams\Platform\Addon\Distribution\Distribution;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Container\Container;

/**
 * Class DetectActiveDistributionHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Distribution\Command
 */
class DetectActiveDistributionHandler
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
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new DetectActiveDistributionHandler instance.
     *
     * @param Asset     $asset
     * @param Image     $image
     * @param Container $container
     */
    public function __construct(Asset $asset, Image $image, Container $container)
    {
        $this->asset     = $asset;
        $this->image     = $image;
        $this->container = $container;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $distribution = app(config('streams.distribution'))->setActive(true);

        $this->setDistributionNamespaces($distribution);
    }

    /**
     * Set the "distribution" namespace.
     *
     * @param Distribution $distribution
     */
    protected function setDistributionNamespaces(Distribution $distribution)
    {
        app('view')->addNamespace('distribution', $distribution->getPath('resources/views'));
        app('translator')->addNamespace('distribution', $distribution->getPath('resources/lang'));

        $this->asset->addNamespace('distribution', $distribution->getPath('resources'));
        $this->image->addNamespace('distribution', $distribution->getPath('resources'));
    }
}
