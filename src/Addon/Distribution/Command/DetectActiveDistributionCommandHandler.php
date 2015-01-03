<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command;

use Anomaly\Streams\Platform\Addon\Distribution\Distribution;
use Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;

/**
 * Class DetectActiveDistributionCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Distribution\Command
 */
class DetectActiveDistributionCommandHandler
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
     * The loaded distributions.
     *
     * @var DistributionCollection
     */
    protected $distributions;

    /**
     * Create a new DetectActiveDistributionCommandHandler instance.
     *
     * @param DistributionCollection $distributions
     */
    public function __construct(Asset $asset, Image $image, DistributionCollection $distributions)
    {
        $this->asset         = $asset;
        $this->image         = $image;
        $this->distributions = $distributions;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /**
         * If we have an active distribution then add
         * all it's namespaces to all our utilities.
         */
        if ($distribution = $this->distributions->active()) {
            $this->setDistributionNamespaces($distribution);
        }
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
